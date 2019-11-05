<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/accueil/Accueil_gestionnaire.css" />
		<title> Gestionnaire </title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

		<section>
			<nav>
				<h1> <?php echo "Bienvenue " . $_SESSION['prenom'] . " " . $_SESSION["nom"] ?> </h1></br></br>
				<a href="../autre/Launchtest.php">Lancer un test</a>
			</nav>
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

		<?php include("../general/Footer.php"); ?>

	</body>
</html>
