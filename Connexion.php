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
			</br></br></br></br></br></br><h1> Connexion </h1></br></br></br></br>
			<form method="post" action="Connexion.php">
				<div id="conteneur">
					<input type="email" name="Login" placeholder="Entrez votre Login" size="32" maxlength="32" required autofocus />
					<input type="Password" name="Mdp" placeholder="Entrez votre mot de passe" size="32" minlength="5" maxlength="32" required />
				</div>
				</br></br><input id="Submit" type="Submit" Value="Se connecter" />
				</br><a href="Inscription.html">S'inscrire</a>
			</form>
		</section>

		
		<?php include("footer.php"); ?>


	</body>
</html>
