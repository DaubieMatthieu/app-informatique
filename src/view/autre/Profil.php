<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/Profil.css" />
		<title> Profil </title>
	</head>

	<body>

		<?php include("../general/Header"); ?>

		<section>

			<div id="conteneur">
					<form action="../../controller/user_edit_self.php" method="post">
							<h1>Profil</h1>

							<label><b>Nom</b></label>
							<input type="text" value=<?php echo $_SESSION['nom'];?> name="nom" required>

							<label><b>Prénom</b></label>
							<input type="text" value=<?php echo $_SESSION['prenom'];?> name="prenom" required>

							<label><b>Email</b></label>
							<input type="email" value=<?php echo $_SESSION['adresse_mail'];?> name="adresse_mail" readonly="readonly" required>
							<p><em>Vous ne pouvez pas modifier votre adresse mail</em></p></br>

							<label><b>Mot de passe</b></label>
							<input type="password" value=<?php echo $_SESSION['mot_de_passe'];?> onfocus="this.value=''" name="mot_de_passe" minlength="5" required>

							<input type="submit" value='Valider' >

							<?php
							if(isset($_GET['erreur'])){
									$err = $_GET['erreur'];
									if($err==0) {
											echo "<p style='color:red'>Echec de la connexion à la base de donnée</p>";}
									if($err==3) {
											echo "<p style='color:red'>Donnée manquantes</p>";}
									if($err==4) {
											echo "<p style='color:red'>Echec de l'envoi du formulaire</p>";}
							}
							if(isset($_GET['success'])){
									$success = $_GET['success'];
									if($success==1){
											echo "<p style='color:green'>Données mises à jour</p>";}
									if($success==0){
											echo "<p style='color:red'>Erreur serveur 2</p>";}
							}
							?>

					</form>
			</div>
		</section>

		<?php include("../general/footer.php"); ?>


	</body>
</html>
