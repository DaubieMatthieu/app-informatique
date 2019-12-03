<?php
session_start();
if (!isset($_POST['id_sujet']))
{
   header('Location: ../view/autre/Forum.php?error=6'); //echec de l'envoi du formulaire
   exit;
}

$id_sujet=htmlspecialchars($_POST['id_sujet']);

if (!isset($_POST['id_message']))
{
   header('Location: ../view/autre/Forum_sujet.php?id_sujet='.$id_sujet.'&error=1.1'); //echec de l'envoi du formulaire
   exit;
}

$id_message=htmlspecialchars($_POST['id_message']);

// connexion à la base de données
include('../model/db_connect.php');
$db = db_connect();
if ($db===false) {
  header('Location:../view/autre/Forum_sujet.php?id_sujet='.$id_sujet.'&error=0');
  exit;
}

if($id_sujet == "") //vérification des données envoyées
{
   header('Location: ../view/autre/Forum_sujet.php?id_sujet='.$id_sujet.'&error=1.2'); // donnée(s) manquante(s)
   exit;
}

try {
  $del = $db->prepare("DELETE FROM message_forum where id_message=:id_message");
  $del->bindValue(':id_message',$id_message, PDO::PARAM_INT);
  $del->execute();
  $del->closeCursor();

  header('Location:../view/autre/Forum_sujet.php?id_sujet='.$id_sujet.'&success=delete_message'); //données mise à jour
  exit;
}
catch(Exception $e)
{
  header('Location:../view/autre/Forum_sujet.php?id_sujet='.$id_sujet.'&error=2.1'); //echec de la maj des données
  exit;
}


?>
