<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/headerfooter/Header_logged_in.css" />
	</head>

	<?php
		if ($_SESSION['role']==='A') {$role="Administrateur";}
		if ($_SESSION['role']==='G') {$role="Gestionnaire";}
		if ($_SESSION['role']==='U') {$role="Utilisateur";}
	?>

	<header>
		<ul id="deroulant">
			<li><a href="../../Index.php">InfiniteSense</a></li>
			<li><a href="../forum/Forum.php">Forum</a></li>
			<li><button type="button"><?php echo $role;?>
				<ul>
					<li><a href="../autre/Profil.php">Profil</a></li>
					<li><a href="../../controller/logout.php">Déconnexion</a></li>
				</ul>
			</li>
		</ul>
	</header>

</html>
