<?php
session_start();

if(empty($_POST))
{
   header('Location: ../view/autre/Profil.php?error=1.1'); //echec de l'envoi du formulaire
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
  header('Location:../view/autre/Profil.php?error=0');
  exit;
}

$id_utilisateur = htmlspecialchars($_SESSION['id_utilisateur']);

try {

  if (in_array('password_old',array_keys($_POST)) && in_array('password_new',array_keys($_POST)) && in_array('password_new_confirm',array_keys($_POST)))
  {
    $mdp_check = $db->prepare("SELECT mot_de_passe FROM utilisateur where id_utilisateur=:id_utilisateur and mot_de_passe=:mot_de_passe");
    $mdp_check->bindValue(':id_utilisateur', $id_utilisateur);
    $mdp_check->bindValue(':mot_de_passe', hash('sha256', $_POST['password_old']));
    $mdp_check->execute();
    if ($mdp_check->rowCount() == 0) // mot de passe incorrect
    {
      header('Location:../view/autre/Profil.php?error=3.2');
      exit;
    } else {
      if ($_POST['password_new'] !== $_POST['password_new_confirm']) {
        header('Location:../view/autre/Profil.php?error=3.3');
        exit;
      } else {
        $maj_infos='mot_de_passe='."'".hash('sha256',$_POST['password_new'])."'";
      }
    }
  } else {
    $maj_infos=array();
    foreach($_POST as $key => $value){
      $maj_infos[] = "$key = '$value'";
      $_SESSION[$key]=$value;
    }
    $maj_infos = implode(', ', $maj_infos);
  }
  $maj = $db->prepare("UPDATE utilisateur SET ".$maj_infos." WHERE id_utilisateur=$id_utilisateur");
  $maj->execute();
  $maj->closeCursor();

  header('Location:../view/autre/Profil.php?success=data_update'); //données mises à jour
  exit;
}
catch(Exception $e)
{
  header('Location:../view/autre/Profil.php?error=2.1'); //echec de la maj des données
  exit;
}


?>
