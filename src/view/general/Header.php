<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/general/Header.css" />
	</head>

	<header>
		<ul id="deroulant">
			<li><a href="../../Index.php">InfiniteSense</a></li>
			<li><a href="../autre/Faq.php">Faq</a></li>
			<li><a href="../autre/Forum.php">Forum</a></li>

			<?php
			if (isset($_SESSION['role'])) //si l'utilisateur est connecté et qu'il a un role
			{
				include_once('../../model/convert_role.php');
				$role=char_to_str($_SESSION['role']);
				if ($role=="Administrateur") {$accueil="../accueil/Accueil_admin.php";}
				if ($role=="Gestionnaire") {$accueil="../accueil/Accueil_gestionnaire.php";}
				if ($role=="Utilisateur") {$accueil="../accueil/Accueil_utilisateur.php";}
				//si la variable $role n'a pas été défini, la session est mal définie, on lui demande donc de se reconnecter
				if ($role=='error') {header('Location:../loggedout/Connexion?error=5.php');exit;}
				echo '<li id="menu">'.$role.'<ul>';//début du menu déroulant
				//variation en fonction de la page demandé
				if(basename($_SERVER['PHP_SELF']) =='Profil.php') {echo '<li><a href='.$accueil.'>Accueil</a></li>';}
				else {echo '<li><a href="../autre/Profil.php">Profil</a></li>';}

				echo '<li><a href="../../controller/logout.php">Déconnexion</a></li>';
				echo '</ul></li>';
			} else { //l'utilisateur n'est pas/est mal connecté
				echo '<li><a href="../loggedout/Connexion.php">Connexion</a></li>';
			}
			?>
			</li>
		</ul>
	</header>
</html>
