<?php

/*
 * CandidatsQcmsUpdate.php
 */


require_once '../daos/Connexion.php';

header("Access-Control-Allow-Origin:*");
//header("Content-Type: application/json");
header("Content-Type: text/plain");

$liAffecte = 0;
$note = filter_input(INPUT_GET, "note");
$avis = filter_input(INPUT_GET, "avis");
$id_candidat = filter_input(INPUT_GET, "id_candidat");
$qcm = filter_input(INPUT_GET, "qcm");

//$note = "70";
//$avis = "OK";
//$id_candidat = 25;
//$qcm = "php";

try {
    $lcn = seConnecter("../conf/locale.ini");
    $lcn->beginTransaction();
    $lsSQL = "UPDATE candidats_qcms SET note=?, avis=? WHERE id_candidat=? AND qcm=?";
    $lcmd = $lcn->prepare($lsSQL);
    $lcmd->bindParam(1, $note);
    $lcmd->bindParam(2, $avis);
    $lcmd->bindParam(3, $id_candidat);
    $lcmd->bindParam(4, $qcm);
    $lcmd->execute();
    $liAffecte = $lcmd->rowcount();
    $lcn->commit();
    $lcn = null;
} catch (PDOException $e) {
    $liAffecte = $e->getMessage();
}

echo $liAffecte;
?>
