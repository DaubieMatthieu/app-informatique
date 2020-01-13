<?php
    include('generic_repository.php');

/**
 * Recherche un boitier en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getBoitierByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM boitier_capteur WHERE id_boitier = :id_boitier');
    $query->bindParam(":id_boitier", $id);
    $query->execute();

    return $query->fetchAll();

}

/**
 * Récupère tous les enregistrements de la table boitier_capteur
 * @param PDO $bdd
 * @return array
 */
function getAllBoitiers(PDO $bdd){
    $query = 'SELECT * FROM boitier_capteur';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute un nouveau boitier dans la base de données
 * @param PDO $bdd
 * @param array $boitier
 */
function addBoitier(PDO $bdd, array $boitier) {

    $query = ' INSERT INTO boitier_capteur (id_boitier, id_entite) VALUES (:id_boitier, :id_entite)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_boitier", $boitier['id_boitier']);
    $insert->bindParam(":id_entite", $boitier['id_entite']);
    return $insert->execute();

}

/**
 * Supprime le boitier en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteBoitier(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM boitier_capteur WHERE id_boitier = :id_boitier');
    $query->bindParam(":id_boitier", $id);
    $query->execute();

}
?>