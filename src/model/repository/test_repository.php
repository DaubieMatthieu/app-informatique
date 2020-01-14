<?php

/**
 * Recherche un test en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getTestByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM test WHERE id_test = :id_test');
    $query->bindParam(":id_test", $id);
    $query->execute();

    return $query->fetchAll();
}

/**
 * Recherche un test en fonction des paramètres
 * @param PDO $bdd
 * @param array $params
 * @return array
 */
function getTestByParams(PDO $bdd, array $params){
    $where = "";
    foreach($params as $key => $value) {
        $where .= "$key = :$key" . ", ";
    }
    $where = substr_replace($where, '', -2, 2);

    $query = $bdd->prepare('SELECT * FROM test WHERE ' . $where);

    foreach($params as $key => $value) {
        $query->bindParam(":$key", $value);
    }
    $query->execute();

    return $query->fetchAll();
}

/**
 * Récupère tous les enregistrements de la table test
 * @param PDO $bdd
 * @return array
 */
function getAllTests(PDO $bdd){
    $query = 'SELECT * FROM test';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute un nouveau test dans la base de données
 * @param PDO $bdd
 * @param array $test
 */
function addTest(PDO $bdd, array $test) {

    $query = ' INSERT INTO test (id_test, type_test, description) VALUES (:id_test, :type_test, :description)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_test", $test['id_test']);
    $insert->bindParam(":type_test", $test['type_test']);
    $insert->bindParam(":description", $test['description']);
    return $insert->execute();

}

/**
 * Supprime le test en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteTest(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM test WHERE id_test = :id_test');
    $query->bindParam(":id_test", $id);
    $query->execute();

}
?>