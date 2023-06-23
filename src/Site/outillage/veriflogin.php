<?php  require('fonctions.php'); ?>

<?php
      $connexion = mysqli_connect(SERVEUR, NOM, PASSE,BD);
      if (!$connexion)
      {
          echo "<p>Problème : Connexion au serveur ".SERVEUR." ou à la base ".BD." impossible. <br/> Erreur : ".mysqli_error()."</p>";

      }

      $pseudo = $_POST["pseudo"];
      $pwd = $_POST["pwd"];

      verifieProfil($connexion, $pseudo, $pwd);
?>