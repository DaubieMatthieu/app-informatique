<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/Profil.css" />
		<script src="../../public/js/autre/Profil.js"></script>
		<title> Profil </title>
	</head>

	<?php
	include("../../controller/session_start.php");//on ouvre la session de l'utilisateur
	?>

	<body>

		<?php include("../general/Header.php"); ?>

		<?php include("../general/Message_serveur.php");?>

		<section>

			<div id="conteneur">
				<h1>Profil</h1><br>

				<label><b>Nom</b></label>
				<div class='infos'><?php echo $_SESSION['prenom']." ".$_SESSION['nom'];?><button class="edit_button" onclick="show_edit_form('nom')"></div>

				<label><b>Email</b></label>
				<div class='infos'><?php echo $_SESSION['adresse_mail'];?><button class="edit_button" onclick="show_edit_form('adresse_mail')"></div>

				<label><b>Mot de passe</b></label>
				<div class='infos'><button class="edit_button" onclick="show_edit_form('mot_de_passe')"></div>

			</div>
		</section>

		<div class='edit_forms'>

			<div class="edit_nom">
				<form action="../../controller/user_edit_self.php" method="POST">

					<h1>Modifier le nom</h1><br>

					<label><b>Prénom :</b></label>
					<input type="text" name="prenom" value="<?php echo $_SESSION['prenom']?>" required>
					<br>
					<label><b>Nom :</b></label>
					<input type="text" name="nom" value="<?php echo $_SESSION['nom']?>" required>
					<br><br>
					<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_edit_form('nom')">

				</form>
			</div>

			<div class="edit_adresse_mail">
				<form action="../../controller/user_edit_self.php" method="POST">

					<h1>Modifier l'adresse mail</h1><br>

					<label><b>Adresse Mail :</b></label>
					<input type="text" name="nom" value="<?php echo $_SESSION['adresse_mail']?>" required>
					<br><br>
					<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_edit_form('adresse_mail')">

				</form>
			</div>

			<div class="edit_mot_de_passe">
				<form action="../../controller/user_edit_self.php" method="POST">

					<h1>Modifier le mot de passe</h1><br>

					<input type="password" name="password_old" placeholder="Saisissez votre mot de passe :" required>
					<br>
					<input type="password" name="password_new" placeholder="Nouveau mot de passe" autocomplete="new-password" minlength="5" required>
					<br>
					<input type="password" name="password_new_confirm" placeholder="Confirmez nouveau mot de passe" autocomplete="new-password" minlength="5" required>
					<br><br>
					<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_edit_form('mot_de_passe')">

				</form>
			</div>

		</div>


		<?php include("../general/Footer.php"); ?>


	</body>
</html>
