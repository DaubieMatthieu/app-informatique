<?php
session_start();

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['adresse_mail']) && isset($_POST['mot_de_passe']))
{
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
    header('Location:../view/autre/Profil.php?erreur=0');
  }

  $nom = htmlspecialchars($_SESSION['nom']);
  $prenom = htmlspecialchars($_SESSION['prenom']);
  $adresse_mail = htmlspecialchars($_SESSION['adresse_mail']);
  $mot_de_passe = htmlspecialchars($_SESSION['mot_de_passe']);


  $maj_nom = htmlspecialchars($_POST['nom']);
  $maj_prenom = htmlspecialchars($_POST['prenom']);
  $maj_adresse_mail = htmlspecialchars($_POST['adresse_mail']);
  $maj_mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

  if($maj_nom !== "" && $maj_prenom !== "" && $maj_adresse_mail !== "" && $maj_mot_de_passe !== "") //vérification des données envoyées
  {
    try {
      $maj = $db->prepare("UPDATE utilisateur SET nom=:maj_nom, prenom=:maj_prenom, adresse_mail=:maj_adresse_mail, mot_de_passe=:maj_mot_de_passe where adresse_mail=:adresse_mail");
      $maj->bindValue(':maj_nom',$maj_nom, PDO::PARAM_STR);
      $maj->bindValue(':maj_prenom',$maj_prenom, PDO::PARAM_STR);
      $maj->bindValue(':maj_adresse_mail',$maj_adresse_mail, PDO::PARAM_STR);
      $maj->bindValue(':maj_mot_de_passe',$maj_mot_de_passe, PDO::PARAM_STR);
      $maj->bindValue(':adresse_mail',$adresse_mail, PDO::PARAM_STR);
      $maj->execute();

      $_SESSION['nom']=$maj_nom;
      $_SESSION['prenom']=$maj_prenom;
      $_SESSION['adresse_mail']=$maj_adresse_mail;
      $_SESSION['mot_de_passe']=$maj_mot_de_passe;

      header('Location:../view/autre/Profil.php?success=1'); //données mise à jour
    }
    catch(Exception $e)
    {
      header('Location:../view/autre/Profil.php?success=0'); //echec de la maj des données
    }
    $maj->closeCursor();
  } else {
     header('Location: ../view/autre/Profil.php?erreur=3'); // donnée(s) manquante(s)
  }

} else {
   header('Location: ../view/autre/Profil.php?erreur=4'); //echec de l'envoi du formulaire
}

mysqli_close($db);

?>
