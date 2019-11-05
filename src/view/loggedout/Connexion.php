<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/loggedout/Connexion.css" />
		<title> Connexion </title>
	</head>

	<body>

		<?php
		session_start();
		Session_destroy();
		include("../general/Header.php");
		?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<!--formulaire Inscription-->

		<section>
			<div id="conteneur">
				<form action="../../controller/login.php" method="post">

						<h1>Connexion</h1></br>

						<label><b>Nom d'utilisateur (Email)</b></label>
						<input type="email" placeholder="Entrer le nom d'utilisateur" name="adresse_mail" required autofocus>

						<label><b>Mot de passe</b></label>
						<input type="password" placeholder="Entrer le mot de passe" name="mot_de_passe" required>

						<input type="submit" value='Se connecter' >

						</br><a href="Inscription.php">S'inscrire</a>

					</form>
			</div>
		</section>

		<?php include("../general/footer.php"); ?>


	</body>
</html>
