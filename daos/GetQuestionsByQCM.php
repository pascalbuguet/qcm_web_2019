<?php

/*
 * GetQuestionsByQCM.php
 */

require_once '../daos/Connexion.php';

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");

$valeur = "";
$qcm = filter_input(INPUT_GET, "qcm");

try {
    $lcn = seConnecter("../conf/locale.ini");
    $lsSQL = "SELECT question, reponse_1, reponse_2, reponse_3, bonne_reponse FROM questions WHERE qcm = ?";
    $lrs = $lcn->prepare($lsSQL);
    $lrs->bindParam(1, $qcm);
    $lrs->execute();
    $lrs->setFetchMode(PDO::FETCH_ASSOC);
    $t = array();
    while ($enr = $lrs->fetch()) {
        $t[] = $enr;
    }

    $chaineJSON = json_encode($t);

    $lcn = null;
} catch (PDOException $e) {
    $chaineJSON = "zzz";
}

echo $chaineJSON;
?>
