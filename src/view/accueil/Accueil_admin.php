<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/accueil/Accueil_admin.css">
		<script src="../../public/js/accueil/Accueil_admin.js"></script>
		<title> Gérer les utilisateurs </title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<!--section gérer les utilisateurs-->

		<section>

			<!--section recherche utilisateur-->

			<nav>
				<h1> Gérer les utilisateurs </h1></br>
				<form method="get" action="Accueil_admin.php">
					<input type="search" name="search" autocomplete="off" placeholder="Rechercher un utilisateur" size="64" maxlength="64"/>
				</form><br>
				<button type='button' class='pre_register_button' onclick='show_pre_register_form()'>Pré-inscription</button>
			</nav>

			<!--section affichage tableau des utilisateurs-->

			<?php
			//connexion à la base de données
			include('../../model/db_connect.php');
			$db = db_connect();
			if ($db===false) {
				?><script> show_message('Connexion à la base de donnée impossible','red'); </script><?php
				exit;
			}

			try {
				if (isset($_GET['search'])) {
					$search=$_GET['search'];
					$keywords=explode(' ', $search);
					$req = "SELECT * FROM utilisateur WHERE 0";
					foreach($keywords as $keyword) {
						$req .= " OR concat(nom,prenom,adresse_mail) LIKE '%$keyword%'";
					}
					$req .=' ORDER BY role DESC, nom ASC';
				} else {
					$req = "SELECT * FROM utilisateur ORDER BY role DESC, nom ASC";
				}
				$rep = $db->query($req);

			} catch (Exception $e)
			{
				?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
				exit;
			}

			if ($rep->rowCount()==0)
			{
				?><script type="text/javascript"> show_message('Aucun utilisateur trouvé','orange'); </script><?php
			} else {
			?>

				<div id="tableau">
					<table>
						<thead>
							<tr>
								<th>Prénom</th>
								<th>Nom</th>
								<th>Email</th>
								<th>Type d'utilisateur</th>
								<th>Action</th>
								<th>id</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
			      	while ($user=$rep->fetch()) {
							?>
				        <tr>
			            <td><?php echo $user['prenom']; ?></td>
			            <td><?php echo $user['nom']; ?></td>
			            <td><?php echo $user['adresse_mail']; ?></td>
									<?php
									include_once('../../model/convert_role.php');
									$role=char_to_str($user['role']);
									?>
									<td><?php echo $role; ?></td>
									<td>
										<?php
										if ($role!='Administrateur') {?>
											<div class="table_button">
												<button type='button' class='delete_button' onclick='show_delete_form(<?php echo $i ?>)'></button>
												<button type='button' class='edit_button' onclick='show_edit_form(<?php echo $i ?>)'></button>
											</div>
										<?php
									}
									?>
									</td>
									<td><?php echo $user['id_utilisateur'] ?></td>
								</tr>
			      	<?php
							$i++;
							}
							?>
						</tbody>
					</table>
				</div>
			<?php
			}
			?>

		</section>

		<!--formulaire suppression utilisateur-->

		<div id="delete_form">
			<form action="../../controller/admin_delete_user.php" method="POST">
				<h1>Supprimer</h1>

				<label><b>Id :</b></label>
				<input type="number" name="id_utilisateur" readonly='readonly' required>
				<label><b>Prénom :</b></label>
				<input type="text" name="prenom" readonly="readonly" required>
				<br>
				<label><b>Nom :</b></label>
				<input type="text" name="nom" readonly="readonly" required>
				<br>
				<label><b>Email :</b></label>
				<input type="email" name="adresse_mail" readonly="readonly" required>
				<br>
				<label><b>Rôle :</b></label>
				<input type="text" name="role" readonly="readonly" required>
				<br><br>
				<p style="color:#59adde;text-align:center;">Voulez-vous vraiment supprimer cet utilisateur ?</p>
				<br>
				<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_delete_form()">
			</form>
		</div>

		<!--formulaire edition utilisateu-->

		<div id="edit_form">
			<form action="../../controller/admin_edit_user.php" method="POST">

				<h1>Editer</h1>

				<label><b>Id :</b></label>
				<input type="number" name="id_utilisateur" readonly='readonly' required>
				<p><em>Vous ne pouvez pas modifier l'id</em></p></br>
				<label><b>Prénom :</b></label>
				<input type="text" name="prenom">
				<br>
				<label><b>Nom :</b></label>
				<input type="text" name="nom">
				<br>
				<label><b>Email :</b></label>
				<input type="email" name="adresse_mail" required>
				<br>
				<label><b>Rôle :</b></label>
				<select name="role">
				  <option value="U">Utilisateur</option>
				  <option value="G">Gestionnaire</option>
				  <option value="A">Administrateur</option>
				</select>
				<br><br>
				<input type="submit" class='confirm' value='Valider'><input type='button' class='cancel' value='Annuler' onclick="hide_edit_form()">

			</form>
		</div>


		<div id="pre_register_form">
			<form action="../../controller/pre_register.php" method="POST">

				<h1>Pré-inscrire un gestionnaire</h1>

				<label><b>Email :</b></label>
				<input type="email" name="adresse_mail" required>
				<p>Un lien d'inscription sera envoyé à cette adresse mail</p>
				<br>

				<label><b>Etablissement :</b></label>
				<select name='id_entite' required>
					<?php
				  $req = $db->prepare("SELECT id_entite, nom from entite");
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
