<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/modif_view.css">
		<title> Mentions légales </title>
    </head>
    <body>
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
                echo $mentionsLgls['contenu'];
			}
        ?>
    </body>
</html>