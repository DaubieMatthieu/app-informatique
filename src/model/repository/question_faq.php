<?php
include('generic_repository.php');

/**
 * Recherche une question de FAQ en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getQuestionByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM question_faq WHERE id_question = :id_question');
    $query->bindParam(":id_question", $id);
    $query->execute();

    return $query->fetchAll();

}

/**
 * Récupère tous les enregistrements de la table question_faq
 * @param PDO $bdd
 * @return array
 */
function getAllQuestions(PDO $bdd){
    $query = 'SELECT * FROM question_faq';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute une nouvelle question de FAQ dans la base de données
 * @param PDO $bdd
 * @param array $question
 */
function addQuestion(PDO $bdd, array $question) {

    $query = ' INSERT INTO question_faq (id_question, question, reponse) VALUES (:id_question, :question, :reponse)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_question", $question['id_question']);
    $insert->bindParam(":question", $question['question']);
    $insert->bindParam(":reponse", $question['reponse']);
    return $insert->execute();

}

/**
 * Supprime la question de FAQ en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteQuestion(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM question_faq WHERE id_question = :id_question');
    $query->bindParam(":id_question", $id);
    $query->execute();

}
?>