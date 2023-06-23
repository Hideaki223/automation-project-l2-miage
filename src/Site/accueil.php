<?php
$titre = 'Accueil'; // titre de la page, utiliser pour savoir quelle est la page courante par navbar.php
$nbrNotification = 4; // utiliser par notification.php pour savoir combien de notification il faut afficher au max
require('./outillage/fonctions.php'); // acces a toutes les fonctions / requete php
$connexion = gestionConnexionUtilisateur(); // requis pour pouvoir lancer les requete php
require_once("./include/head.php") //
?>

<body>
<div class="container">
    <!-- Inclusion du code php de la barre de navigation   -->
    <?php include_once("./include/navbar.php") ?>

    <!-- section principale -->
    <main>
        <div class="dashboard_accueil">
            <h1>Accueil</h1>
            <div class="cartes">
                <?php afficheCartes($connexion); ?></php>
            </div>
        </div>

        <!-- Inclusion du code php de la section notification -->
        <?php include_once("./include/notification.php") ?>
    </main> 
</div>
</body>
</html>