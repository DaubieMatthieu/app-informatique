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

		<?php
    if (!isset($_SESSION['id_utilisateur'])) {header('Location:../loggedout/Connexion.php');exit;} else {$id_utilisateur=$_SESSION['id_utilisateur'];}
    ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<!--section sujets-->

    <section>

			<!--section recherche sujet-->

			<nav>
				<h1> Forum </h1></br>
				<form method="post" action="Forum_admin.php">
					<input type="search" name="search" autocomplete="off" placeholder="Rechercher un sujet" size="64" maxlength="64"/>
				</form><br>
				<button type='button' id='new_subject' onclick='show_new_subject_form()'>Nouveau sujet</button>
			</nav>

			<!--section affichage tableau des utilisateurs-->

			<?php
			// connexion à la base de données
			include('../../model/db_connect.php');
			$db = db_connect();
			if ($db===false) {
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
								$id_sujet=$sujet['id_sujet'];
								?>
	              <div class='sujet'>
	                <a href="Forum_sujet_admin.php?id_sujet=<?php echo $id_sujet;?>"><button>
	                  <?php
	                  try {
	                    $id_utilisateur=$sujet['id_utilisateur'];
	                    $req2 = "SELECT nom, prenom FROM utilisateur where id_utilisateur=$id_utilisateur";
	                    $rep2 = $db->query($req2);
	                    $user=$rep2->fetch();
											$titre_sujet=$sujet['titre'];
											$date_creation_sujet=date('d/m/Y H:i', strtotime($sujet['date_creation_sujet']));
											$prenom=$user['prenom'];
											$nom=$user['nom'];
	                    ?>
	                    <h3><?php echo $titre_sujet; ?></h3><p></br></p>
	                    <div class="utilisateur"><?php echo $prenom." ".$nom; ?></div>
											<div class="date"><?php echo $date_creation_sujet; ?></div>
	                    <?php
										$titre_sujet=addslashes($titre_sujet);
										$prenom=addslashes($prenom);
										$nom=addslashes($nom);
		                } catch (Exception $e)
	                  {
	                    ?><script type="text/javascript">
	                    show_message("Erreur serveur au sujet id="+<?php echo $id_sujet ?>,'red');
	                    </script><?php
	                  }
	                ?>
								</button></a>
								<?php
								if ($_SESSION['role']=='A') {
									?>
									<div class="delete"><button onclick="show_delete_form(<?php echo "$id_sujet".','."'$titre_sujet'".','."'$date_creation_sujet'".','."'$prenom'".','."'$nom'" ; ?>)"></button></div>
									<?php
								}
								?>
								</div>
				      	<?php
							}
							?>
				</div>
			<?php
			}
			?>

		</section>

		<!--formulaire création sujet-->

		<div id="new_subject_form">
			<form action="../../controller/create_new_subject.php" method="POST">
				<h1>Nouveau sujet</h1>

				<label><b>Titre :</b></label>
				<input type="text" name="titre" placeholder="Entrer le titre" minlength=5 required>
				<br>
				<label><b>Description :</b></label><br>
				<textarea name='message' rows="5" cols="33" placeholder="Rédiger un premier message" minlength='5' required></textarea>
				<br><br>
				<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_new_subject_form()">
			</form>
		</div>

		<!--formulaire suppression utilisateur-->


		<?php
		if ($_SESSION['role']=='A') {
			?>
			<div id="delete_form">
				<form action="../../controller/admin_delete_subject.php" method="POST">
					<h1>Supprimer</h1><br>

					<label><b>Id du sujet:</b></label>
					<input type="number" name="id_sujet" readonly='readonly' required>
					<br><br>
					<label><b>Titre du sujet :</b></label>
					<input type="email" name="titre_sujet" readonly="readonly" required>
					<br><br>
					<label><b>Date de création du sujet :</b></label>
					<input type="text" name="date_creation_sujet" readonly="readonly" required>
					<br><br>
					<label><b>Prénom de l'utilisateur :</b></label>
					<input type="text" name="prenom" readonly="readonly" required>
					<br><br>
					<label><b>Nom de l'utilisateur :</b></label>
					<input type="text" name="nom" readonly="readonly" required>
					<br><br>
					<p style="color:#59adde;text-align:center;">Voulez-vous vraiment supprimer ce sujet ?</p>
					<br><br>
					<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_delete_form()">
				</form>
			</div>
			<?php
		}
		?>

		<?php include("../general/Footer.php"); ?>

	</body>

</html>
