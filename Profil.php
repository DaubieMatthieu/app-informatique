<?php
//En attendant que la BDD et l'authentification fonctionnent, on utilise une session fictive
session_start();

$_SESSION['nom'] = 'idk';
$_SESSION['prenom'] = 'Adibou';
$_SESSION['adresse_mail'] = 'adibou.idk@society';
$_SESSION['mot_de_passe'] = 'whocares';
$_SESSION['role'] = 'Utilisateur';
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="Inscription.css" />
		<title> Profil </title>
	</head>

	<body>

		<?php include("header_logged_in.php"); ?>

		<section>

			<div id="conteneur">
					<form action="change.php" method="post">
							<h1>Profil</h1>

							<label><b>Nom</b></label>
							<input type="text" value=<?php echo $_SESSION['nom'];?> name="nom" required>

							<label><b>Prénom</b></label>
							<input type="text" value=<?php echo $_SESSION['prenom'];?> name="prenom" required>

							<label><b>Email</b></label>
							<input type="email" value=<?php echo $_SESSION['adresse_mail'];?> name="adresse_mail" required>

							<label><b>Mot de passe</b></label>
							<input type="password" value=<?php echo $_SESSION['mot_de_passe'];?> name="mot_de_passe" minlength="5" required>

							<input type="submit" value='Valider' >

					</form>
			</div>
		</section>

		<?php include("footer.php"); ?>


	</body>
</html>
