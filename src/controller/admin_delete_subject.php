<?php
session_start();
if (!isset($_POST['id_sujet']))
{
   header('Location: ../view/autre/Forum_admin.php?error=1.1'); //echec de l'envoi du formulaire
   exit;
}
// connexion à la base de données
include('../model/db_connect.php');
$db = db_connect();
if ($db===false) {
  header('Location:../view/autre/Forum_admin.php?error=0');
  exit;
}

$id_admin = htmlspecialchars($_SESSION['id_utilisateur']);
$id_sujet = htmlspecialchars($_POST['id_sujet']);

if($id_sujet == "") //vérification des données envoyées
{
   header('Location: ../view/autre/Forum_admin.php?error=1.2'); // donnée(s) manquante(s)
   exit;
}

try {
  $del = $db->prepare("DELETE FROM sujet_forum where id_sujet=:id_sujet");
  $del->bindValue(':id_sujet',$id_sujet, PDO::PARAM_INT);
  $del->execute();
  $del->closeCursor();

  header('Location:../view/autre/Forum_admin.php?success=delete_subject'); //données mise à jour
  exit;
}
catch(Exception $e)
{
  header('Location:../view/autre/Forum_admin.php?error=2.1'); //echec de la maj des données
  exit;
}


?>
