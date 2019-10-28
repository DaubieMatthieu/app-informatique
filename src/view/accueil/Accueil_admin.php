<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/accueil/Accueil_admin.css" />
		<title> Gérer les utilisateurs </title>
	</head>

	<body>

		<?php include("../headerfooter/Header_logged_in.php"); ?>

		<section>
			<nav>
				<h1> Gérer les utilisateurs </h1></br>
				<form method="post" action="Accueil_admin.php">
					<input type="search" name="search" autocomplete="off" placeholder="Rechercher un utilisateur" size="64" maxlength="64"/>
					<button type="submit" id='search'></button>
				</form>
			</nav>

			<?php

			$db_username = 'root';
			$db_password = '';
			$db_name     = 'infinite_sense';
			$db_host     = 'localhost';
			try
			{
				$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_username, $db_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

				try {
					if (isset($_POST['search'])) {
						$search=$_POST['search'];
						$keywords=explode(' ', $search);
						$req = "SELECT * FROM utilisateur WHERE 0";
						foreach($keywords as $keyword) {
							$req .= " OR concat(nom,prenom,adresse_mail) LIKE '%$keyword%'";
						}
					} else {
						$req = "SELECT * FROM utilisateur";
					}

					$rep = $db->query($req);

					if ($rep->rowCount()!=0)
					{
						?>
						<div id="tableau">
						<table>
							<tr>
								<th>Nom</th>
								<th>Prénom</th>
								<th>Email</th>
								<th>Type d'utilisateur</th>
								<th>Action</th>
							</tr>
							<?php
            	while ($user=$rep->fetch()) {
							?>
				        <tr>
			            <td><?php echo $user['nom']; ?></td>
			            <td><?php echo $user['prenom']; ?></td>
			            <td><?php echo $user['adresse_mail']; ?></td>
									<td>
										<?php
										$role=$user['role'];
										if ($role==='A') {echo 'Administrateur';}
										if ($role==='G') {echo 'Gestionnaire';}
										if ($role==='U') {echo 'Utilisateur';}
										?>
									</td>
									<td>
										<?php
										if ($role!='A') {?>
											<div class="table_button">
												<button type='button' class='delete'></button>
												<button type='button' class='edit'></button>
											</div>
										<?php
									}
									?>
									</td>
								</tr>
            	<?php
							}
							?>
						</table>
						</div>
						<?php
					} else {
						echo "<p style='color:orange;text-align:center;'>Aucun utilisateur trouvé</p>";
					}
				} catch (Exception $e)
				{
					echo "<p style='color:red'>Erreur serveur</p>";
				}
			} catch (Exception $e) {
				echo "<p style='color:red'>Connexion à la base de donnée impossible</p>";
			}
			?>

		</section>
		<?php include("../headerfooter/Footer.php"); ?>

	</body>
</html>
