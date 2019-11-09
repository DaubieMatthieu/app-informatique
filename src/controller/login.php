<?php
session_start();

if(!isset($_POST['adresse_mail']) || !isset($_POST['mot_de_passe']))
{
   header('Location: ../view/loggedout/Connexion.php?error=1.1'); //echec de l'envoi du formulaire
   exit;
}
  // connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name     = 'infinite_sense';
$db_host     = 'localhost';

try
{
  $db =  new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_username, $db_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
} catch (Exception $e) {
  header('Location:../view/loggedout/Connexion.php?error=0');
  exit;
}

$adresse_mail = htmlspecialchars($_POST['adresse_mail']);
$mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

if($adresse_mail == "" || $mot_de_passe == "") //vérification des données envoyées
{
 header('Location: ../view/loggedout/Connexion.php?error=1.2'); // utilisateur ou mot de passe vide
 exit;
}

try {
  $check = $db->prepare("SELECT id_utilisateur, nom, prenom, adresse_mail, role FROM utilisateur where adresse_mail = :adresse_mail and mot_de_passe = :mot_de_passe");
  $check->bindValue(':adresse_mail', $adresse_mail, PDO::PARAM_STR);
  // Encode to SHA256
  $mot_de_passe = hash('sha256', $mot_de_passe);
  $check->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
  $check->execute();
} catch (Exception $e)
{
  header('Location:../view/loggedout/Connexion.php?error=2.1'); //erreur serveur
  exit;
}

if($check->rowCount() == 0)  // nom d'utilisateur ou mot de passe incorrect
{
   header('Location:../view/loggedout/Connexion.php?error=3.1'); // utilisateur ou mot de passe incorrect
   exit;
}

$reponse = $check->fetch();
$check->closeCursor();

$_SESSION = $reponse;
if ($reponse['role']==='A') {header('Location: ../view/accueil/Accueil_admin.php');}
if ($reponse['role']==='G') {header('Location: ../view/accueil/Accueil_gestionnaire.php');}
if ($reponse['role']==='U') {header('Location: ../view/accueil/Accueil_utilisateur.php');}
exit;

?>
