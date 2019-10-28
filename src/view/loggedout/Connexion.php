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
		include("../headerfooter/Header_logged_out.php");
		?>

		<section>

			<div id="conteneur">
				<form action="../../controller/login.php" method="post">
						<h1>Connexion</h1>
						</br>
						<label><b>Nom d'utilisateur (Email)</b></label>
						<input type="email" placeholder="Entrer le nom d'utilisateur" name="adresse_mail" required>

						<label><b>Mot de passe</b></label>
						<input type="password" placeholder="Entrer le mot de passe" name="mot_de_passe" required>

						<input type="submit" value='Se connecter' >

							<?php
							if(isset($_GET['erreur'])){
									$err = $_GET['erreur'];
									if($err==0) {
											echo "<p style='color:red'>Echec de la connexion à la base de donnée</p>";}
									if($err==1) {
											echo "<p style='color:red'>Erreur serveur 1</p>";}
									if($err==2) {
											echo "<p style='color:red'>Adresse mail ou mot de passe incorrect</p>";}
									if($err==3) {
											echo "<p style='color:red'>Donnée(s) manquante(s)</p>";}
									if($err==4) {
											echo "<p style='color:red'>Echec de l'envoi du formulaire</p>";}
							}
							?>

						</br><a href="Inscription.php">S'inscrire</a>

					</form>
			</div>
		</section>

		<?php include("../headerfooter/footer.php"); ?>


	</body>
</html>
