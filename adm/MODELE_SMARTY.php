<?php

/*
 * smarty_modele_ctrl.php
 */

require_once '../daos/Connexion.php';
require_once '../libs/smarty/Smarty.class.php';
$smarty = new Smarty;

$lsMessage = "";

try {
    
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}



$smarty->assign("message", $lsMessage);

$smarty->display('_ihm.tpl');

//include './bd_2_txt_ihm.php';
?>
