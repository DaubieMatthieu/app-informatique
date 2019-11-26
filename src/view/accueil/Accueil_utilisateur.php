<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/accueil/Accueil_utilisateur.css" />
		<title> Utilisateur </title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<section>

			<h1> <?php echo "Bienvenue " . $_SESSION['prenom'] . " " . $_SESSION["nom"] ?> </h1></br>

			<!--section affichage tableau des tests-->

			<?php
			// connexion à la base de données
			include('../model/db_connect.php');
			$db = db_connect();
			if ($db===false) {
				?><script> show_message('Connexion à la base de donnée impossible','red'); </script><?php
				exit;
			}

			$id_utilisateur = htmlspecialchars($_SESSION['id_utilisateur']);

			try {

				$req = "SELECT id_resultat, valeur, unite, score FROM resultat_test where id_utilisateur=$id_utilisateur";
				$rep = $db->query($req);

			} catch (Exception $e)
			{
				?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
				exit;
			}

			if ($rep->rowCount()==0)

			{
				?><script type="text/javascript"> show_message('Aucun résultat trouvé','orange'); </script><?php
			} else {

			?>

				<div id="tableau">
					<table>
						<thead>
							<tr>
								<th>Numéro du résultat</th>
								<th>Résultats</th>
							</tr>
						</thead>
						<tbody>
							<?php
			      	while ($resultats=$rep->fetch()) {
								?>
								<tr>
									<td><?php echo $resultats['id_resultat']; ?></td>
									<td><?php echo $resultats['valeur'].' '.$resultats['unite'].' / score: '.$resultats['score']; ?></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			<?php
			}
			?>

		</section>

		<?php include("../general/Footer.php"); ?>

	</body>
</html>
