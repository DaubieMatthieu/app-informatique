<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="Profil.css" />
		<title> Profil </title>
	</head>

	<body>

		<?php include("header.php"); ?>

		<section>
			<form method="post" action="Profil.php">
				<div id="conteneur">
					<input type="text" name="Nom" placeholder="Entrez votre nom" size="32" maxlength="32" autofocus required />
					<input type="text" name="Prénom" placeholder="Entrez votre prénom" size="32" maxlength="32" required />
					<input type="email" name="Mail" placeholder="Entrez votre mail" size="32" maxlength="32" required />
					<input type="Password" name="Mdp" placeholder="Entrez votre mot de passe" size="32" minlength="5" maxlength="32" required />
				</div>
				<input type="Submit" Value=Modifier />
			</form>
		</section>

		<?php include("footer.php"); ?>

	</body>
</html>
