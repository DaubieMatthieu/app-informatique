<?php
include('generic_repository.php');

/**
 * Recherche un utilisateur en fonction de l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getUtilisateurByID(PDO $bdd, $id){

    $query = $bdd->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur');
    $query->bindParam(":id_utilisateur", $id);
    $query->execute();

    return $query->fetchAll();

}

/**
 * Recherche un utilisateur en fonction des paramètres
 * @param PDO $bdd
 * @param array $params
 * @return array
 */
function getUtilisateurByParams(PDO $bdd, array $params){
    $where = "";
    foreach($params as $key => $value) {
        $where .= "$key = :$key" . ", ";
    }
    $where = substr_replace($where, '', -2, 2);

    $query = $bdd->prepare('SELECT * FROM utilisateur WHERE ' . $where);

    foreach($params as $key => $value) {
        $query->bindParam(":$key", $value);
    }
    $query->execute();

    return $query->fetchAll();
}

/**
 * Récupère tous les enregistrements de la table utilisateur
 * @param PDO $bdd
 * @return array
 */
function getAllUtilisateurs(PDO $bdd){
    $query = 'SELECT * FROM utilisateur';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute un nouvel utilisateur dans la base de données
 * @param PDO $bdd
 * @param array $utilisateur
 */
function addUtilisateur(PDO $bdd, array $utilisateur) {

    $query = ' INSERT INTO utilisateur (id_utilisateur, nom, prenom, adresse_mail, mot_de_passe, role) 
    VALUES (:id_utilisateur, :nom, :prenom, :adresse_mail, :adresse_mail, :role)';
    $insert = $bdd->prepare($query);
    $insert->bindParam(":id_utilisateur", $utilisateur['id_utilisateur']);
    $insert->bindParam(":nom", $utilisateur['nom']);
    $insert->bindParam(":prenom", $utilisateur['prenom']);
    $insert->bindParam(":adresse_mail", $utilisateur['adresse_mail']);
    $insert->bindParam(":mot_de_passe", $utilisateur['mot_de_passe']);
    $insert->bindParam(":role", $utilisateur['role']);
    return $insert->execute();

}

/**
 * Supprime l'utilisateur en base ayant pour ID l'ID passé en paramètre
 * @param PDO $bdd
 * @param int $id
 */
function deleteUtilisateur(PDO $bdd, $id){

    $query = $bdd->prepare('DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur');
    $query->bindParam(":id_utilisateur", $id);
    $query->execute();

}
?>