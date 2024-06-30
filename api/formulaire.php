<?php
// formulaire.php

// Inclusion de la configuration générale
include(__DIR__ . '/../config/config.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>WiFi Gratuit - Inscription</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <h2>Inscription WiFi Gratuit</h2>
    <form action="traitement.php" method="post">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div>
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="telephone">Numéro de téléphone :</label>
            <input type="tel" id="telephone" name="telephone">
        </div>
        <button type="submit">Soumettre</button>
    </form>

    <script src="./assets/script.js"></script>
</body>
</html>
