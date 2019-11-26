<?php
session_start();

if(!isset($_POST['adresse_mail']) || !isset($_POST['id_entite']) || !isset($_SESSION['role']))
{
  header('Location: ../view/accueil/Accueil_gestionnaire.php?error=1.1'); //echec de l'envoi du formulaire
  exit;
}
// connexion à la base de données
include('../model/db_connect.php');
$db = db_connect();
if ($db===false) {
  header('Location:../view/accueil/Accueil_gestionnaire.php?error=0');
  exit;
}

$adresse_mail = htmlspecialchars($_POST['adresse_mail']);
$id_entite = htmlspecialchars($_POST['id_entite']);
$role_logger = htmlspecialchars($_SESSION['role']);
$id_logger = htmlspecialchars($_SESSION['id_utilisateur']);

if($adresse_mail == "" || $id_entite == "" || $role_logger == "") //vérification des données envoyées
{
   header('Location: ../view/accueil/Accueil_gestionnaire.php?error=1.2'); // donnée(s) manquante(s)
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
  header('Location:../view/accueil/Accueil_gestionnaire.php?error=2.1'); //erreur serveur
  exit;
}

if($check->rowCount() !== 0)  // adresse mail utilisée
{
  header('Location:../view/accueil/Accueil_gestionnaire.php?error=4'); // adresse mail déjà utilisée
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

  if ($role_logger=='A') {header('Location:../view/accueil/Accueil_admin.php?success=pre_register');} //gestionnaire pre_enregistré
  if ($role_logger=='G') {header('Location:../view/accueil/Accueil_gestionnaire.php?success=pre_register');} //utilisateur pre_enregistré
  exit;
}
catch(Exception $e)
{ //echec de l'insertion des données
  if ($role_logger=='A') {header('Location:../view/accueil/Accueil_admin.php?error=2.2');}
  if ($role_logger=='G') {header('Location:../view/accueil/Accueil_gestionnaire.php?error=2.2');}
  exit;
}

?>
