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

try {
  $check2 = $db->prepare("SELECT id_pre_inscription from pre_inscription where adresse_mail=:adresse_mail");
  $check2->bindValue(':adresse_mail',$adresse_mail, PDO::PARAM_STR);
  $check2->execute();
  $check2->closeCursor();
}
catch(Exception $e)
{
  header('Location:'.$redirection.'?error=2.1'); //erreur serveur
  exit;
}

if($check->rowCount() !== 0 || $check2->rowCount() !== 0)  // adresse mail utilisée
{
  header('Location:'.$redirection.'?error=4'); // adresse mail déjà utilisée
  exit;
}

try {
  $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
  //génération du token
  $req = $db->prepare("INSERT INTO pre_inscription(`adresse_mail`, `token`,`role`,`id_entite`) VALUES (:adresse_mail, :token, :role, :id_entite)");
  $req->bindValue(':adresse_mail', $adresse_mail, PDO::PARAM_STR);
  $req->bindValue(':token',$token,PDO::PARAM_STR);
  if ($role_logger=='A') {$role='G';}
  if ($role_logger=='G') {$role='U';}
  $req->bindValue(':role', $role, PDO::PARAM_STR);
  $req->bindValue(':id_entite', $id_entite, PDO::PARAM_STR);
  $req->execute();
  $req->closeCursor();
  $sujet="Inscrivez-vous sur InfiniteSense";
  $texte="Bonjour,\nCliquez sur ce lien pour vous inscrire sur InfiniteSense avec le mail ".$adresse_mail.".\n";
  $texte=$texte."http://infinitesense.ovh:22233/view/loggedout/Inscription.php?token=".$token;
  $texte=$texte."Si vous n'avez pas demandé à vous inscrire, vous pouvez ignorer cet e-mail.\nMerci,\nL'équipe InfiniteSense";
  mail($adresse_mail, $sujet, $texte);
  header('Location:'.$redirection.'?success=pre_register'); //utilisateur pre_enregistré
  exit;
}
catch(Exception $e)
{ //echec de l'insertion des données
  header('Location:'.$redirection.'?error=2.2');
  exit;
}

?>
