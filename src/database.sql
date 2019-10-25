CREATE DATABASE IF NOT EXISTS infinite_sense;

use infinite_sense;

CREATE TABLE IF NOT EXISTS utilisateur(
	id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	adresse_mail VARCHAR(30) NOT NULL,
	mot_de_passe VARCHAR(255) NOT NULL,
	role CHAR NOT NULL
);

CREATE TABLE IF NOT EXISTS test(
	id_test INT AUTO_INCREMENT PRIMARY KEY,
	type_test VARCHAR(50) NOT NULL,
	description VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS question_faq(
	id_question INT AUTO_INCREMENT PRIMARY KEY,
	question TEXT NOT NULL,
	reponse TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS gestion_utilisateur(
	id_gestion INT AUTO_INCREMENT PRIMARY KEY,
	id_admin INT NOT NULL,
	id_utilisateur INT NOT NULL,
	action CHAR NOT NULL,
	date_gestion DATETIME NOT NULL,
	changement_utilisateur TEXT,
	CONSTRAINT fk_gestion_admin FOREIGN KEY (id_admin) REFERENCES utilisateur(id_utilisateur),
	CONSTRAINT fk_gestion_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE IF NOT EXISTS resultat_test(
	id_resultat INT AUTO_INCREMENT PRIMARY KEY,
	id_gestionnaire INT NOT NULL,
	id_utilisateur INT NOT NULL,
	id_test INT NOT NULL,
	valeur INT NOT NULL,
	unite VARCHAR(10) NOT NULL,
	score INT,
	statut CHAR NOT NULL,
	CONSTRAINT fk_resultat_gestionnaire FOREIGN KEY (id_gestionnaire) REFERENCES utilisateur(id_utilisateur),
	CONSTRAINT fk_resultat_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
	CONSTRAINT fk_resultat_test FOREIGN KEY (id_test) REFERENCES test(id_test)
);

CREATE TABLE IF NOT EXISTS modification_faq(
	id_modification INT AUTO_INCREMENT PRIMARY KEY,
	id_question INT NOT NULL,
	id_admin INT NOT NULL,
	date_modification DATETIME NOT NULL,
	changement_faq TEXT,
	CONSTRAINT fk_modification_faq_admin FOREIGN KEY (id_admin) REFERENCES utilisateur(id_utilisateur),
	CONSTRAINT fk_modification_faq_question FOREIGN KEY (id_question) REFERENCES question_faq(id_question)
);

CREATE TABLE IF NOT EXISTS sujet_forum(
	id_sujet INT AUTO_INCREMENT PRIMARY KEY,
	id_utilisateur INT NOT NULL,
	titre VARCHAR(255) NOT NULL,
	date_creation_sujet DATETIME NOT NULL,
	CONSTRAINT fk_sujet_forum_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE IF NOT EXISTS message_forum(
	id_message INT AUTO_INCREMENT PRIMARY KEY,
	id_sujet INT NOT NULL,
	id_utilisateur INT NOT NULL,
	message TEXT NOT NULL,
	date_poste DATETIME NOT NULL,
	CONSTRAINT fk_message_forum_sujet FOREIGN KEY (id_sujet) REFERENCES sujet_forum(id_sujet),
	CONSTRAINT fk_message_forum_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);
