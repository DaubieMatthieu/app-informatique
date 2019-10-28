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
    $db = new PDO('mysql:host=localhost;dbname=infinite_sense', $db_username, $db_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
  } catch (Exception $e)
  {
    header('Location:../view/loggedout/Inscription.php?erreur=0');
  }
  $nom = htmlspecialchars($_POST['nom']);
  $prenom = htmlspecialchars($_POST['prenom']);
  $adresse_mail = htmlspecialchars($_POST['adresse_mail']);
  $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

  if($nom !== "" && $prenom !== "" && $adresse_mail !== "" && $mot_de_passe !== "") //vérification des données envoyées
  {
    try {
      $check = $db->prepare("SELECT id_utilisateur from utilisateur where adresse_mail=:adresse_mail");
      $check->bindValue(':adresse_mail',$adresse_mail, PDO::PARAM_STR);
      $check->execute();
    }
    catch(Exception $e)
    {
      header('Location:../view/loggedout/Inscription.php?erreur=1'); //erreur serveur
    }
    if($check->rowCount() == 0)  // adresse mail non utilisée
    {
      try {
        $req = $db->prepare("INSERT INTO utilisateur(`nom`,`prenom`, `adresse_mail`, `mot_de_passe`, `role`) VALUES (:nom,:prenom,:adresse_mail,:mot_de_passe,'U')");
        $req->bindValue(':nom', $nom, PDO::PARAM_STR);
        $req->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $req->bindValue(':adresse_mail', $adresse_mail, PDO::PARAM_STR);
        $req->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
        $req->execute();
        header('Location:../view/loggedout/Inscription.php?success=1'); //utilisateur ajouté
      }
      catch(Exception $e)
      {
        header('Location:../view/loggedout/Inscription.php?success=0'); //echec de l'insertion des données
      }
      $req->closeCursor();
    } else {
      header('Location:../view/loggedout/Inscription.php?erreur=2'); // adresse mail déjà utilisée
    }
    $check->closeCursor();
  } else {
     header('Location: ../view/loggedout/Inscription.php?erreur=3'); // donnée(s) manquante(s)
  }

} else {
   header('Location: ../view/loggedout/Connexion.php?erreur=4'); //echec de l'envoi du formulaire
}

mysqli_close($db);

?>
