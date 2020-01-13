<?php
session_start();

if (!isset($_SESSION['role'])) {
  header('Location: ../view/loggedout/Connexion.php?error=5'); //erreur session
}

$role_logger = htmlspecialchars($_SESSION['role']);

if ($role_logger=='A') {$redirection="../view/accueil/Accueil_admin.php";}
if ($role_logger=='G') {$redirection="../view/accueil/Accueil_gestionnaire.php";}

if(!isset($_POST['adresse_mail']) || !isset($_POST['id_entite']))
{
  header('Location: '.$redirection.'?error=1.1'); //echec de l'envoi du formulaire
  exit;
}
// connexion à la base de données
include('../model/db_connect.php');
$db = db_connect();
if ($db===false) {
  header('Location: '.$redirection.'?error=0');
  exit;
}

$adresse_mail = htmlspecialchars($_POST['adresse_mail']);
$id_entite = htmlspecialchars($_POST['id_entite']);
$id_logger = htmlspecialchars($_SESSION['id_utilisateur']);

if($adresse_mail == "" || $id_entite == "" || $role_logger == "") //vérification des données envoyées
{
   header('Location: '.$redirection.'?error=1.2'); // donnée(s) manquante(s)
   exit;
}

try {
  $check = $db->prepare("SELECT id_utilisateur from utilisateur where adresse_mail=:adresse_mail");
  $check->bindValue(':adresse_mail',$adresse_mail, PDO::PARAM_STR);
  $check->execute();
  $check->closeCursor();
}
catch(Exception $e)
{
  header('Location:'.$redirection.'?error=2.1'); //erreur serveur
  exit;
}

if($check->rowCount() !== 0)  // adresse mail utilisée
{
  header('Location:'.$redirection.'?error=4'); // adresse mail déjà utilisée
  exit;
}

try {
  $req = $db->prepare("INSERT INTO utilisateur(`adresse_mail`, `role`) VALUES (:adresse_mail, :role)");
  $req->bindValue(':adresse_mail', $adresse_mail, PDO::PARAM_STR);
  if ($role_logger=='A') {$role='G';}
  if ($role_logger=='G') {$role='U';}
  $req->bindValue(':role', $role, PDO::PARAM_STR);
  $req->execute();
  $req->closeCursor();

  $id_utilisateur = $db->lastInsertId();
  $req2 = $db->prepare("INSERT INTO inscription(`id_entite`, `id_utilisateur`) VALUES (:id_entite, :id_utilisateur)");
  $req2->bindValue(':id_entite', $id_entite, PDO::PARAM_STR);
  $req2->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_STR);
  $req2->execute();
  $req2->closeCursor();

  $changement_utilisateur = "Pré-inscription de l'utilisateur d'id:".$id_utilisateur." et d'adresse mail:".$adresse_mail;
  $gestion = $db->prepare("INSERT INTO `gestion_utilisateur`(`id_admin`, `id_utilisateur`, `action`, `date_gestion`, `changement_utilisateur`) VALUES (:id_logger,:id_utilisateur,'R',NOW(),:changement_utilisateur)");
  $gestion->bindValue(':id_logger',$id_logger, PDO::PARAM_INT);
  $gestion->bindValue(':id_utilisateur',$id_utilisateur, PDO::PARAM_INT);
  $gestion->bindValue(':changement_utilisateur',$changement_utilisateur, PDO::PARAM_STR);
  $gestion->execute();
  $gestion->closeCursor();

  header('Location:'.$redirection.'?success=pre_register'); //utilisateur pre_enregistré
  exit;
}
catch(Exception $e)
{ //echec de l'insertion des données
  header('Location:'.$redirection.'?error=2.2');
  exit;
}

?>
