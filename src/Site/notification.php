<?php
$titre = 'Notification';
$nbrNotification = 20;

require('./outillage/fonctions.php');

$connexion = gestionConnexionUtilisateur();
require_once("./include/head.php")

?>

<body>
<div class="container">
    <!-- Barre de navigation de la page notification -->
    <?php include_once("./include/navbar.php") ?>

    <!-- section principale -->
    <main>
        <!-- Visuel sur les notifications recues par l'utilisateur -->

        <?php include_once("./include/notification.php"); ?>
    </main> 
</div>
</body>
</html>