<?php

/*
 * delete_qcm_ctrl.php
 */
/*
  CREATE TABLE  `qcm`.`qcms` (
  `qcm` varchar(50) NOT NULL,
  PRIMARY KEY (`qcm`) USING BTREE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 */

require_once '../../daos/Connexion.php';
require_once '../../libs/smarty/Smarty.class.php';
$smarty = new Smarty;

$lsMessage = "";
$lsQCMs = array();

$lcnx = seConnecter("../../conf/locale.ini");

try {

    /*
     * SUPPRESSION
     */
    $qcms = filter_input(INPUT_GET, "qcms");
    $btnDeleteQCM = filter_input(INPUT_GET, "btnDeleteQCM");
    if ($btnDeleteQCM != null) {
        $lcnx->beginTransaction();

        // ORDRE SQL
        $sql = "DELETE FROM qcms WHERE qcm = ?";

        // COMPILATION
        $lcmd = $lcnx->prepare($sql);
        // VALORISATION DES PARAMETRES
        $lcmd->bindParam(1, $qcms);
        // EXECUTION DE LA REQUETE
        $lcmd->execute();

        $lcnx->commit();

        $lsMessage = $lcmd->rowcount() . " enregistrement supprimé";
    } else {
        $lsMessage = "Vous devez sélectionner un qcm !!!";
    }

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
} catch (Exception $exc) {
    $lsMessage = $exc->getMessage();
}

$lcnx = null;

$smarty->assign("qcms", $lsQCMs);
$smarty->assign("message", $lsMessage);

$smarty->display('../boundaries/delete_qcm_ihm.tpl');
?>
