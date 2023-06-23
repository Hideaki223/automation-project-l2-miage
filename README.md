# Nom du projet
CineHome, projet de domotique pour cinema

# Quel service il rend ?
Projet réalisé durant le semestre 4 à Paul Sabatier.
Ce projet vise à améliorer le monitoring des salles de cinéma.

# Auteur
Guillaume HELG (responsable)  
Hugues ANSOBORLO  
Hugo FOLLIARD  
Adrien LANDRAS  
Kelian ELUECQUE  
Lucas GODARD  

# Dates clés
Date de début de projet : Vendredi 17 Février 2023  
Date de fin de projet : Lundi 22 Mai 2023

# Comment utiliser le projet
En tant qu'utilisateur, pour utiliser le projet, il vous suffit de vous connecter à la Raspberry Pi. Après vous être connecté, lancez le script bash en exécutant la commande "./script.sh" et fournissez les informations demandées. Ensuite, ouvrez votre navigateur et rendez-vous à l'adresse "192.168.4.1/login.php". Une fois là-bas, connectez-vous avec les identifiants suivants : nom d'utilisateur "Lorduser" et mot de passe "root". Vous pourrez ensuite utiliser notre système.

# Présentation du projet
La pandémie de COVID-19 a bousculé nos habitudes de consommation de films et de séries, nous contraignant à nous tourner vers les plateformes de streaming pour combler notre soif de divertissement. Avec la réouverture progressive des cinémas, la question du confort de visionnage se pose naturellement : est-il encore possible de rivaliser avec le confort de chez soi ?

C'est justement à cette problématique que répond notre projet.

Notre projet consiste en une amélioration et une optimisation du travail du personnel d’un cinéma par le biais d’un site web et de nos outils mis à leur disposition.

Pour faire cela, nous allons nous baser sur un ensemble d'appareils de domotique physique qui communiqueront avec un service distant tel qu'une base de données.

Les principaux utilisateurs de notre service sont donc tout le personnel d’un cinéma ainsi que leurs supérieurs (directeurs, etc.) qui peuvent accéder à des données qui sont visibles sur le site web et stockées dans une base de données. Des notifications sont aussi proposées pour les utilisateurs afin de les informer en temps réel lorsqu’ils ne sont pas sur le site web. Le client peut choisir le nombre de capteurs qu’il souhaite après avoir suivi les conseils de nos ingénieurs.

Les utilisateurs auront accès à un site web qui regroupe les informations des données recueillies. Celui-ci contient :
Une interface de domotique professionnelle.
Un tableau de bord des données mesurées par les capteurs en temps réel dans chaque salle du cinéma et s’actualisant chaque seconde sur le site.
Un tableau de consommation d’énergie par salle et plus généralement.
Un graphique des économies réalisées (actualisé chaque jour).
Un panneau de notifications avec un historique de celui-ci.
Un système de mise en avant d’une salle du cinéma en cas de données anormales.
Une page de paramètre pour l’utilisateur (ajout/suppression d’une salle de cinéma, lier des capteurs à une salle, activer/désactiver des fonctionnalités, personnaliser le profil des prises intelligentes, extinctions automatiques…).

Exemple : Le surveillant de salle aura accès à notre site. Dans lequel, il aura une vision globale de toutes les salles avec les mesures des salles en temps réel (température, luminosité, volume sonore, humidité) durant et en dehors des séances de cinéma. Lorsqu’un problème est détecté par notre système, le surveillant sera orienté vers la salle en question : température trop basse, volume sonore anormal, éléments perturbateurs.