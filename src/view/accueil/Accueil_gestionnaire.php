<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/accueil/Accueil_gestionnaire.css" />
		<title> Gestionnaire </title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

		<?php include("../general/Message_serveur.php"); ?>

		<section>
			<nav>
				<h1> <?php echo "Bienvenue " . $_SESSION['prenom'] . " " . $_SESSION["nom"] ?> </h1></br></br>
				<a href="../autre/Launchtest.php">Lancer un test</a>
			</nav>


			<?php

			$db_username = 'root';
			$db_password = '';
			$db_name     = 'infinite_sense';
			$db_host     = 'localhost';
			try
			{
				$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_username, $db_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
			} catch (Exception $e) {
				?><script> show_message('Connexion à la base de donnée impossible','red'); </script><?php
				exit;
			}

			try {
				$id_gestionnaire=$_SESSION['id_utilisateur'];
				$req1 = "SELECT id_utilisateur FROM resultat_test WHERE id_gestionnaire=$id_gestionnaire";
				$rep1 = $db->query($req1);
				$liste_utilisateurs=array();
				while ($user=$rep1->fetch()) {
					array_push($liste_utilisateurs, $user['id_utilisateur']);
				}
				 $liste_utilisateurs = array_unique ($liste_utilisateurs);
				 $liste_utilisateurs = implode(',',$liste_utilisateurs);

				$req2 = "SELECT * FROM utilisateur where id_utilisateur in ($liste_utilisateurs)";
				$rep2 = $db->query($req2);
			} catch (Exception $e)
			{
				?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
				exit;
			}

			if ($rep2->rowCount()==0)
			{
				?><script type="text/javascript"> show_message('Aucun utilisateur trouvé','orange'); </script><?php
			} else {
			?>

				<div id="tableau">
					<table>
						<thead>
							<tr>
								<th>Patient</th>
								<th>Nombre de tests effectués</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
			      	while ($user=$rep2->fetch()) {
							?>

				        <tr>
									<?php
									try {
										$id_utilisateur = $user['id_utilisateur'];
										$req3 = "SELECT id_resultat FROM resultat_test where id_utilisateur=$id_utilisateur && id_gestionnaire=$id_gestionnaire";
										$rep3 = $db->query($req3);
										?>
										<td><?php echo $user['nom']." ".$user['prenom']; ?></td>
										<td><?php echo $rep3->rowCount(); ?></td>
										<td><button  class='detail_button' onclick="window.location.href='../autre/Gestionnaire_detail_utilisateur.php?id_utilisateur=<?php echo $id_utilisateur; ?>'"></button></td>
										<?php
									} catch (Exception $e)
									{
										?><script type="text/javascript">
										show_message("Erreur serveur à l'utilisateur id="+<?php echo $id_utilisateur ?>,'red');
										</script><?php
									}
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
