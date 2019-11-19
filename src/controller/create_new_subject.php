<?php
session_start();

if(!isset($_POST['titre']) || !isset($_SESSION['id_utilisateur']) || !isset($_POST['message']))
{
  header('Location: ../view/autre/Forum.php?error=1.1'); //echec de l'envoi du formulaire
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
  header('Location:../view/autre/Forum.php?error=0');
  exit;
}

$id_utilisateur = htmlspecialchars($_SESSION['id_utilisateur']);
$titre = htmlspecialchars($_POST['titre']);
$message = htmlspecialchars($_POST['message']);

if($id_utilisateur == "" || $titre == "" || $message == "") //vérification des données envoyées
{
   header('Location: ../view/autre/Forum.php?error=1.2'); // donnée(s) manquante(s)
   exit;
}

try {
  $check = $db->prepare("SELECT id_sujet from sujet_forum where titre=:titre");
  $check->bindValue(':titre',$titre, PDO::PARAM_STR);
  $check->execute();
}
catch(Exception $e)
{
  header('Location:../view/autre/Forum.php?error=2.1'); //erreur serveur
  exit;
}

if($check->rowCount() !== 0)  // sujet déjà existant
{
  $sujet=$check->fetch();
  $id_sujet=$sujet['id_sujet'];
  header('Location:../view/autre/Forum_sujet.php?id_sujet='.$id_sujet.'&error=7'); // on redirige vers le sujet
  exit;
}

try {
  $req = $db->prepare("INSERT INTO sujet_forum(`id_utilisateur`,`titre`, `date_creation_sujet`) VALUES (:id_utilisateur,:titre,NOW())");
  $req->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_STR);
  $req->bindValue(':titre', $titre, PDO::PARAM_STR);
  $req->execute();
  $req->closeCursor();
  $id_sujet=$db->lastInsertId();
  $req2 = $db->prepare("INSERT INTO message_forum(`id_sujet`,`id_utilisateur`,`message`,`date_poste`) VALUES (:id_sujet,:id_utilisateur,:message,NOW())");
  $req2->bindValue(':id_sujet', $id_sujet, PDO::PARAM_STR);
  $req2->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_STR);
  $req2->bindValue(':message', $message, PDO::PARAM_STR);
  $req2->execute();
  $req2->closeCursor();
  header('Location:../view/autre/Forum_sujet.php?id_sujet='.$id_sujet.'&success=create_new_subject'); //nouveau sujet crée
  exit;
}
catch(Exception $e)
{
  header('Location:../view/autre/Forum.php?error=2.1'); //echec de l'insertion des données
  exit;
}


?>
