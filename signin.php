<?php
session_start();
if(isset($_POST['adresse_mail']) && isset($_POST['mot_de_passe']))
{
    // connexion à la base de données
    $db_username = 'root';
    $db_password = '';
    $db_name     = 'infinite_sense';
    $db_host     = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
           or die('could not connect to database');


    $mail = mysqli_real_escape_string($db,htmlspecialchars($_POST['adresse_mail']));
    $mdp = mysqli_real_escape_string($db,htmlspecialchars($_POST['mot_de_passe']));

    if($adresse_mail !== "" && $mot_de_passe !== "")
    {
        $requete = "SELECT count(*) FROM utilisateur where adresse_mail = '".$adresse_mail."' and mot_de_passe = '".$mot_de_passe."' ";
        $exec_requete = mysqli_query($db,$requete);
        $reponse      = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
          $requete = "SELECT * FROM utilisateur";
          $exec_requete = mysqli_query($db,$requete);
          $reponse      = mysqli_fetch_array($exec_requete);
          $_SESSION['utilisateur'] = $reponse;
          if ($reponse['role']='utilisateur') {
            header('Location: Accueil_utilisateur.php');
          }
          if ($reponse['role']='gestionnaire') {
            header('Location: Accueil_gestionnaire.php');
          }
          if ($reponse['role']='admin') {
            header('Location: Accueil_admin.php');
          }
        }
        else
        {
           header('Location: Connexion.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
       header('Location: Connexion.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: Connexion.php');
}
mysqli_close($db); // fermer la connexion
?>
