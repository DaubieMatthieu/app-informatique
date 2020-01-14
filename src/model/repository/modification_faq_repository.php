<?php

/**
 * Recherche une modification de FAQ en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getModificationByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM modification_faq WHERE id_modification = :id_modification');
    $query->bindParam(":id_modification", $id);
    $query->execute();

    return $query->fetchAll();
}

/**
 * Recherche une modification de FAQ en fonction des paramètres
 * @param PDO $bdd
 * @param array $params
 * @return array
 */
function getModificationByParams(PDO $bdd, array $params){
    $where = "";
    foreach($params as $key => $value) {
        $where .= "$key = :$key" . ", ";
    }
    $where = substr_replace($where, '', -2, 2);

    $query = $bdd->prepare('SELECT * FROM modification_faq WHERE ' . $where);

    foreach($params as $key => $value) {
        $query->bindParam(":$key", $value);
    }
    $query->execute();

    return $query->fetchAll();
}

/**
 * Récupère tous les enregistrements de la table modification_faq
 * @param PDO $bdd
 * @return array
 */
function getAllModifications(PDO $bdd){
    $query = 'SELECT * FROM modification_faq';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute une nouvelle modification de FAQ dans la base de données
 * @param PDO $bdd
 * @param array $modification
 */
function addModification(PDO $bdd, array $modification) {

    $query = ' INSERT INTO modification_faq (id_modification, id_question, id_admin, date_modification, changement_faq) 
    VALUES (:id_modification, :id_question, :id_admin, :date_modification, :changement_faq)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_modification", $modification['id_modification']);
    $insert->bindParam(":id_question", $modification['id_question']);
    $insert->bindParam(":id_admin", $modification['id_admin']);
    $insert->bindParam(":date_modification", $modification['date_modification']);
    $insert->bindParam(":changement_faq", $modification['changement_faq']);
    return $insert->execute();

}

/**
 * Supprime la modification de FAQ en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteModification(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM modification_faq WHERE id_modification = :id_modification');
    $query->bindParam(":id_modification", $id);
    $query->execute();

}
?>