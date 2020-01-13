<?php
include('generic_repository.php');

/**
 * Recherche un sujet du forum en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getSujetByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM sujet_forum WHERE id_sujet = :id_sujet');
    $query->bindParam(":id_sujet", $id);
    $query->execute();

    return $query->fetchAll();

}

/**
 * Récupère tous les enregistrements de la table sujet_forum
 * @param PDO $bdd
 * @return array
 */
function getAllSujets(PDO $bdd){
    $query = 'SELECT * FROM sujet_forum';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute un nouveau sujet du forum dans la base de données
 * @param PDO $bdd
 * @param array $sujet
 */
function addSujet(PDO $bdd, array $sujet) {

    $query = ' INSERT INTO sujet_forum (id_sujet, id_utilisateur, titre, date_creation_sujet) 
    VALUES (:id_sujet, :id_utilisateur, :titre, :date_creation_sujet)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_sujet", $sujet['id_sujet']);
    $insert->bindParam(":id_utilisateur", $sujet['id_utilisateur']);
    $insert->bindParam(":titre", $sujet['titre']);
    $insert->bindParam(":date_creation_sujet", $sujet['date_creation_sujet']);
    return $insert->execute();

}

/**
 * Supprime le sujet du forum en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteSujet(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM sujet_forum WHERE id_sujet = :id_sujet');
    $query->bindParam(":id_sujet", $id);
    $query->execute();

}
?>