SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

CREATE DATABASE IF NOT EXISTS qcm DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE qcm;

DROP TABLE IF EXISTS candidats;
CREATE TABLE candidats (
  id_candidat int(10) UNSIGNED NOT NULL,
  nom varchar(45) NOT NULL,
  prenom varchar(45) NOT NULL,
  date_de_naissance date NOT NULL,
  stage varchar(45) NOT NULL,
  email varchar(45) NOT NULL,
  telephone varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS candidats_qcms;
CREATE TABLE candidats_qcms (
  id_candidat int(10) UNSIGNED NOT NULL,
  qcm varchar(45) NOT NULL,
  date_qcm date NOT NULL,
  note varchar(45) NOT NULL,
  avis varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS qcms;
CREATE TABLE qcms (
  qcm varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
  id_question int(10) UNSIGNED NOT NULL,
  qcm varchar(45) NOT NULL,
  rang int(10) UNSIGNED NOT NULL,
  question varchar(300) NOT NULL,
  reponse_1 varchar(300) NOT NULL,
  reponse_2 varchar(300) NOT NULL,
  reponse_3 varchar(300) NOT NULL,
  blanc varchar(50) NOT NULL,
  bonne_reponse int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS stages;
CREATE TABLE stages (
  stage varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE candidats
  ADD PRIMARY KEY (id_candidat),
  ADD UNIQUE KEY Index_nom_prenom_naissance (nom,prenom,date_de_naissance),
  ADD UNIQUE KEY Index_email (email),
  ADD KEY FK_candidats_stage (stage);

ALTER TABLE candidats_qcms
  ADD PRIMARY KEY (id_candidat,qcm),
  ADD KEY FK_candidats_qcms_qcm (qcm);

ALTER TABLE qcms
  ADD PRIMARY KEY (qcm) USING BTREE;

ALTER TABLE questions
  ADD PRIMARY KEY (id_question) USING BTREE,
  ADD KEY FK_questions_qcm (qcm);

ALTER TABLE stages
  ADD PRIMARY KEY (stage) USING BTREE;


ALTER TABLE candidats
  MODIFY id_candidat int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE questions
  MODIFY id_question int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE candidats
  ADD CONSTRAINT FK_candidats_stage FOREIGN KEY (stage) REFERENCES stages (stage);

ALTER TABLE candidats_qcms
  ADD CONSTRAINT FK_candidats_qcms_candidat FOREIGN KEY (id_candidat) REFERENCES candidats (id_candidat) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT FK_candidats_qcms_qcm FOREIGN KEY (qcm) REFERENCES qcms (qcm);

ALTER TABLE questions
  ADD CONSTRAINT FK_questions_qcm FOREIGN KEY (qcm) REFERENCES qcms (qcm);

SET FOREIGN_KEY_CHECKS=1;
