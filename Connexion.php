<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="Connexion.css" />
		<title> Connexion </title>
	</head>

	<body>

		<?php include("header.php"); ?>

		<section>

			<div id="conteneur">
					<form action="check.php" method="POST">
							<h1>Connexion</h1>

							<label><b>Nom d'utilisateur (Email)</b></label>
							<input type="email" placeholder="Entrer le nom d'utilisateur" name="adresse_mail" required>

							<label><b>Mot de passe</b></label>
							<input type="password" placeholder="Entrer le mot de passe" name="mot_de_passe" required>

							<input type="submit" value='Login' >

							<?php
							if(isset($_GET['erreur'])){
									$err = $_GET['erreur'];
									if($err==1 || $err==2)
											echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
							}
							?>
					</form>
			</div>
		</section>

		<?php include("footer.php"); ?>


	</body>
</html>
