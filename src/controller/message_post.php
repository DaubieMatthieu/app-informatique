<?php
session_start();
if (!isset($_POST['id_sujet']))
{
  header('Location: ../view/autre/Forum.php?error=1.1'); //echec de l'envoi du formulaire
  exit;
}
if(!isset($_POST['message']) || !isset($_SESSION['id_utilisateur']))
{
  header('Location: ../view/autre/Forum_sujet.php?id_sujet='.$_POST['id_sujet'].'&error=1.1'); //echec de l'envoi du formulaire
  exit;
}
// connexion à la base de données
include('../model/db_connect.php');
$db = db_connect();
if ($db===false) {
  header('Location:../view/autre/Forum_sujet.php?id_sujet='.$_POST['id_sujet'].'&error=0');
  exit;
}

$id_sujet = htmlspecialchars($_POST['id_sujet']);
$id_utilisateur = htmlspecialchars($_SESSION['id_utilisateur']);
$message = htmlspecialchars($_POST['message']);

try {
  $req = $db->prepare("INSERT INTO message_forum(`id_sujet`,`id_utilisateur`, `message`, `date_poste`) VALUES (:id_sujet,:id_utilisateur,:message,NOW())");
  $req->bindValue(':id_sujet', $_POST['id_sujet'], PDO::PARAM_STR);
  $req->bindValue(':id_utilisateur', $_SESSION['id_utilisateur'], PDO::PARAM_STR);
  $req->bindValue(':message', $_POST['message'], PDO::PARAM_STR);
  $req->execute();
  $req->closeCursor();
  header("Location:../view/autre/Forum_sujet.php?id_sujet=".$_POST['id_sujet']."&success=message_post#last_message"); //message posté
  exit;
}
catch(Exception $e)
{
  header('Location:../view/autre/Forum_sujet.php?id_sujet='.$_POST['id_sujet'].'&error=2.1'); //echec de l'insertion des données
  exit;
}


?>
