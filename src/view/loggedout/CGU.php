<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/loggedout/CGU_Mentions.css">
		<title> CGU </title>
	</head>
	
	<?php session_start(); ?>

    <body>
		<?php include("../general/Header.php"); ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<section>
			<h1>Conditions générales d'utilisation</h1>

			<?php
				//connexion à la base de données
				include('../../model/db_connect.php');
				$db = db_connect();
				if ($db===false) {
					?><script> show_message('Connexion à la base de donnée impossible','red'); </script><?php
					exit;
				}
				
				try {
					$req = "SELECT contenu FROM contenu_site WHERE type = 'CGU'";
					
					$rep = $db->query($req);
				} catch (Exception $e){
					?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
					exit;
				}

				if ($rep->rowCount()==0){
					?><script type="text/javascript"> show_message('Aucun contenu trouvé pour les CGU','orange'); </script><?php
				} else {
					$cgu = $rep->fetch();   
					echo nl2br($cgu['contenu']);
				}

				include("../general/Footer.php");
			?>
		</section>
    </body>
</html>