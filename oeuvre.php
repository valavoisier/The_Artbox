<?php
    require 'header.php';
    require 'bdd.php';

    $bdd = connexion();
    $requete = $bdd->prepare("SELECT * FROM oeuvres WHERE id = ?");
    $requete->execute([$_GET['id']]);
    $oeuvre = $requete->fetch();

    // Si l'URL ne contient pas d'id, on redirige sur la page d'accueil
    if(empty($_GET['id'])) {
        header('Location: index.php');
    }

    // Si aucune oeuvre trouvé, on redirige vers la page d'accueil
    if(is_null($oeuvre)) {
        header('Location: index.php');
    }
?>

<article id="detail-oeuvre">
    <div id="img-oeuvre">
        <img src="<?= htmlspecialchars($oeuvre['image']) ?>" alt="<?= htmlspecialchars($oeuvre['titre']) ?>">
    </div>
    <div id="contenu-oeuvre">
        <h1><?= htmlspecialchars($oeuvre['titre']) ?></h1>
        <p class="description"><?= htmlspecialchars($oeuvre['artiste']) ?></p>
        <p class="description-complete">
             <?= htmlspecialchars($oeuvre['description']) ?>
        </p>
    </div>
</article>

<?php require 'footer.php'; ?>
