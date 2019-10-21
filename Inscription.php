<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="Inscription.css" />
		<title> Inscription </title>
	</head>

	<body>

		<?php include("header.php"); ?>

		<section>
			<h1> S'inscrire </h1>
			<form method="post" action="Inscription.php">
				<div id="conteneur">
					<input type="text" name="Prénom" placeholder="Entrez votre prénom" size="32" maxlength="32" autofocus required />
					<input type="text" name="Nom" placeholder="Entrez votre nom" size="32" maxlength="32" required />
					<input type="email" name="Mail" placeholder="Entrez votre mail" size="32" maxlength="32" required />
					<input type="Password" name="Mdp" placeholder="Entrez votre mot de passe" size="32" minlength="5" maxlength="32" required />
				</div>
				<input id="Submit" type="Submit" Value="Valider" />
			</form>
		</section>

		<?php include("footer.php"); ?>
		
	</body>
</html>
