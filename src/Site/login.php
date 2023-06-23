<?php  require('./outillage/fonctions.php');
 ?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>CineHome - Connexion</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles/login.css">
	<link rel="shortcut icon" href="src/Site/image/iconeLogin.ico">
</head>

<body>
	<div class="bloc">
		<!--bloc du formulaire d'inscription avec le titre-->
		<div class="contenu">	
			<div class="titre">
				<h1>Connexion</h1>
				<!--barre jaune en dessous du titre-->
				<div class="traitjaune"></div>
			</div>

			<?php
			// on remet à zero la session quelle que soit la façon dont on est arrivé sur cette page
			session_start();
			$_SESSION['pseudo']='';
			?>

			<!--formulaire d'inscription-->
			<form action="outillage/veriflogin.php" method="post">

				<!--bloc contenant l'input indentifiant-->
				<div class="groupe">
					<label for="pseudo"></label>
					<input type="text" name="pseudo" placeholder="Identifiant" required>

					<!--barre apparaissant en dessous de l'input-->
					<span class="barre"></span>
				</div>

				<!--bloc contenant l'input mot de passe-->
				<div class="groupe">
					<label for="pwd"></label>
					<input type="password" name="pwd" placeholder="Mot de passe" id="mdp" required>
					<div class="revelateur-mdp">
						<!--fonction permettant l'interaction entre l'oeil et l'affichage du mot de passe-->
						<script>
							function Oeil() {
							  var x = document.getElementById("mdp");
							  var y = document.getElementById("oeil");
							  if (x.type == "password") {
							    x.type = "text";
							    y.className = "oeil-ouvert";
							  } else {
							    x.type = "password";
							    y.className = "oeil-ferme";
							  }
							}
						</script>

						<!--bloc contenant l'oeil révélateur-->
						<div class="oeil-ferme" id="oeil" onclick="Oeil()">

						</div>
					</div>
					<!--bloc contenant l'input mot de passe-->
					<span class="barre"></span>
				</div>

				<!--bloc contenant le rester connecter et le mot de passe oublié?-->
				<div class="dessous-mdp">
					<div class="rester-connecte">
						<div class="case-a-cocher">
							<!--fonction de la checkbox personnalisée-->
							<script>
								function ResterConnecte() {
								  var z = document.getElementById("resterconnecte");
								  if (z.className == "noncoche") {
								    z.className = "coche";
								  } else {
								    z.className = "noncoche";
								  }
								}
							</script>
							<div class="noncoche" id="resterconnecte" onclick="ResterConnecte()"></div>
						</div>
						<div>
							<h6>Rester connecté</h6>
						</div>
					</div>
					<div>
						<a href="#" >Mot de passe oublié ?</a>
					</div>
				</div>
				<!--bouton se connecter qui envoie le formulaire-->
				<input type="submit" value="Se connecter">
				<p>
					<?php
					// message d'erreur dans le login ou lorsque l'utilisateur a essayé d'aller sur une page sans être logué
					echo "<p class=\"erreurConnexion\">".$_SESSION['message']."</p>"?>
				</p>
			</form>
		</div>
	</div>
</body>


</html>