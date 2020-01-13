<?php
include('generic_repository.php');

/**
 * Recherche une inscription en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getInscriptionByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM inscription WHERE id_inscription = :id_inscription');
    $query->bindParam(":id_inscription", $id);
    $query->execute();

    return $query->fetchAll();

}

/**
 * Récupère tous les enregistrements de la table inscription
 * @param PDO $bdd
 * @return array
 */
function getAllInscriptions(PDO $bdd){
    $query = 'SELECT * FROM inscription';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute une nouvelle inscription dans la base de données
 * @param PDO $bdd
 * @param array $inscription
 */
function addUtilisateur(PDO $bdd, array $inscription) {

    $query = ' INSERT INTO inscription (id_inscription, id_entite, id_utilisateur) 
    VALUES (:id_inscription, :id_entite, :id_utilisateur)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_inscription", $inscription['id_inscription']);
    $insert->bindParam(":id_entite", $inscription['id_entite']);
    $insert->bindParam(":id_utilisateur", $inscription['id_utilisateur']);
    return $insert->execute();

}

/**
 * Supprime l'inscription en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteInscription(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM inscription WHERE id_inscription = :id_inscription');
    $query->bindParam(":id_inscription", $id);
    $query->execute();

}
?>