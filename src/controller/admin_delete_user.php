<?php
session_start();
if (!isset($_POST['id_utilisateur']))
{
   header('Location: ../view/accueil/Accueil_admin.php?error=1.1'); //echec de l'envoi du formulaire
   exit;
}
// connexion à la base de données
include('../model/db_connect.php');
$db = db_connect();
if ($db===false) {
  header('Location:../view/accueil/Accueil_admin.php?error=0');
  exit;
}

$id_admin = htmlspecialchars($_SESSION['id_utilisateur']);
$id_utilisateur = htmlspecialchars($_POST['id_utilisateur']);

if($id_utilisateur == "") //vérification des données envoyées
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

  $changement_utilisateur = "Suppression de l'utilisateur d'id:".$id_utilisateur;
  foreach ($result as $key => $value) {$changement_utilisateur.= ' de '.$key.':'.$value;}

  $maj = $db->prepare("DELETE FROM utilisateur where id_utilisateur=:id_utilisateur");
  $maj->bindValue(':id_utilisateur',$id_utilisateur, PDO::PARAM_INT);
  $maj->execute();
  $maj->closeCursor();

  $gestion = $db->prepare("INSERT INTO `gestion_utilisateur`(`id_admin`, `id_utilisateur`, `action`, `date_gestion`, `changement_utilisateur`) VALUES (:id_admin,:id_utilisateur,'S',NOW(),:changement_utilisateur)");
  $gestion->bindValue(':id_admin',$id_admin, PDO::PARAM_INT);
  $gestion->bindValue(':id_utilisateur',$id_utilisateur, PDO::PARAM_INT);
  $gestion->bindValue(':changement_utilisateur',$changement_utilisateur, PDO::PARAM_STR);
  $gestion->execute();
  $gestion->closeCursor();

  header('Location:../view/accueil/Accueil_admin.php?success=delete_user'); //données mise à jour
  exit;
}
catch(Exception $e)
{
  header('Location:../view/accueil/Accueil_admin.php?error=2.1'); //echec de la maj des données
  exit;
}


?>
