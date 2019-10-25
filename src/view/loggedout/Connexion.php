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
				<form action="../../controller/signin.php" method="post">
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
									if($err==1 || $err==2)
											echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
							}
							?>

						</br><a href="Inscription.php">S'inscrire</a>

					</form>
			</div>
		</section>

		<?php include("../headerfooter/footer.php"); ?>


	</body>
</html>
