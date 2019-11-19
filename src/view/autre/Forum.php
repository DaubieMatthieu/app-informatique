<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/Forum.css"/>
		<script src="../../public/js/autre/Forum.js"></script>
		<title>Sujets Forum</title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<!--section sujets-->

    <section>

			<!--section recherche sujet-->

			<nav>
				<h1> Forum </h1></br>
				<form method="post" action="Forum.php">
					<input type="search" name="search" autocomplete="off" placeholder="Rechercher un sujet" size="64" maxlength="64"/>
				</form><br>
				<button type='button' id='new_subject' onclick='show_new_subject_form()'>Nouveau sujet</button>
			</nav>

			<!--section affichage tableau des utilisateurs-->

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
				if (isset($_POST['search'])) {
					$search=$_POST['search'];
					$keywords=explode(' ', $search);
					$req = "SELECT * FROM sujet_forum WHERE 0";
					foreach($keywords as $keyword) {
						$req .= " OR concat(nom,prenom,adresse_mail) LIKE '%$keyword%'";
					}
					$req .=' ORDER BY date_creation_sujet DESC';
				} else {
					$req = "SELECT * FROM sujet_forum ORDER BY date_creation_sujet DESC";
				}
				$rep = $db->query($req);
			} catch (Exception $e)
			{
				?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
				exit;
			}

			if ($rep->rowCount()==0)
			{
				?><script type="text/javascript"> show_message('Aucun sujet trouvé','orange'); </script><?php
			} else {
			?>

				<div id="sujets">
							<?php
			      	while ($sujet=$rep->fetch()) {
							?>
              <div class='sujet'>
                <a href="Forum_sujet.php?id_sujet=<?php echo $sujet['id_sujet'];?>"><button>
                  <?php
                  try {
                    $id_utilisateur=$sujet['id_utilisateur'];
                    $req2 = "SELECT nom, prenom FROM utilisateur where id_utilisateur=$id_utilisateur";
                    $rep2 = $db->query($req2);
                    $user=$rep2->fetch();
                    ?>
                    <h3><?php echo $sujet['titre']; ?></h3><p></br></p>
                    <div class="utilisateur"><?php echo $user['prenom']." ".$user['nom'];?></div>
										<div class="date"><?php echo date('d/m/Y H:i', strtotime($sujet['date_creation_sujet'])); ?></div>
                    <?php
                  } catch (Exception $e)
                  {
                    ?><script type="text/javascript">
                    show_message("Erreur serveur au sujet id="+<?php echo $sujet['id_sujet'] ?>,'red');
                    </script><?php
                  }
                ?>
							</button></a>
              </div>
			      	<?php
							}
							?>
				</div>
			<?php
			}
			?>

		</section>

		<div id="new_subject_form">
			<form action="../../controller/create_new_subject.php" method="POST">
				<h1>Nouveau sujet</h1>

				<label><b>Titre :</b></label>
				<input type="text" name="titre" minlength=5 required>
				<br>
				<label><b>Description :</b></label>
				<input type="text" name="message" minlength=5 required>
				<br><br>
				<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_new_subject_form()">
			</form>
		</div>

		<?php include("../general/Footer.php"); ?>

	</body>

</html>
