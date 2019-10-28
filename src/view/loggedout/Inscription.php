<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/loggedout/Inscription.css" />
		<title> Inscription </title>
	</head>

	<body>

		<?php include("../headerfooter/Header_logged_out.php"); ?>

		<section>

			<div id="conteneur">
					<form action="../../controller/register.php" method="post">
							<h1>Inscription</h1>

							<label><b>Nom</b></label>
							<input type="text" placeholder="Entrer votre nom" name="nom" required>

							<label><b>Prénom</b></label>
							<input type="text" placeholder="Entrer votre prénom" name="prenom" required>

							<label><b>Email</b></label>
							<input type="email" placeholder="Entrer votre adresse mail" name="adresse_mail" required>

							<label><b>Mot de passe</b></label>
							<input type="password" placeholder="Entrer votre mot de passe" name="mot_de_passe" minlength="5" required>

							<input type="submit" value='Valider' >

							<?php
							if(isset($_GET['erreur'])){
									$err = $_GET['erreur'];
									if($err==0) {
											echo "<p style='color:red'>Echec de la connexion à la base de donnée</p>";}
									if($err==1) {
											echo "<p style='color:red'>Erreur serveur 1</p>";}
									if($err==2) {
											echo "<p style='color:red'>Adresse mail déjà utilisée</p>";}
									if($err==3) {
											echo "<p style='color:red'>Donnée(s) manquante(s)</p>";}
									if($err==4) {
											echo "<p style='color:red'>Echec de l'envoi du formulaire</p>";}
							}
							if(isset($_GET['success'])){
									$success = $_GET['success'];
									if($success==1){
											echo "<p style='color:green'>Profil créée</p>";}
									if($success==0){
											echo "<p style='color:red'>Erreur serveur 2</p>";}
							}
							?>

					</form>
			</div>
		</section>

		<?php include("../headerfooter/footer.php"); ?>


	</body>
</html>
