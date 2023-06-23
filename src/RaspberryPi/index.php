<?php
require_once 'Capteur.php';
require_once 'outils.php';

// declaration des capteurs
    $P1ConsoE = new Capteur(21, "P1ConsoE", 1, "nbr"); // id domoticz, nom, salle, type
    $P1KwhMeter = new Capteur(22, "P1KwhMeter", 1, "nbr");
    $MLuminosite = new Capteur(25, "MLuminosite", 1, "nbr");
    $MTemperature = new Capteur(24, "MTemperature", 1, "Temp");
    $BAlerte = new Capteur(6, "BAlerte", 1, "bool");
    $DoorSensor = new Capteur(57, "DoorSensor", 1, "bool");

    $tableauCapteurs = array($P1ConsoE, $P1KwhMeter, $MLuminosite, $MTemperature, $BAlerte, $DoorSensor);



// Création des objets Capteur et ajout des mesures dans la base de données
foreach ($tableauCapteurs as $capteur) {
    choixAjoutMesure(lectureApi($capteur->getIdentifiant()), $capteur);
}
?>
