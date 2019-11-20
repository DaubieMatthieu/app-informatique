<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/loggedout/Inscription.css" />
		<title> Inscription </title>
	</head>

	<body>

		<?php
		session_start();
		session_destroy();
		include("../general/Header.php");
		include('../general/Message_serveur.php');
		?>

		<!--formulaire Inscription-->

		<?php
		$adresse_mail='';
		if (isset($_GET['adresse_mail'])) {$adresse_mail=$_GET['adresse_mail'];}
		?>

		<section>
			<div id="conteneur">
					<form action="../../controller/register.php" method="post">

							<h1>Inscription</h1>

							<label><b>Nom</b></label>
							<input type="text" placeholder="Entrer votre nom" name="nom" required autofocus>

							<label><b>Prénom</b></label>
							<input type="text" placeholder="Entrer votre prénom" name="prenom" required>

							<label><b>Email</b></label>
							<input type="email" placeholder="Entrer votre adresse mail" name="adresse_mail" value='<?php echo $adresse_mail; ?>' required>

							<label><b>Mot de passe</b></label>
							<input type="password" placeholder="Entrer votre mot de passe" name="mot_de_passe" autocomplete="new-password" minlength="5" required>

							<input type="submit" value='Valider' >

					</form>
			</div>
		</section>

		<?php include("../general/footer.php"); ?>


	</body>
</html>
