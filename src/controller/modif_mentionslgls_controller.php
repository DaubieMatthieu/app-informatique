<?php
    if(!isset($_POST['mentionslgls'])){
        header('Location: ../view/autre/modif_mentionslgls_view.php?error=6'); //echec de l'envoi du formulaire
        exit;
    }

    $newMentionsLgls = htmlspecialchars($_POST['mentionslgls']);

    if($newMentionsLgls == ""){
        header('Location: ../view/autre/modif_mentionslgls_view.php?error=1.2'); //echec de l'envoi du formulaire
        exit;
    }

    // connexion à la base de données
    include('../model/db_connect.php');
    $db = db_connect();
    if ($db===false) {
        header('Location:../view/autre/modif_mentionslgls_view.php?&error=0');
        exit;
    }

    try {
        $upd = $db->prepare("UPDATE contenu_site SET contenu=:contenu where type='Mentions légales'");
        $upd->bindValue(':contenu',$newMentionsLgls, PDO::PARAM_STR);
        $upd->execute();
        $upd->closeCursor();
      
        header('Location:../view/loggedout/Mentions_legales.php'); //données mise à jour
        exit;
      }
      catch(Exception $e)
      {
        header('Location:../view/autre/modif_mentionslgls_view.php?error=2.1'); //echec de la maj des données
        exit;
      }
?>