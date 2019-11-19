<?php
session_start();
if (!isset($_POST['id_utilisateur']) || !isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['adresse_mail']) || !isset($_POST['role']))
{
  header('Location: ../view/accueil/Accueil_admin.php?error=1.1'); //echec de l'envoi du formulaire
  exit;
}

// connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name     = 'infinite_sense';
$db_host     = 'localhost';

try
{
  $db = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_username, $db_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
} catch (Exception $e)
{
  header('Location:../view/accueil/Accueil_admin.php?error=0');
  exit;
}

$id_admin = htmlspecialchars($_SESSION['id_utilisateur']);
$id_utilisateur = htmlspecialchars($_POST['id_utilisateur']);
$maj_nom = htmlspecialchars($_POST['nom']);
$maj_prenom = htmlspecialchars($_POST['prenom']);
$maj_adresse_mail = htmlspecialchars($_POST['adresse_mail']);
$maj_role = htmlspecialchars($_POST['role']);

$maj_infos = array('nom' => $maj_nom, 'prenom' => $maj_prenom, 'adresse_mail' => $maj_adresse_mail, 'role' => $maj_role);

if($id_utilisateur == "" || $maj_nom == "" || $maj_prenom == "" || $maj_adresse_mail == "" || $maj_role == "") //vérification des données envoyées
{
  header('Location: ../view/accueil/Accueil_admin.php?error=1.2'); // donnée(s) manquante(s)
  exit;
}


try {
  $info = $db->prepare("SELECT nom,prenom,adresse_mail,role FROM utilisateur WHERE id_utilisateur=:id_utilisateur");
  $info->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
  $info->execute();
  $result = $info->fetch(PDO::FETCH_ASSOC);
  $info->closeCursor();

  $changement_utilisateur = "Modifications de l'utilisateur d'id ".$id_utilisateur.' :';
  foreach ($result as $key => $value) {$changement_utilisateur.= ' champ '.$key.' de '.$value.' à '.$maj_infos[$key];}

  $maj = $db->prepare("UPDATE utilisateur SET nom=:maj_nom, prenom=:maj_prenom, adresse_mail=:maj_adresse_mail, role=:maj_role where id_utilisateur=:id_utilisateur");
  $maj->bindValue(':maj_nom',$maj_nom, PDO::PARAM_STR);
  $maj->bindValue(':maj_prenom',$maj_prenom, PDO::PARAM_STR);
  $maj->bindValue(':maj_adresse_mail',$maj_adresse_mail, PDO::PARAM_STR);
  $maj->bindValue(':maj_role',$maj_role, PDO::PARAM_STR);
  $maj->bindValue(':id_utilisateur',$id_utilisateur, PDO::PARAM_INT);
  $maj->execute();
  $maj->closeCursor();

  $gestion = $db->prepare("INSERT INTO `gestion_utilisateur`(`id_admin`, `id_utilisateur`, `action`, `date_gestion`, `changement_utilisateur`) VALUES (:id_admin,:id_utilisateur,'M',NOW(),:changement_utilisateur)");
  $gestion->bindValue(':id_admin',$id_admin, PDO::PARAM_INT);
  $gestion->bindValue(':id_utilisateur',$id_utilisateur, PDO::PARAM_INT);
  $gestion->bindValue(':changement_utilisateur',$changement_utilisateur, PDO::PARAM_STR);
  $gestion->execute();
  $gestion->closeCursor();
  header('Location:../view/accueil/Accueil_admin.php?success=edit'); //données mise à jour
  exit;
}
catch(Exception $e)
{
  echo($e);
  header('Location:../view/accueil/Accueil_admin.php?error=2.1'); //echec de la maj des données
}




?>
