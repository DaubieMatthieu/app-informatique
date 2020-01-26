<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/loggedout/CGU_Mentions.css">
		<title> Mentions légales </title>
	</head>
	
	<?php session_start(); ?>

    <body>
		<?php include("../general/Header.php"); ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<section>
			<h1>Mentions légales</h1>

			<?php
				//connexion à la base de données
				include('../../model/db_connect.php');
				$db = db_connect();
				if ($db===false) {
					?><script> show_message('Connexion à la base de donnée impossible','red'); </script><?php
					exit;
				}
				
				try {
					$req = "SELECT contenu FROM contenu_site WHERE type = 'Mentions légales'";
					
					$rep = $db->query($req);
				} catch (Exception $e){
					?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
					exit;
				}

				if ($rep->rowCount()==0){
					?><script type="text/javascript"> show_message('Aucun contenu trouvé pour les mentions légales','orange'); </script><?php
				} else {
					$mentionsLgls = $rep->fetch();   
					echo nl2br($mentionsLgls['contenu']);
				}

				include("../general/Footer.php");
			?>
		</section>
    </body>
</html>