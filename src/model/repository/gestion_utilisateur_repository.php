<?php

/**
 * Recherche une gestion d'utilisateur en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getGestionByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM gestion_utilisateur WHERE id_gestion = :id_gestion');
    $query->bindParam(":id_gestion", $id);
    $query->execute();

    return $query->fetchAll();
}

/**
 * Recherche une gestion d'utilisateur en fonction des paramètres
 * @param PDO $bdd
 * @param array $params
 * @return array
 */
function getGestionByParams(PDO $bdd, array $params){
    $where = "";
    foreach($params as $key => $value) {
        $where .= "$key = :$key" . ", ";
    }
    $where = substr_replace($where, '', -2, 2);

    $query = $bdd->prepare('SELECT * FROM gestion_utilisateur WHERE ' . $where);

    foreach($params as $key => $value) {
        $query->bindParam(":$key", $value);
    }
    $query->execute();

    return $query->fetchAll();
}

/**
 * Récupère tous les enregistrements de la table gestion_utilisateur
 * @param PDO $bdd
 * @return array
 */
function getAllGestions(PDO $bdd){
    $query = 'SELECT * FROM gestion_utilisateur';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute une nouvelle gestion d'utilisateur dans la base de données
 * @param PDO $bdd
 * @param array $gestion
 */
function addGestion(PDO $bdd, array $gestion) {

    $query = ' INSERT INTO gestion_utilisateur (id_gestion, id_admin, id_utilisateur, action, date_gestion, changement_utilisateur) 
    VALUES (:id_gestion, :id_admin, :id_utilisateur, :action, :date_gestion, :changement_utilisateur)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_gestion", $inscription['id_gestion']);
    $insert->bindParam(":id_admin", $inscription['id_admin']);
    $insert->bindParam(":id_utilisateur", $inscription['id_utilisateur']);
    $insert->bindParam(":action", $inscription['action']);
    $insert->bindParam(":date_gestion", $inscription['date_gestion']);
    $insert->bindParam(":changement_utilisateur", $inscription['changement_utilisateur']);
    return $insert->execute();

}

/**
 * Supprime la gestion d'utilisateur en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteGestion(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM gestion_utilisateur WHERE id_gestion = :id_gestion');
    $query->bindParam(":id_gestion", $id);
    $query->execute();

}
?>