<?php
//vérifier que les champs ne sont pas vides
//vérifier que la description fait au moins 3 caractères
//vérifier que l'URL de l'image est valide (formatlien https://)
//utiliser htmlspecialchars(); contre failles XSS
require 'bdd.php';
if (isset($_POST['submit'])) {
    $titre = htmlspecialchars(trim($_POST['titre']));
    $artiste = htmlspecialchars(trim($_POST['artiste']));
    $description = htmlspecialchars(trim($_POST['description']));
    $image = htmlspecialchars(trim($_POST['image']));

    // Vérification des champs
    if (empty($titre) || empty($artiste) || empty($description) || empty($image) || strlen($description) < 3 || !filter_var($image, FILTER_VALIDATE_URL)) {
       header('Location: ajouter.php');       
    }else{

    // Connexion à la base de données
    $bdd = connexion();
    
    // Insertion dans la base de données
    $requete = $bdd->prepare("INSERT INTO oeuvres (titre, artiste, description, image) VALUES (?, ?, ?, ?)");
    $requete->execute([$titre, $artiste, $description, $image]);

    header('Location: oeuvre.php?id=' . $bdd->lastInsertId());
    }
}