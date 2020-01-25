<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/modif_view.css">
		<title> Gérer les mentions légales </title>
	</head>

	<?php
	include("../../controller/session_start.php");//on ouvre la session de l'utilisateur
	reserved('Administrateur');//cette page est réservée aux administrateurs, ono vérifie que l'utilisateur en est un
	?>

	<body>

		<?php include("../general/Header.php"); ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

        <!--section gérer les CGU-->
        
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
            ?>

            <section>
                <nav>
                    <h1> Modifier les mentions légales </h1></br>
                    <form action="../../controller/modif_mentionslgls_controller.php" method="POST"> 
                        <?php
                            $mentionsLgls = $rep->fetch();
                            echo "<textarea name=\"mentionslgls\">".$mentionsLgls['contenu']."</textarea>";
                        ?>
                        <input type="submit" class='confirm' value='Valider'>
                </nav>
            </section>
			<?php
			}
			?>

        <?php include("../general/Footer.php"); ?>

    </body>
</html>