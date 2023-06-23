<?php
$titre = 'Salle 3';
$nbrNotification = 4;
$numeroSalle = 3;
require('./outillage/fonctions.php');
$connexion = gestionConnexionUtilisateur();
require_once("./include/head.php") ?>

<body>
<div class="container">
    <!-- Barre de navigation de la page d'accueil -->
    <?php include_once("./include/navbar.php") ?>

    <!-- section principale -->
    <!-- section principale -->
    <main>
        <div class="dashboard_salle">
            <h1><?php echo $titre ?></h1>
            <div class="cartes">

                <!-- Affichage des donnees du multisensor -->
                <div class="salle">
                    <h2 class="titre_salle">Multisensor</h2>
                    <div class="donnees">
                        <div class="donnee">
                            <p>Temp&eacute;rature</p>
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "[M] Temperature"); ?></p>
                        </div>
                        <div class="donnee">
                            <p>Luminosit&eacute;</p>
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "[M] Luminosite"); ?></p>
                        </div>
                        <div class="donnee">
                            <p>Humidit&eacute;</p>
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "[M] Humidite"); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Affichage des donnees du boutton -->
                <div class="salle">
                    <h2 class="titre_salle">Button</h2>
                    <div class="donnees">
                        <div class="donnee">
                            <p>Etat de la porte</p>
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "LevelV"); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Affichage des donnees de la consommation energetique -->
                <div class="salle">
                    <h2 class="titre_salle">Consommation énergetique</h2>
                    <div class="donnees">
                        <div>
                            <p class="sous-titre">Le mois en cours :</p>
                            <div class="donnee">
                                <p>Consommation en Watt</p>
                                <p class="valeur"><?php echo getMesureMoisCourant($connexion, $numeroSalle, "[P1] ConsoE"); ?></p>
                            </div>
                            <div class="donnee">
                                <p>Consommation en Kwh</p>
                                <p class="valeur"><?php echo getMesureMoisCourant($connexion, $numeroSalle, "[P1] kWh Meter"); ?></p>
                            </div>
                        </div>
                        <div>
                            <p class="sous-titre">Le mois dernier :</p>
                            <div class="donnee">
                                <p>Consommation en Watt</p>
                                <p class="valeur"><?php echo getMesureMoisPrecedent($connexion, $numeroSalle, "[P1] ConsoE"); ?></p>
                            </div>
                            <div class="donnee">
                                <p>Consommation en Kwh</p>
                                <p class="valeur"><?php echo getMesureMoisPrecedent($connexion, $numeroSalle, "[P1] kWh Meter"); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Affichage des donnees du doorsensor -->
                <div class="salle">
                    <h2 class="titre_salle">Door Sensor</h2>
                    <div class="donnees">
                        <div class="donnee">
                            <p>Etat de la porte</p>
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "[Doorsensor] AC"); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Affichage des donnees de la prise 1  -->
                <div class="salle">
                    <h2 class="titre_salle">Prise 1</h2>
                    <div class="donnees">
                        <div class="donnee">
                            <p>Consommation en Watt</p>
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "[P1] ConsoE"); ?></p>
                        </div>
                        <div class="donnee">
                            <p>Consommation en Kwh</p>
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "[P1] kWh Meter"); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Affichage des donnees de la prise 2  -->
                <div class="salle">
                    <h2 class="titre_salle">Prise 2</h2>
                    <div class="donnees">
                        <div class="donnee">
                            <p>Consommation en Watt</p>
                            <!-- On prend les mesure de la prise 1, car la prise ne fonctionne pas -->
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "[P1] ConsoE"); ?></p>
                        </div>
                        <div class="donnee">
                            <p>Consommation en Kwh</p>
                            <!-- On prend les mesure de la prise 1, car la prise ne fonctionne pas -->
                            <p class="valeur"><?php echo getMesure($connexion, $numeroSalle, "[P1] kWh Meter"); ?></p>
                        </div>
                    </div>
                </div>


                <!-- Affichage des informations de la salle  -->
                <div class="salle">
                    <h2 class="titre_salle">Information de la salle</h2>
                    <div class="donnees">
                        <div class="donnee">
                            <p>Nombre de places</p>
                            <p class="valeur"><?php echo getNbPlaceSalle($connexion, $numeroSalle); ?></p>
                        </div>
                        <div class="donnee">
                            <p>Spécialité de la salle</p>
                            <p class="valeur"><?php echo getSpecialiteSalle($connexion, $numeroSalle); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visuel sur les notifications recues par l'utilisateur -->
        <?php include_once("./include/notification.php"); ?>

    </main>
</div>
</body>
</html>