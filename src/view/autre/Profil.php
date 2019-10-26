<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/Profil.css" />
		<title> Profil </title>
	</head>

	<body>

		<?php include("../headerfooter/Header_logged_in.php"); ?>

		<section>

			<div id="conteneur">
					<form action="../../controller/change.php" method="post">
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

		<?php include("../headerfooter/footer.php"); ?>


	</body>
</html>
