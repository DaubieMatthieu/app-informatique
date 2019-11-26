CREATE DATABASE IF NOT EXISTS infinite_sense;

USE infinite_sense;

DROP TABLE IF EXISTS message_forum;
DROP TABLE IF EXISTS sujet_forum;
DROP TABLE IF EXISTS modification_faq;
DROP TABLE IF EXISTS resultat_test;
DROP TABLE IF EXISTS gestion_utilisateur;
DROP TABLE IF EXISTS question_faq;
DROP TABLE IF EXISTS inscription;
DROP TABLE IF EXISTS boitier_capteur;
DROP TABLE IF EXISTS entite;
DROP TABLE IF EXISTS test;
DROP TABLE IF EXISTS utilisateur;

CREATE TABLE utilisateur(
	id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
	prenom VARCHAR(30) DEFAULT NULL,
	nom VARCHAR(30) DEFAULT NULL,
	adresse_mail VARCHAR(50) NOT NULL UNIQUE,
	mot_de_passe VARCHAR(255) DEFAULT NULL,
	role CHAR NOT NULL
);

CREATE TABLE test(
	id_test INT AUTO_INCREMENT PRIMARY KEY,
	type_test VARCHAR(50) NOT NULL,
	description VARCHAR(255)
);

CREATE TABLE entite(
	id_entite INT AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(30) NOT NULL,
	adresse VARCHAR(80)
);

CREATE TABLE boitier_capteur(
	id_boitier INT AUTO_INCREMENT PRIMARY KEY,
	id_entite INT NOT NULL,
	CONSTRAINT fk_boitier_entite FOREIGN KEY (id_entite) REFERENCES entite(id_entite)
);

CREATE TABLE inscription(
	id_inscription INT AUTO_INCREMENT PRIMARY KEY,
	id_entite INT NOT NULL,
	id_utilisateur INT NOT NULL,
	CONSTRAINT fk_inscription_entite FOREIGN KEY (id_entite) REFERENCES entite(id_entite),
	CONSTRAINT fk_inscription_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE question_faq(
	id_question INT AUTO_INCREMENT PRIMARY KEY,
	question TEXT NOT NULL,
	reponse TEXT NOT NULL
);

CREATE TABLE gestion_utilisateur(
	id_gestion INT AUTO_INCREMENT PRIMARY KEY,
	id_admin INT NOT NULL,
	id_utilisateur INT NOT NULL,
	action CHAR NOT NULL,
	date_gestion DATETIME NOT NULL,
	changement_utilisateur TEXT,
	CONSTRAINT fk_gestion_admin FOREIGN KEY (id_admin) REFERENCES utilisateur(id_utilisateur),
	CONSTRAINT fk_gestion_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE resultat_test(
	id_resultat INT AUTO_INCREMENT PRIMARY KEY,
	id_gestionnaire INT NOT NULL,
	id_utilisateur INT NOT NULL,
	id_test INT NOT NULL,
	id_boitier INT NOT NULL,
	valeur FLOAT NOT NULL,
	unite VARCHAR(10) NOT NULL,
	score INT,
	statut CHAR NOT NULL,
	date_resultat DATETIME NOT NULL,
	CONSTRAINT fk_resultat_gestionnaire FOREIGN KEY (id_gestionnaire) REFERENCES utilisateur(id_utilisateur),
	CONSTRAINT fk_resultat_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
	CONSTRAINT fk_resultat_test FOREIGN KEY (id_test) REFERENCES test(id_test),
	CONSTRAINT fk_resultat_boitier FOREIGN KEY (id_boitier) REFERENCES boitier_capteur(id_boitier)
);

CREATE TABLE modification_faq(
	id_modification INT AUTO_INCREMENT PRIMARY KEY,
	id_question INT NOT NULL,
	id_admin INT NOT NULL,
	date_modification DATETIME NOT NULL,
	changement_faq TEXT,
	CONSTRAINT fk_modification_faq_admin FOREIGN KEY (id_admin) REFERENCES utilisateur(id_utilisateur),
	CONSTRAINT fk_modification_faq_question FOREIGN KEY (id_question) REFERENCES question_faq(id_question)
);

CREATE TABLE sujet_forum(
	id_sujet INT AUTO_INCREMENT PRIMARY KEY,
	id_utilisateur INT NOT NULL,
	titre VARCHAR(255) NOT NULL,
	date_creation_sujet DATETIME NOT NULL,
	CONSTRAINT fk_sujet_forum_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE message_forum(
	id_message INT AUTO_INCREMENT PRIMARY KEY,
	id_sujet INT NOT NULL,
	id_utilisateur INT NOT NULL,
	message TEXT NOT NULL,
	date_poste DATETIME NOT NULL,
	CONSTRAINT fk_message_forum_sujet FOREIGN KEY (id_sujet) REFERENCES sujet_forum(id_sujet),
	CONSTRAINT fk_message_forum_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

INSERT INTO utilisateur (prenom, nom, adresse_mail, mot_de_passe, role) VALUES
('Jean','Jacques','jean.jacques@infinitesense.fr', SHA2('introuvable',256),'U'),
('Paul','Pierre','paul.pierre@infinitesense.fr', SHA2('introuvable',256),'U'),
('Tom','Pot','tom.pot@infinitesense.fr', SHA2('introuvable',256),'U'),
('Thierry','GÃ©rard','thierry.gerard@infinitesense.fr', SHA2('introuvable',256),'G'),
('Didier','Robert','didier.robert@infinitesense.fr', SHA2('introuvable',256),'G'),
('John','Rambo','john.rambo@infinitesense.fr', SHA2('introuvable',256),'A');

INSERT INTO test (type_test, description) VALUES
('FrÃ©quence cardiaque', 'Ã§a sert à mesurer combien ton coeur il bat'),
('Mesure du stress', 'pour savoir comment tu stress'),
('RÃ©flexes', 'montre comment t\'es rapide');

INSERT INTO entite (nom, adresse) VALUES
('AutoÃ©cole','Pas trop loin'),
('Ecole de pilotes','Un peu plus loin là'),
('Labo de recherche','Quelque part là-bas');

INSERT INTO boitier_capteur (id_entite) VALUES
(1),(1),(2),(2),(3),(3);

INSERT INTO inscription (id_entite, id_utilisateur) VALUES
(1, 1),
(2, 1),
(3, 2),
(3, 3),
(2, 4),
(2, 2),
(1, 4),
(2, 5),
(3, 5);

INSERT INTO question_faq (question, reponse) VALUES
('J\'ai du mal à dormir, comment Ã§a se fait ?','C\'est trÃ¨s simple Benjamin'),
('Pourquoi j\'ai des mycoses ?','C\'est trÃ¨s simple Benjamin'),
('Pourquoi ma vie est nulle ?','C\'est trÃ¨s simple Benjamin');

INSERT INTO resultat_test (id_gestionnaire, id_utilisateur, id_test, id_boitier, valeur, unite, score, statut, date_resultat) VALUES
(4, 1, 1, 1, 60, 'bpm', 500, 'F', '2019-10-25 09:30:00'),
(4, 2, 1, 2, 70, 'bpm', 600, 'F', '2019-10-25 10:30:00'),
(5, 2, 3, 3, 0.1, 's', 750, 'F', '2019-10-25 11:30:00'),
(5, 3, 2, 4, 40, '°C', 500, 'F', '2019-10-25 12:30:00'),
(5, 3, 3, 5, 0.2, 's', 630, 'F', '2019-10-25 13:30:00');

INSERT INTO `sujet_forum` (id_utilisateur, titre, date_creation_sujet) VALUES
(6, 'J\'ai du mal Ã  dormir comment Ã§a se fait ?', '2019-11-26 17:16:19'),
(2, 'Pourquoi ma vie est nulle ?', '2019-11-26 17:17:22');

INSERT INTO `message_forum` (id_sujet, id_utilisateur, message, date_poste) VALUES
(1, 6, 'J\'ai du mal Ã  dormir comment Ã§a se fait ?', '2019-11-26 17:16:19'),
(1, 3, 'C\'est trÃ¨s simple Benjamin', '2019-11-26 17:16:48'),
(2, 2, 'Pourquoi ma vie est nulle ?', '2019-11-26 17:17:22'),
(2, 3, 'C\'est trÃ¨s simple Benjamin', '2019-11-26 17:17:43');
