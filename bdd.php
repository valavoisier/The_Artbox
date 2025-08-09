<?php
/* connexion à la BDD artbox et table oeuvres */
function connexion() {
    try {
        $pdo = new PDO('mysql:dbname=artbox;host=localhost', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}