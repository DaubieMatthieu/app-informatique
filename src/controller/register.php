<?php
session_start();

if(!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['adresse_mail']) || !isset($_POST['mot_de_passe']))
{
  header('Location: ../view/loggedout/Inscription.php?error=1.1'); //echec de l'envoi du formulaire
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
  header('Location:../view/loggedout/Inscription.php?error=0');
  exit;
}

$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$adresse_mail = htmlspecialchars($_POST['adresse_mail']);
$mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

if($nom == "" || $prenom == "" || $adresse_mail == "" || $mot_de_passe == "") //vérification des données envoyées
{
   header('Location: ../view/loggedout/Inscription.php?error=1.2'); // donnée(s) manquante(s)
   exit;
}

try {
  $check = $db->prepare("SELECT nom, prenom, mot_de_passe from utilisateur where adresse_mail=:adresse_mail");
  $check->bindValue(':adresse_mail',$adresse_mail, PDO::PARAM_STR);
  $check->execute();
}
catch(Exception $e)
{
  header('Location:../view/loggedout/Inscription.php?error=2.1'); //erreur serveur
  exit;
}

if($check->rowCount() == 0)
{
  header('Location:../view/loggedout/Inscription.php?error=8'); // adresse mail non pré-enregistré
  exit;
} else {
  $profil=$check->fetch();
  if ($profil['nom']!==NULL || $profil['prenom']!==NULL || $profil['mot_de_passe']!==NULL) {
    header('Location:../view/loggedout/Inscription.php?error=4'); // adresse mail déjà utilisée
    exit;
  }
}

try {
  $req = $db->prepare("UPDATE utilisateur SET nom=:nom, prenom=:prenom, mot_de_passe=:mot_de_passe WHERE adresse_mail=:adresse_mail");
  $req->bindValue(':nom', $nom, PDO::PARAM_STR);
  $req->bindValue(':prenom', $prenom, PDO::PARAM_STR);
  // Encode to SHA256
  $mot_de_passe = hash('sha256', $mot_de_passe);
  $req->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
  $req->bindValue(':adresse_mail', $adresse_mail, PDO::PARAM_STR);
  $req->execute();
  $req->closeCursor();
  header('Location:../view/loggedout/Connexion.php?success=register'); //utilisateur ajouté
  exit;
}
catch(Exception $e)
{
  header('Location:../view/loggedout/Inscription.php?error=2.2'); //echec de l'insertion des données
  exit;
}


?>
