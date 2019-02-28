<?php

/*
 * SMARTY_MODELE.php
 */

require_once '../libs/smarty/Smarty.class.php';
$smarty = new Smarty;

$lsMessage = "";

try {
    $lsMessage = "OK";
} catch (Exception $exc) {
    $lsMessage = $exc->getTraceAsString();
}

$smarty->assign("message", $lsMessage);
$smarty->display('MODELE_SMARTY.tpl');

?>
