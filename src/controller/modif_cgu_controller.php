<?php
    if(!isset($_POST['cgu'])){
        header('Location: ../view/autre/modif_cgu_view.php?error=6'); //echec de l'envoi du formulaire
        exit;
    }

    $newCgu = htmlspecialchars($_POST['cgu']);

    if($newCgu == ""){
        header('Location: ../view/autre/modif_cgu_view.php?error=1.2'); //echec de l'envoi du formulaire
        exit;
    }

    // connexion à la base de données
    include('../model/db_connect.php');
    $db = db_connect();
    if ($db===false) {
        header('Location:../view/autre/modif_cgu_view.php?&error=0');
        exit;
    }

    try {
        $upd = $db->prepare("UPDATE contenu_site SET contenu=:contenu where type='CGU'");
        $upd->bindValue(':contenu',$newCgu, PDO::PARAM_STR);
        $upd->execute();
        $upd->closeCursor();
      
        header('Location:../view/loggedout/CGU.php'); //données mise à jour
        exit;
      }
      catch(Exception $e)
      {
        header('Location:../view/autre/modif_cgu_view.php?error=2.1'); //echec de la maj des données
        exit;
      }
?>