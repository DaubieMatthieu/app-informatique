<?php
session_start();

if(!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['adresse_mail']) || !isset($_POST['token']) || !isset($_POST['mot_de_passe']))
{
  header('Location: ../view/loggedout/Inscription.php?error=1.1'); //echec de l'envoi du formulaire
  exit;
}
// connexion à la base de données
include('../model/db_connect.php');
$db = db_connect();
if ($db===false) {
  header('Location:../view/loggedout/Inscription.php?error=0');
  exit;
}

$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$adresse_mail = htmlspecialchars($_POST['adresse_mail']);
$token = htmlspecialchars($_POST['token']);
$mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

if($nom == "" || $prenom == "" || $adresse_mail == "" || $token == "" || $mot_de_passe == "") //vérification des données envoyées
{
   header('Location: ../view/loggedout/Inscription.php?error=1.2'); // donnée(s) manquante(s)
   exit;
}

try {
  $check = $db->prepare("SELECT id_pre_inscription, role, id_entite from pre_inscription where adresse_mail=:adresse_mail AND token=:token");
  $check->bindValue(':adresse_mail',$adresse_mail, PDO::PARAM_STR);
  $check->bindValue(':token',$token, PDO::PARAM_STR);
  $check->execute();
}
catch(Exception $e)
{
  header('Location:../view/loggedout/Inscription.php?error=2.1'); //erreur serveur
  exit;
}

if($check->rowCount() == 0)
{
  header('Location:../view/loggedout/Inscription.php?error=8'); // adresse mail non pré-enregistré ou token invalide
  exit;
}

$profil=$check->fetch();
$id_pre_inscription=$profil['id_pre_inscription'];
$role=$profil['role'];
$id_entite=$profil['id_entite'];


try {
  $req = $db->prepare("INSERT into utilisateur SET nom=:nom, prenom=:prenom, adresse_mail=:adresse_mail, mot_de_passe=:mot_de_passe, role=:role");
  $req->bindValue(':nom', $nom, PDO::PARAM_STR);
  $req->bindValue(':prenom', $prenom, PDO::PARAM_STR);
  // Encode to SHA256
  $mot_de_passe = hash('sha256', $mot_de_passe);
  $req->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
  $req->bindValue(':adresse_mail', $adresse_mail, PDO::PARAM_STR);
  $req->bindValue(':role', $role, PDO::PARAM_STR);
  $req->execute();
  $req->closeCursor();

  $id_utilisateur = $db->lastInsertId();
  $req2 = $db->prepare("INSERT INTO inscription(`id_entite`, `id_utilisateur`) VALUES (:id_entite, :id_utilisateur)");
  $req2->bindValue(':id_entite', $id_entite, PDO::PARAM_STR);
  $req2->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_STR);
  $req2->execute();
  $req2->closeCursor();

  $req3 = $db->prepare("DELETE from pre_inscription WHERE id_pre_inscription=:id_pre_inscription");
  $req3->bindValue(':id_pre_inscription', $id_pre_inscription, PDO::PARAM_STR);
  $req3->execute();
  $req3->closeCursor();
  header('Location:../view/loggedout/Connexion.php?success=register'); //utilisateur ajouté
  exit;
}
catch(Exception $e)
{
  header('Location:../view/loggedout/Inscription.php?error=2.2'); //echec de l'insertion des données
  exit;
}


?>
