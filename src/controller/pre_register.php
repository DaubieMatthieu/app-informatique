<?php
session_start();

if(!isset($_POST['adresse_mail']) || !isset($_POST['id_entite']) || !isset($_SESSION['role']))
{
  header('Location: ../view/accueil/Accueil_gestionnaire.php?error=1.1'); //echec de l'envoi du formulaire
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
  header('Location:../view/accueil/Accueil_gestionnaire.php?error=0');
  exit;
}

$adresse_mail = htmlspecialchars($_POST['adresse_mail']);
$id_entite = htmlspecialchars($_POST['id_entite']);
$role_logger = htmlspecialchars($_SESSION['role']);

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
  
  if ($role_logger=='A') {header('Location:../view/accueil/Accueil_admin.php?success=pre_register');} //gestionnaire pre_enregistré
  if ($role_logger=='G') {header('Location:../view/accueil/Accueil_gestionnaire.php?success=pre_register');} //utilisateur pre_enregistré
  exit;
}
catch(Exception $e)
{
  //header('Location:../view/accueil/Accueil_gestionnaire.php?error=2.2'); //echec de l'insertion des données
  exit;
}


?>
