<?php

/*
 * bd_2_txt_ctrl.php
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
require_once '../../daos/Connexion.php';
require_once '../../libs/smarty/Smarty.class.php';

$lsMessage = "";

$smarty = new Smarty;

$smarty->assign("message", $lsMessage);

$smarty->display('../boundaries/bd_2_txt_ihm.tpl');

?>


