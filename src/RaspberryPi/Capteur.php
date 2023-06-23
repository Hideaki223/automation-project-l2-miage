<?php
require_once('constante.php');
require_once('outils.php');

class Capteur {
    private $identifiant; //identifiant du capteur sur domoticz, pour utiliser l'api
    private $nom; //nom donne au capteur
    private $salle; //id de la salle dans laquelle il se situe
    private $type; //type de capteur, pour savoir avec quelle fonction on va ajouter ses mesures
    private $idBD; //id du capteur dans la BD, pour pouvoir ajouter des mesures dont il sert de cle etrangere


    /*
     * Constructeur du capteur dans lequel on va passer en parametre :
     * - son identifiant domoticz
     * - son nom
     * - l'id de la salle dans laquelle il est
     * - le type de mesure qu'il prend
     * Ensuite le capteur va etre ajoute dans la BD, et on va recuperer son identifiant dans la BD
     */
    public function __construct($identifiant, $nom, $salle, $type) {
        $this->identifiant = $identifiant;
        $this->nom = $nom;
        $this->salle = $salle;
        $this->type = $type;
        if(!$this->capteurExisteBD()) {
            $this->ajoutCapteur();
        }
	$this->idBD = $this->avoirIdentifiantBD();
    }

    /*
     * Cette fonction a pour objectif d'ajouter le capteur dans la base de donnes si il n'y ait pas
     * deja inscrit
     */
    public function ajoutCapteur() {
        if(!$this->capteurExisteBD()) {
            $sql = "insert into Capteur (NomCapteur, IdSalle)
                   VALUES ('$this->nom', '$this->salle')";
            ajoutBD($sql);
        }
    }

    /*
     * Cette fonction verifie si un capteur possedant le meme nom existe ou pas dans la BD
     * et returne un boolean
     * - True si le capteur existe
     * - False sinon
     */
    public function capteurExisteBD() {

        $sql = "SELECT NomCapteur FROM Capteur WHERE NomCapteur = '$this->nom'";
        $connexion = new mysqli(SERVEUR, NOM, PASSE, BD);

        if (!$connexion) {
            echo "La connexion ne fonctionne pas";
        }

        $resultat = mysqli_query($connexion, $sql);

        mysqli_close($connexion);

        return mysqli_num_rows($resultat) > 0;
    }

    /*
     * Fonction qui permet au capteur de recuperer son identifiant dans la BD
     * Il retourne l'identifiant en question
     */
    public function avoirIdentifiantBD() {
        $sql = "SELECT IdCapteur FROM Capteur WHERE NomCapteur = '$this->nom'";
        $m = [];
        $connexion = new mysqli(SERVEUR, NOM, PASSE, BD);

        if (!$connexion) {
            echo "La connexion ne fonctionne pas";
        }

        $resultat = mysqli_query($connexion, $sql);

        mysqli_close($connexion);
        if($resultat) {
            $m = mysqli_fetch_array($resultat);
        }
	
        return $m['IdCapteur'];
    }

    /*
     * getter qui retourne l'identifiant du capteur
     */
    public function getIdentifiant() {
	    return $this->identifiant;
    }

    /*
     * getter qui retourne le type du capteur
     */
    public function getType() {
	    return $this->type;
    }

    /*
     * getter qui retourne l'id du capteur dans la BD
     */
    public function getIdBD() {
	    return $this->idBD;
    }
}
