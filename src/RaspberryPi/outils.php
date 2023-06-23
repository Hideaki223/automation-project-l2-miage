<?php
/*
 * Fonction qui a pour but de recuperer les informations de l'equipement
 * dont l'id est passé en parametre via l'api de domoticz, puis retourne
 * un tableau avec les donnees.
 */
function lectureApi($id) {

    $ch = curl_init("http://192.168.4.1:8080/json.htm?type=devices&rid=".$id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    // on retourne les valeurs stocker les donnees du json de domoticz dans le tableau response
    return json_decode($output);
}

/*
 * Fonction qui choisit quelle fonction utilise pour inserer les mesures des capteurs
 * en fonction du type de mesure qu'ils ont
 */
function choixAjoutMesure($response, $capteur) {
    switch ($capteur->getType()) { // choix possible : nbr, Temp, bool
        case "nbr":
            ajoutMesureNbr($response, $capteur);
            break;
        case "Temp":
            ajoutMesureTempHumidite($response, $capteur);
            break;
        case "bool":
            ajoutMesureBoolennes($response, $capteur);
            break;
        default:
            echo "Probleme d'ajout, le type n'existe pas";
            break;
    }
}

/*
 * Fonction qui insere les mesures dans la base de donnees avec avoir recuperer toutes les donnees
 * necessaire. Permet de factoriser le code, et evite de dupliquer des lignes
 */
function ajouterMesureCommune($response, $capteur, $nomM, $valeurM, $uniteM) {
    $dateM = new DateTime($response->result[0]->LastUpdate);
    $dateM = $dateM->format('Y-m-d H:i:s');
    $idC = (int)$capteur->getIdBD();

    $sql = "INSERT INTO Mesure (NomMesure, ValeurMesure, UniteMesure, DateMesure, IdCapteur)
         VALUES ('$nomM', '$valeurM', '$uniteM', '$dateM', '$idC')";

    ajoutBD($sql);
}

/*
 * Fonction pour inserer les mesures des capteurs aillant le type "nbr"
 */
function ajoutMesureNbr($response, $capteur) {
    $nomM = $response->result[0]->Name;
    $valeurs = explode(" ", $response->result[0]->Data);
    $valeurM = (float)$valeurs[0];
    $uniteM = $valeurs[1];

    ajouterMesureCommune($response, $capteur, $nomM, $valeurM, $uniteM);

    estMesureNormale($valeurM, $uniteM, idDerniereMesure());
}

/*
 * Fonction pour inserer les mesures des capteurs aillant le type "bool"
 */
function ajoutMesureBoolennes($response, $capteur) {
    $nomM = $response->result[0]->Name;
    $valeurM = $response->result[0]->Data === "On" ? 1 : 0;
    $uniteM = "On/Off";

    ajouterMesureCommune($response, $capteur, $nomM, $valeurM, $uniteM);
}

/*
 * Fonction pour inserer les mesures des capteurs aillant le type "Temp"
 */
function ajoutMesureTempHumidite($response, $capteur) {
    $nomM = $response->result[0]->Name;
    $str = $response->result[0]->Data;

    $parts = explode(", ", $str);

    $temperature = explode(" ", $parts[0]);
    $valeur1 = $temperature[0];
    $unite1 = $temperature[1];

    $humidite = explode(" ", $parts[1]);
    $valeur2 = $humidite[0];
    $unite2 = $humidite[1];

    ajouterMesureCommune($response, $capteur, '[M] Temperature', $valeur1, $unite1);
    ajouterMesureCommune($response, $capteur, '[M] Humidite', $valeur2, $unite2);
}

/*
 * fonction qui recupere et renvoie l'identifiant de la derniere mesure realise
 * pour savoir si il faut ajouter une notification ou non
 */
function idDerniereMesure() {
    $sql = "select IdMesure from Mesure order by IdMesure desc limit 1";
    return recupererBD($sql);
}

/*
 * fonction qui realise la connexion a la BD, puis envoie la requete a la BD et ferme la connexion
 * Sa specificiter c'est de recuperer et de retourner l'id des mesures
 */
function recupererBD($sql) {

    $connexion = mysqli_connect(SERVEUR, NOM, PASSE, BD);

    if (!$connexion) {
        echo "la connexion ne marche pas";
    }

    $resultat = mysqli_query($connexion, $sql);

    if($resultat) {
        $m = mysqli_fetch_array($resultat);
        return $m["IdMesure"];
    } else {
        echo "t'as du travail".$sql." ".mysqli_error($connexion);
    }

    mysqli_close($connexion);
}


/*
 * fonction qui realise la connexion a la BD, puis envoie la requete a la BD et ferme la connexion
 */
function ajoutBD($sql) {

    $connexion = mysqli_connect(SERVEUR, NOM, PASSE, BD);

    if (!$connexion) {
        echo "la connexion ne marche pas";
    }

    $resultat = mysqli_query($connexion, $sql);

    if($resultat) {
        echo "ligne insérée";
    } else {
        echo "t'as du travail".$sql." ".mysqli_error($connexion);
    }

    mysqli_close($connexion);
}


/*
 * Fonctionne qui envoie la requete d'insertion de notification a la BD
 */
function insererNotification($titreNotif, $contenuNotif, $idMesure) {
    $sql = "insert into Notification (TitreNotif, ContenuNotif, IdMesure)
            values ('$titreNotif', '$contenuNotif', '$idMesure')";
    ajoutBD($sql);
}

/*
 * Fonction qui teste si les mesures sont comprises dans un ensembles de valeurs jugees normale :
 * Si c'est inferieur ou superieur a cet ensemble de valeurs, alors on insere un notification dans la BD
 */
function estMesureNormale($valeurMesure, $unite, $idMesure) {
    if($unite == "C") {
        if($valeurMesure <= 20 || $valeurMesure >= 24) {
            if($valeurMesure <= 20)
                insererNotification("Salle trop froid", "La salle est froide ".$valeurMesure, $idMesure);
	        else
		        insererNotification("Salle trop chaude", "La salle est chaude ".$valeurMesure, $idMesure);
	}
}

    if($unite == "%") {
        if($valeurMesure <= 40 || $valeurMesure >= 60) {
            if($valeurMesure <= 40)
                insererNotification("Salle peu humide", "La salle est peu humide ".$valeurMesure, $idMesure);
            else
                insererNotification("Salle trop humide", "La salle ets trop peu humide ".$valeurMesure, $idMesure);
        }
    }

    if($unite == "Lux") {
        if($valeurMesure <= 5 || $valeurMesure >= 100) {
            if($valeurMesure <= 5)
                insererNotification("Salle peu lumineuse", "La salle est trop peu lumineuse ".$valeurMesure, $idMesure);
            else
                insererNotification("Salle trop lumineuse", "La salle est trop peu lumineuse ".$valeurMesure, $idMesure);
        }
    }
}
?>
