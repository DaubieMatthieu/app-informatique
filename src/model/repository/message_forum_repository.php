<?php

/**
 * Recherche un message du forum en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getMessageByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM message_forum WHERE id_message = :id_message');
    $query->bindParam(":id_message", $id);
    $query->execute();

    return $query->fetchAll();
}

/**
 * Recherche un message du forum en fonction des paramètres
 * @param PDO $bdd
 * @param array $params
 * @return array
 */
function getMessageByParams(PDO $bdd, array $params){
    $where = "";
    foreach($params as $key => $value) {
        $where .= "$key = :$key" . ", ";
    }
    $where = substr_replace($where, '', -2, 2);

    $query = $bdd->prepare('SELECT * FROM message_forum WHERE ' . $where);

    foreach($params as $key => $value) {
        $query->bindParam(":$key", $value);
    }
    $query->execute();

    return $query->fetchAll();
}

/**
 * Récupère tous les enregistrements de la table message_forum
 * @param PDO $bdd
 * @return array
 */
function getAllMessages(PDO $bdd){
    $query = 'SELECT * FROM message_forum';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute un nouveau message du forum dans la base de données
 * @param PDO $bdd
 * @param array $message
 */
function addMessage(PDO $bdd, array $message) {

    $query = ' INSERT INTO message_forum (id_message, id_sujet, id_utilisateur, message, date_poste) 
    VALUES (:id_message, :id_sujet, :id_utilisateur, :message, :date_poste)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_message", $message['id_message']);
    $insert->bindParam(":id_sujet", $message['id_sujet']);
    $insert->bindParam(":id_utilisateur", $message['id_utilisateur']);
    $insert->bindParam(":message", $message['message']);
    $insert->bindParam(":date_poste", $message['date_poste']);
    return $insert->execute();

}

/**
 * Supprime le message du forum en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteMessage(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM message_forum WHERE id_message = :id_message');
    $query->bindParam(":id_message", $id);
    $query->execute();

}
?>