<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/accueil/Accueil_gestionnaire.css" />
		<script src="../../public/js/accueil/Accueil_gestionnaire.js"></script>
		<title> Gestionnaire </title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

		<?php include("../general/Message_serveur.php"); ?>

		<section>
			<nav>
				<h1> <?php echo "Bienvenue " . $_SESSION['prenom'] . " " . $_SESSION["nom"] ?> </h1></br>

				<a href="../autre/Launchtest.php">Lancement test</a><!--
				--><button type='button' class='pre_register_button' onclick='show_pre_register_form()'>Pré-inscription</button>
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
				$req1 = "SELECT DISTINCT id_utilisateur FROM `inscription` i1 WHERE EXISTS (Select id_entite from `inscription` i2 where i2.id_utilisateur = $id_gestionnaire AND i1.id_entite = i2.id_entite)";
				//$req1 = "SELECT id_utilisateur FROM inscription WHERE id_gestionnaire=$id_gestionnaire";
				$rep1 = $db->query($req1);
				$liste_utilisateurs=array(-1);
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
										<td><?php echo $user['nom']." ".$user['prenom']."<br>".$user['adresse_mail']; ?></td>
										<td><?php echo $rep3->rowCount(); ?></td>
										<td><button  class='detail_button' onclick="window.location.href='../autre/Gestionnaire_detail_utilisateur.php?id_utilisateur=<?php echo $id_utilisateur; ?>'"></button></td>
										<?php
									} catch (Exception $e)
									{
										?><script type="text/javascript">
										show_message("Erreur serveur à l'utilisateur id="+<?php echo $id_utilisateur ?>,'red');
										</script><?php
									}
								?></tr><?php
							}
							?>
						</tbody>
					</table>
				</div>
			<?php
			}
			?>

		</section>

		<div id="pre_register_form">
			<form action="../../controller/pre_register.php" method="POST">

				<h1>Pré-inscrire un utilisateur</h1>

				<label><b>Email :</b></label>
				<input type="email" name="adresse_mail" required>
				<p>Un lien d'inscription sera envoyé à cette adresse mail</p>
				<br>

				<label><b>Etablissement :</b></label>
				<select name='id_entite'>
					<?php
				  $req = $db->prepare("SELECT entite.id_entite, nom from entite INNER JOIN inscription ON entite.id_entite =  inscription.id_entite where id_utilisateur=:id_gestionnaire");
				  $req->bindValue(':id_gestionnaire',$id_gestionnaire, PDO::PARAM_STR);
				  $req->execute();
					while ($entite=$req->fetch()) {
						echo "<option value=".$entite['id_entite'].">".$entite['nom']."</option>";
					}
					?>
				</select>
				<br><br>
				<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_pre_register_form()">

			</form>
		</div>

		<?php include("../general/Footer.php"); ?>

	</body>
</html>
