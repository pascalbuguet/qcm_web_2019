<?php

/*
 * GetNbQuestionsByQCM.php
 */

require_once '../daos/Connexion.php';

header("Access-Control-Allow-Origin:*");
//header("Content-Type: application/json");
header("Content-Type: text/plain");


$valeur = "";
$qcm = filter_input(INPUT_GET, "qcm");

try {
    $lcn = seConnecter("../conf/locale.ini");
    $lsSQL = "SELECT COUNT(*) AS count FROM questions WHERE qcm = ?";
    $lrs = $lcn->prepare($lsSQL);
    $lrs->bindParam(1, $qcm);
    $lrs->execute();
    $enr = $lrs->fetch();
    $valeur = $enr[0];

    $lcn = null;
} catch (PDOException $e) {
    
}

echo $valeur;
?>
