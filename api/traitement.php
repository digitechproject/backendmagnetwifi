<?php
// traitement.php

// Inclusion de la configuration et de la bibliothèque RouterOS
include(__DIR__ . '/../config/config.php');
include(__DIR__ . '/../config/routeros_api.class.php');

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone']; // Facultatif, donc pas de "required"

    // Validation des données (ajoutez ici vos propres règles de validation)
    // Exemple de validation simple de l'e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("L'adresse e-mail n'est pas valide."); 
    }

    // Préparation des données pour l'envoi via webhook
    $donnees = array(
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone
    );

    // Envoi des données via webhook
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($donnees)
        )
    );
    $context  = stream_context_create($options);
    $resultat = file_get_contents(WEBHOOK_URL, false, $context);
    if ($resultat === FALSE) {
        // Gestion de l'erreur d'envoi du webhook (log, message à l'utilisateur, etc.)
        die("Erreur lors de l'envoi des données.");
    }

    // Connexion au routeur MikroTik
    $API = new RouterosAPI();
    $API->debug = false; // Désactiver le mode débogage en production
    if ($API->connect(ROUTER_IP, ROUTER_USERNAME, ROUTER_PASSWORD, 8728)) {
        // Génération d'un code WiFi aléatoire à 4 caractères
        $code_wifi = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);

        // Création de l'utilisateur sur le routeur (profile 500-48h, validité 2 jours)
        $API->comm("/ip/hotspot/user/add", array(
            "name" => $code_wifi,
            "password" => $code_wifi,
            "profile" => "48h500", 
            "limit-uptime" => "2d"
        ));

        // Déconnexion du routeur
        $API->disconnect();

        // Redirection vers la page de succès avec le code WiFi
        header("Location: ./api/succes.php?code_wifi=$code_wifi");
        exit();
    } else {
        // Gestion de l'erreur de connexion au routeur
        die("Erreur de connexion au routeur.");
    }
} else {
    // Si le formulaire n'a pas été soumis, rediriger vers le formulaire
    header("Location: ./api/formulaire.php");
    exit();
}
