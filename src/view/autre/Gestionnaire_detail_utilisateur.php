<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/Gestionnaire_detail_utilisateur.css">
		<title> Détail utilisateur </title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<section>

      <?php
      $id_utilisateur=$_GET['id_utilisateur'];
      $id_gestionnaire=$_SESSION['id_utilisateur'];
			// connexion à la base de données
			include('../../model/db_connect.php');
			$db = db_connect();
			if ($db===false) {
				?><script> show_message('Connexion à la base de donnée impossible','red'); </script><?php
				exit;
			}
      try {
      $req = "SELECT prenom, nom FROM utilisateur where id_utilisateur=$id_utilisateur";
			$rep = $db->query($req);
      $id= $rep->fetch(PDO::FETCH_ASSOC);
      $nom=$id['nom'];
      $prenom=$id['prenom'];
      $rep->closeCursor();
			} catch (Exception $e)
			{
				?><script type="text/javascript"> show_message("Erreur serveur",'red'); </script><?php
				exit;
			}
      ?>

			<h1> Détail de l'utilisateur <?php echo $prenom.' '.$nom?></h1></br>

			<!--section affichage tableau des résultats-->
      <?php
      try {
      $req = "SELECT id_resultat, valeur, unite, score FROM resultat_test where id_utilisateur=$id_utilisateur && id_gestionnaire=$id_gestionnaire";
			$rep = $db->query($req);

			} catch (Exception $e)
			{
				?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
				exit;
			}
			if ($rep->rowCount()==0)
			{
				?><script type="text/javascript"> show_message('Aucun test trouvé','orange'); </script><?php
			} else {
			?>

				<div id="tableau">
					<table>
						<thead>
							<tr>
								<th>Id du résultat</th>
								<th>Mesure</th>
								<th>Score</th>
							</tr>
						</thead>
						<tbody>
							<?php
			      	while ($resultat=$rep->fetch()) {
							?>
				        <tr>
			            <td><?php echo $resultat['id_resultat']; ?></td>
			            <td><?php echo $resultat['valeur'].$resultat['unite']; ?></td>
			            <td><?php echo $resultat['score']; ?></td>
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
