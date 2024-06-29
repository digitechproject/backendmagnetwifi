<?php
// succes.php
include './config/config.php';
// Récupération du code WiFi depuis les paramètres de la requête
$code_wifi = $_GET['code_wifi'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>WiFi Gratuit - Succès</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <h2>Félicitations !</h2>
    <p>Vous êtes maintenant inscrit à notre WiFi gratuit.</p>
    <p>Votre code d'accès unique est :</p>
    <div class="code-wifi"><?php echo $code_wifi; ?></div>
    <p>Cliquez sur le bouton ci-dessous pour vous connecter automatiquement :</p>
    <a href="http://<?php echo ROUTER_IPP; ?>/login?username=<?php echo $code_wifi; ?>&password=<?php echo $code_wifi; ?>" class="btn-connect">Connexion</a>

    <script src="./assets/script.js"></script>
</body>
</html>
