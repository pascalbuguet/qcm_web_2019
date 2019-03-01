<?php

/*
 * delete_question_ctrl.php
 */
/*
  CREATE TABLE  `qcm`.`questions` (
  `id_question` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qcm` varchar(45) NOT NULL,
  `rang` int(10) unsigned NOT NULL,
  `question` varchar(300) NOT NULL,
  `reponse_1` varchar(300) NOT NULL,
  `reponse_2` varchar(300) NOT NULL,
  `reponse_3` varchar(300) NOT NULL,
  `blanc` varchar(50) NOT NULL,
  `bonne_reponse` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_question`) USING BTREE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 */

require_once '../../daos/Connexion.php';
require_once '../../libs/smarty/Smarty.class.php';
$smarty = new Smarty;

$lsMessage = "";
$lsQCMs = array();
$lsQuestions = "";

$lcnx = seConnecter("../../conf/locale.ini");

try {
    /*
     * LISTE QCMS
     */
    $sql = "SELECT qcm FROM qcms ORDER BY qcm";
    $lrs = $lcnx->query($sql);
    $lrs->setFetchMode(PDO::FETCH_NUM);

    // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
    foreach ($lrs as $record) {
        // Récupération des valeurs par concaténation et interpolation
        $lsQCMs[] = $record[0];
    }
    // Fermeture du curseur (facultatif)
    $lrs->closeCursor();


    /*
     * LISTE QUESTIONS
     */
    $qcms = filter_input(INPUT_GET, "qcms");
    $btnSelectQCM = filter_input(INPUT_GET, "btnSelectQCM");
    if ($btnSelectQCM != null) {
        // ORDRE SQL
        $sql = "SELECT id_question, question FROM questions WHERE qcm = ? ORDER BY question";

        // COMPILATION
        $lrs = $lcnx->prepare($sql);
        // VALORISATION DES PARAMETRES
        $lrs->bindParam(1, $qcms);
        // EXECUTION DE LA REQUETE
        $lrs->execute();

        $lrs->setFetchMode(PDO::FETCH_NUM);

        // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
        foreach ($lrs as $record) {
            // Récupération des valeurs par concaténation et interpolation
            $lsQuestions .= "<option value='$record[0]'>$record[1]</option>\n";
        }
        // Fermeture du curseur (facultatif)
        $lrs->closeCursor();
    } else {
        $lsMessage = "Vous devez sélectionner un qcm et/ou une question !!!";
    }

    /*
     * SUPPRESSION
     */
    $questions = filter_input(INPUT_GET, "questions");
    $btnDeleteQuestion = filter_input(INPUT_GET, "btnDeleteQuestion");
    if ($btnDeleteQuestion != null) {
        $lcnx->beginTransaction();

        // ORDRE SQL
        $sql = "DELETE FROM questions WHERE id_question = ?";

        // COMPILATION
        $lcmd = $lcnx->prepare($sql);
        // VALORISATION DES PARAMETRES
        $lcmd->bindParam(1, $questions);
        // EXECUTION DE LA REQUETE
        $lcmd->execute();

        $lcnx->commit();

        $lsMessage = $lcmd->rowcount() . " enregistrement supprimé";
    } else {
        $lsMessage = "Vous devez sélectionner un qcm et/ou une question !!!";
    }
} catch (Exception $exc) {
    $lsMessage = $exc->getMessage();
}

$lcnx = null;

$smarty->assign("qcms", $lsQCMs);
$smarty->assign("questions", $lsQuestions);
$smarty->assign("message", $lsMessage);

$smarty->display('../boundaries/delete_question_ihm.tpl');
?>
