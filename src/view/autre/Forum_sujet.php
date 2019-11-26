<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/Forum_sujet.css"/>
		<script src='../../public/js/autre/Forum_sujet.js'></script>
		<title>Sujets Forum</title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

    <?php
    if (!isset($_SESSION['id_utilisateur'])) {header('Location:../loggedout/Connexion.php');exit;} else {$id_utilisateur=$_SESSION['id_utilisateur'];}
    ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<!--section sujets-->

    <section>


			<!--section affichage tableau des utilisateurs-->

			<?php
			// connexion à la base de données
			include('../model/db_connect.php');
			$db = db_connect();
			if ($db===false) {
				?><script> show_message('Connexion à la base de donnée impossible','red'); </script><?php
				exit;
			}

			try {
				if (!isset($_GET['id_sujet'])) {header('Location:../autre/Forum.php?error=6');exit;}
          $id_sujet=$_GET['id_sujet'];
					$req = "SELECT titre FROM sujet_forum WHERE id_sujet=$id_sujet";
				  $rep = $db->query($req);
					if($rep->rowCount() == 0) {header('Location:../autre/Forum.php?error=6');exit;}
          $titre=$rep->fetch();
          echo '<h1>'.$titre['titre'].'</h1>';
			} catch (Exception $e)
			{
				?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
				exit;
			}

      $req2="SELECT * FROM message_forum WHERE id_sujet=$id_sujet ORDER BY date_poste ASC";
      $rep2=$db->query($req2);
			?>
				<div id="conversation">

					<a id="first_message"></a>
					<?php
	      	while ($infos_message=$rep2->fetch()) {?>
            <div class=
            <?php
            if ($infos_message['id_utilisateur']==$id_utilisateur) {echo 'message_self';} else {echo 'message_other';}
            ?>
            >
              <?php
              try {
                $id_utilisateur_message=$infos_message['id_utilisateur'];
                $req3 = "SELECT nom, prenom, role FROM utilisateur where id_utilisateur=$id_utilisateur_message";
                $rep3 = $db->query($req3);
                $user=$rep3->fetch();
								include_once('../../model/convert_role.php');
								$role=char_to_str($user['role']);
								if ($role=='error') {
									?><script type="text/javascript"> show_message("Erreur serveur au message d'id="+<?php echo $infos_message['id_message'] ?>,'red'); </script><?php
								} else {
									?>
									<br>
									<div class="utilisateur"><?php echo $user['prenom']." ".$user['nom'].'<br>'.char_to_str($user['role']);?></div>
									<div class="date"><?php echo date('d/m/Y', strtotime($infos_message['date_poste'])).'<br>'.date('H:i', strtotime($infos_message['date_poste'])); ?></div>
									<div class="texte"><?php echo $infos_message['message']; ?></div>
									<?php
								}
              } catch (Exception $e)
              {
                ?><script type="text/javascript">
                show_message("Erreur serveur au message id="+<?php echo $infos_message['id_message'] ?>,'red');
                </script><?php
              }
              ?>
            </div>
	      	<?php
					}
					?>
					<a id="last_message"></a>
        </div>

				<button type='button' id='new_message' onclick='show_new_message_form()'>Répondre</button>

		</section>

		<div id="new_message_form">
			<form action="../../controller/message_post.php" method="POST">
				<h1>Répondre</h1>

				<input name='id_sujet' type='hidden' value=<?php echo $id_sujet; ?>>
				<textarea name='message' rows="5" cols="33" placeholder="Rédiger une réponse" minlength='1' required></textarea>
				<br><br>
				<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_new_message_form()">
			</form>
		</div>

		<?php include("../general/Footer.php"); ?>

	</body>

</html>
