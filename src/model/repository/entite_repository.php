<?php

/**
 * Recherche une entité en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getEntiteByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM entite WHERE id_entite = :id_entite');
    $query->bindParam(":id_entite", $id);
    $query->execute();

    return $query->fetchAll();
}

/**
 * Recherche une entité en fonction des paramètres
 * @param PDO $bdd
 * @param array $params
 * @return array
 */
function getEntiteByParams(PDO $bdd, array $params){
    $where = "";
    foreach($params as $key => $value) {
        $where .= "$key = :$key" . ", ";
    }
    $where = substr_replace($where, '', -2, 2);

    $query = $bdd->prepare('SELECT * FROM entite WHERE ' . $where);

    foreach($params as $key => $value) {
        $query->bindParam(":$key", $value);
    }
    $query->execute();

    return $query->fetchAll();
}

/**
 * Récupère tous les enregistrements de la table entite
 * @param PDO $bdd
 * @return array
 */
function getAllEntites(PDO $bdd){
    $query = 'SELECT * FROM entite';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute une nouvelle entité dans la base de données
 * @param PDO $bdd
 * @param array $entite
 */
function addEntite(PDO $bdd, array $entite) {

    $query = ' INSERT INTO sujet_forum (id_entite, nom, adresse) VALUES (:id_entite, :nom, :adresse)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_entite", $entite['id_entite']);
    $insert->bindParam(":nom", $entite['nom']);
    $insert->bindParam(":adresse", $entite['adresse']);
    return $insert->execute();

}

/**
 * Supprime l'entité en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteEntite(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM entite WHERE id_entite = :id_entite');
    $query->bindParam(":id_entite", $id);
    $query->execute();

}
?>