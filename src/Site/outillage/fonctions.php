<?php  require('constante.php'); ?>
<?php
const MAX = 3; // nombre maximum de salle chez les cinema clients
/*
 * Fonction qui recupere un tableau de notification depuis la BD, puis le retourne
 */
function getNotifications($connexion, $nbr, $salle = null) {
    $query = "SELECT n.IdNotif, n.TitreNotif, n.ContenuNotif, s.IdSalle AS Salle, m.ValeurMesure AS Valeur, m.UniteMesure AS unite, c.NomCapteur
               FROM Notification n
               JOIN Mesure m ON n.IdMesure = m.IdMesure
               JOIN Capteur c ON m.IdCapteur = c.IdCapteur
               JOIN Salle s ON c.IdSalle = s.IdSalle";

    if ($salle !== null) {
        $query .= " WHERE s.IdSalle = ".$salle;
    }

    $query .= " ORDER BY n.IdNotif DESC LIMIT ".$nbr;

    return mysqli_query($connexion, $query);
}

/*
 * Fonction qui affiche les cartes de la page d'accueil avec les valeurs des mesures correspondantes
 */
function afficheCartes($connexion) {
    $i = 1;
    while($i <= MAX) { // on agit sur des petits cinema, ayant maximum 6 salles
        echo "<div class=\"salle\">";
        echo "<h2 class=\"titre_salle\">Salle $i</h2>";
        echo "<div class=\"donnees\">";
        echo "<div class=\"donnee\">";
        echo "<p>Temp&eacute;rature</p>";
        echo "<p class=\"valeur\">".getMesure($connexion, $i, "[M] Temperature")."</p>";
        echo "</div>";
        echo "<div class=\"donnee\">";
        echo "<p>Luminosit&eacute;</p>";
        echo "<p class=\"valeur\">".getMesure($connexion, $i, "[M] Luminosite")."</p>";
        echo "</div>";
        echo "<div class=\"donnee\">";
        echo "<p>Humidit&eacute;</p>";
        echo "<p class=\"valeur\">".getMesure($connexion, $i, "[M] Humidite")."</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        $i++;
    }
}

/*
 * Fonction qui recupere les mesures de la BD et les retourne, sinon retourne "---"
 */
function getMesure($connexion, $salle, $nomMesure) {
    $query = "SELECT Mesure.ValeurMesure, Mesure.UniteMesure
              FROM Mesure 
              JOIN Capteur ON Mesure.IdCapteur = Capteur.IdCapteur
              JOIN Salle ON Capteur.IdSalle = Salle.IdSalle 
              WHERE NomMesure = '$nomMesure' AND Capteur.IdSalle = '$salle'
              ORDER BY Mesure.IdMesure DESC LIMIT 1";

    $resultat = mysqli_query($connexion, $query);
    $m = mysqli_fetch_array($resultat);

    if ($m == null) {
        return "---";
    } else {
        return $m["ValeurMesure"]." ".$m["UniteMesure"];
    }
}

/*
 * Fonction permettant de vérifier si le login (pseudo) et le mot de passe (pwd) entrés par l'utilisateur sont corrects.
 * Si oui on redirige vers en prenant garde à remplir la variable de session avec le pseudo
 * Si non on redirige vers la page de login
 */
function verifieProfil($connexion, $pseudo, $pwd) {
    $query = "select count(*) as nb from Utilisateur where Pseudo ='" . $pseudo . "' and MotDePasse='" . $pwd . "'";

    $resultat = mysqli_query($connexion, $query);

    if ($resultat) {
        while ($m = mysqli_fetch_array($resultat)) {
            if ($m['nb'] == 1) {
                /* L'utilisateur est bien logué, on initialise la session et on redirige */
                session_start();
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['message'] = '';
                header("Location:../accueil.php");
                exit();
            } else {
                session_start();
                $_SESSION['message'] = 'Login ou mot de passe incorrect';
                header("Location:../login.php");
            }
        }
    } else {
        echo "<p>Erreur dans l'exécution de la requête.<br>";
        echo "Message du serveur de base de données : " . mysqli_error($connexion);
    }
}

/*
 * fonction qui permet d'acceder au page du site, seulement si il s'est connecté
 * sinon il ramene sur la page de login avec un message d'erreur
 */
function gestionConnexionUtilisateur() {
    // code PHP permettant de gérer le fait que l'utilisateur est bien logué et la connection à la BD pour la page.
    // Le login est stocké en variable de session si l'utilisateur est correctement logué.

    session_start(); // obligatoire de prolonger la session

    if (empty($_SESSION['pseudo'])) { // S'il n'y a rien dans la variable de session, on redirige vers la page de login
        $_SESSION['message']="Vous n'avez pas le droit d'accéder à cette page";
        header("Location:login.php"); // on redirige vers login
    } else {
        $pseudo = $_SESSION['pseudo'];
    }

    $connexion = mysqli_connect(SERVEUR, NOM, PASSE,BD);
    if (!$connexion) {
        echo "<p>Problème : Connexion au serveur ".SERVEUR." ou à la base ".BD." impossible. <br> Erreur : ".mysqli_error()."</p>";
    }

    return $connexion;
}

/*
 * Fonction qui retourne la somme des mesures du mois precedent presente dans la BD
 */
function getMesureMoisPrecedent($connexion, $salle, $nomMesure) {
    $query = "SELECT ROUND(SUM(ValeurMesure)) AS SommeValeurs, Mesure.UniteMesure
              FROM Mesure
              JOIN Capteur ON Mesure.IdCapteur = Capteur.IdCapteur
              JOIN Salle ON Capteur.IdSalle = Salle.IdSalle
              WHERE NomMesure = '$nomMesure' AND Capteur.IdSalle = '$salle'
              AND YEAR(DateMesure) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH) 
              AND MONTH(DateMesure) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
";

    $resultat = mysqli_query($connexion, $query);
    $m = mysqli_fetch_array($resultat);

    if ($m == null) {
        return "---";
    } else {
        return $m["SommeValeurs"]." ".$m["UniteMesure"];
    }
}

/*
 * Fonction qui retourne la somme des mesures du mois courant presente dans la BD
 */
function getMesureMoisCourant($connexion, $salle, $nomMesure) {
    $query = "SELECT ROUND(SUM(ValeurMesure), 2) AS SommeValeurs, Mesure.UniteMesure
            FROM Mesure
            JOIN Capteur ON Mesure.IdCapteur = Capteur.IdCapteur
            JOIN Salle ON Capteur.IdSalle = Salle.IdSalle 
            WHERE NomMesure = '$nomMesure' AND Capteur.IdSalle = '$salle'
            AND YEAR(DateMesure) = YEAR(CURRENT_DATE()) 
            AND MONTH(DateMesure) = MONTH(CURRENT_DATE());";

    $resultat = mysqli_query($connexion, $query);
    $m = mysqli_fetch_array($resultat);
    if ($m == null) {
        return "---";
    } else {
        return $m["SommeValeurs"]." ".$m["UniteMesure"];
    }
}

/*
 * Fonction qui recupere le nombre de place dans la salle de cinema et le retourne
 */
function getNbPlaceSalle($connexion, $salle) {
    $query = "SELECT NbPlaces
              FROM Salle
              WHERE IdSalle = '$salle'";

    $resultat = mysqli_query($connexion, $query);
    $m = mysqli_fetch_array($resultat);

    if ($m == null) {
        return "---";
    } else {
        return $m["NbPlaces"];
    }
}

/*
 * Fonction qui recupere la specialite de la salle de cinema et la retourne
 */
function getSpecialiteSalle($connexion, $salle) {
    $query = "SELECT Specification FROM Salle WHERE IdSalle = '$salle'";

    $resultat = mysqli_query($connexion, $query);
    $m = mysqli_fetch_array($resultat);

    if ($m == null) {
        return "---";
    } else {
        return $m["Specification"];
    }
}


