<?php

/*
 * new_qcm.php
 */
/*
  CREATE TABLE  `qcm`.`qcms` (
  `id_qcm` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domaine` varchar(45) NOT NULL,
  `rang` int(10) unsigned NOT NULL,
  `question` varchar(300) NOT NULL,
  `reponse_1` varchar(300) NOT NULL,
  `reponse_2` varchar(300) NOT NULL,
  `reponse_3` varchar(300) NOT NULL,
  `blanc` varchar(50) NOT NULL,
  `bonne_reponse` int(10) unsigned NOT NULL,
 */

session_start();

require_once '../../daos/Connexion.php';

require_once '../../libs/smarty/Smarty.class.php';
$smarty = new Smarty;

$lsMessage = "";
$lsQcmsExistants = "";

$lcnx = seConnecter("../../conf/locale.ini");

$qcm = filter_input(INPUT_GET, "qcm");
if ($qcm != null) {
    $lsMessage = "Jusque là tout va bien !!!";

    try {
        $lcnx->beginTransaction();
        $sql = "INSERT INTO qcms(qcm) VALUES(?)";
        $lcmd = $lcnx->prepare($sql);
        $lcmd->bindParam(1, $qcm, PDO::PARAM_STR);
        $lcmd->execute();
        $lcnx->commit();
        $_SESSION["qcm"] = $qcm;
    } catch (Exception $exc) {
        $lcnx->rollBack();
        $lsMessage = $exc->getMessage();
    }
} else {
    $lsMessage = "Toutes les saisies sont obligatoires !!!";
}

/**
 * 
 * @param PDO $lcnx
 */
//function getQcms(PDO $lcnx) {

    try {
        $sql = "SELECT qcm FROM qcms ORDER BY qcm";
        $lrs = $lcnx->query($sql);
        $lrs->setFetchMode(PDO::FETCH_NUM);

        // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
        foreach ($lrs as $lrec) {
            // Récupération des valeurs par concaténation et interpolation
            $lsQcmsExistants .= "<option>$lrec[0]</option>";
        }
        // Fermeture du curseur (facultatif)
        $lrs->closeCursor();
    } catch (Exception $exc) {
        $lsMessage = $exc->getMessage();
    }
    
    //return $lsQcmsExistants;
//}

$lcnx = null;

$smarty->assign("qcms", $lsQcmsExistants);
$smarty->assign("message", $lsMessage);

$smarty->display('../boundaries/new_qcm_ihm.tpl');

?>
