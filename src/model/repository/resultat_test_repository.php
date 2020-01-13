<?php
include('generic_repository.php');

/**
 * Recherche un résultat de test en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getResultatByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM resultat_test WHERE id_resultat = :id_resultat');
    $query->bindParam(":id_resultat", $id);
    $query->execute();

    return $query->fetchAll();

}

/**
 * Récupère tous les enregistrements de la table resultat_test
 * @param PDO $bdd
 * @return array
 */
function getAllResultats(PDO $bdd){
    $query = 'SELECT * FROM resultat_test';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute un nouveau résultat de test dans la base de données
 * @param PDO $bdd
 * @param array $resultat
 */
function addResultat(PDO $bdd, array $resultat) {

    $query = ' INSERT INTO resultat_test (id_resultat, id_gestionnaire, id_utilisateur, id_test, id_boitier, valeur, 
    unite, score, statut, date_resultat) VALUES (:id_resultat, :id_gestionnaire, :id_utilisateur, :id_test, :id_boitier, :valeur,
    :unite, :score, :statut, :date_resultat)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_resultat", $resultat['id_resultat']);
    $insert->bindParam(":id_gestionnaire", $resultat['id_gestionnaire']);
    $insert->bindParam(":id_utilisateur", $resultat['id_utilisateur']);
    $insert->bindParam(":id_test", $resultat['id_test']);
    $insert->bindParam(":id_boitier", $resultat['id_boitier']);
    $insert->bindParam(":valeur", $resultat['valeur']);
    $insert->bindParam(":unite", $resultat['unite']);
    $insert->bindParam(":score", $resultat['score']);
    $insert->bindParam(":statut", $resultat['statut']);
    $insert->bindParam(":date_resultat", $resultat['date_resultat']);
    return $insert->execute();

}

/**
 * Supprime le résultat de test en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteResultat(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM resultat_test WHERE id_resultat = :id_resultat');
    $query->bindParam(":id_resultat", $id);
    $query->execute();

}
?>