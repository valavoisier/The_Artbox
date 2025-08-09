<?php
//vérifier que les champs ne sont pas vides
//vérifier que la description fait au moins 3 caractères
//vérifier que l'URL de l'image est valide (formatlien https://)
//utiliser htmlspecialchars(); contre failles XSS

session_start();
require 'bdd.php';

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur CSRF: requête non autorisée.');
}
function sanitizedInput($data) {
    return htmlspecialchars(trim($data));
}
if (isset($_POST['submit'])) {
    $titre = sanitizedInput($_POST['titre']);
    $artiste = sanitizedInput($_POST['artiste']);
    $description = sanitizedInput($_POST['description']);
    $image = sanitizedInput($_POST['image']);

    // Vérification des champs
    if (empty($titre) || empty($artiste) || empty($description) || empty($image) || strlen($description) < 3 || !filter_var($image, FILTER_VALIDATE_URL) || !str_starts_with($image, 'https://')) {
       header('Location: ajouter.php');  
        exit;     
    }else{

    // Connexion à la base de données
    $bdd = connexion();
    
    // Insertion dans la base de données
    $requete = $bdd->prepare("INSERT INTO oeuvres (titre, artiste, description, image) VALUES (?, ?, ?, ?)");
    $requete->execute([$titre, $artiste, $description, $image]);

    header('Location: oeuvre.php?id=' . $bdd->lastInsertId());
    }
     exit;
}