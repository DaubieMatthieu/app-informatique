<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/accueil/Accueil_utilisateur.css" />
		<title> Utilisateur </title>
	</head>

	<body>

		<?php include("../headerfooter/Header_logged_in.php"); ?>

		<section>
			<h1> <?php echo "Bienvenue " . $_SESSION['prenom'] . " " . $_SESSION["nom"] ?> </h1></br>
			<table>
				<tr>
					<th>Numéro du test</th>
					<th>Résultats</th>
					<th>Action</th>
				<tr>
					<td>""</td>
					<td>""</td>
					<td>""</td>
				</tr>
				<tr>
					<td>""</td>
					<td>""</td>
					<td>""</td>
				</tr>
			</table>
		</section>

		<?php include("../headerfooter/Footer.php"); ?>

	</body>
</html>
