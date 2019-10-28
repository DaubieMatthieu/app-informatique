<?php
session_start();

if(isset($_POST['adresse_mail']) && isset($_POST['mot_de_passe']))
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
      header('Location:../view/loggedout/Connexion.php?erreur=0');
    }

    $adresse_mail = htmlspecialchars($_POST['adresse_mail']);
    $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

    if($adresse_mail !== "" && $mot_de_passe !== "") //vérification des données envoyées
    {
        try {
          $check = $db->prepare("SELECT * FROM utilisateur where adresse_mail = :adresse_mail and mot_de_passe = :mot_de_passe");
          $check->bindValue(':adresse_mail', $adresse_mail, PDO::PARAM_STR);
          $check->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
          $check->execute();
        } catch (Exception $e)
        {
          header('Location:../view/loggedout/Connexion.php?erreur=1'); //erreur serveur
        }
        if($check->rowCount() != 0)  // nom d'utilisateur et mot de passe correct
        {
          $reponse = $check->fetch();
          $_SESSION = $reponse;
          if ($reponse['role']==='A') {
            header('Location: ../view/accueil/Accueil_admin.php');
          }
          if ($reponse['role']==='G') {
            header('Location: ../view/accueil/Accueil_gestionnaire.php');
          }
          if ($reponse['role']==='U') {
            header('Location: ../view/accueil/Accueil_utilisateur.php');
          }
        }
        else
        {
           header('Location:../view/loggedout/Connexion.php?erreur=2'); // utilisateur ou mot de passe incorrect
        }
        $check->closeCursor();
    }
    else
    {
       header('Location: ../view/loggedout/Connexion.php?erreur=3'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: ../view/loggedout/Connexion.php?erreur=4'); //echec de l'envoi du formulaire
}
mysqli_close($db); // fermer la connexion
?>
