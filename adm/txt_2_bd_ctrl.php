<?php

/*
 * txt_2_bd_ctrl.php
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
require_once '../daos/Connexion.php';
require_once '../libs/smarty/Smarty.class.php';

$smarty = new Smarty;

$lsMessage = "";
$tFiles = array();

try {
    $lsChemin = "../sources_txt/";

// --- "Ouverture" du repertoire
    $loDossier = opendir($lsChemin);

// --- Pointage sur la premiere entree
// --- readdir renvoie la premiere entree puis la suivante et enfin faux lorsqu'il n'y a plus d'entrees
// --- Affichage du nom du fichier (ou sous-répertoire)

    while ($lsNomFichier = readdir($loDossier)) {
        if ($lsNomFichier != "." && $lsNomFichier != ".." && substr($lsNomFichier, -8) == "_qcm.txt") {
            $lsNomFichier = substr($lsNomFichier, 0, -8);
            $tFiles[] = $lsNomFichier;
        }
    }
// --- Fermeture
    closedir($loDossier);
} catch (Exception $exc) {
    $tFiles[] = $exc->getMessage();
}


$domaine = filter_input(INPUT_GET, "domaine");
if ($domaine != null) {
    $lsMessage .= "Jusque là tout va bien !!!<br>";
    try {
        //$lsMessage = $lcmd->rowcount() . " enregistrement(s) ajouté(s)";
        $fichier = "../sources_txt/" . $domaine . "_qcm.txt";
        $lsMessage .= $fichier . "<br>";
        if (file_exists($fichier)) {
            $lcnx = seConnecter("../conf/locale.ini");

            /*
             * INSERTION
             */
            $lcnx->beginTransaction();
            $lsSQL = "INSERT INTO questions(qcm, rang, question, reponse_1, reponse_2, reponse_3, blanc, bonne_reponse) VALUES(?,?,?,?,?,?,?,?)";
            $lcmd = $lcnx->prepare($lsSQL);

            // --- Ouverture pour lecture
            $canal = fopen($fichier, "r");
            $ligne = fgets($canal); // Les entetes
            $rang = 0;
            // --- Lecture du fichier
            // --- Test jusqu'a la fin du fichier
            while (!feof($canal)) {
                // --- Lecture d'une ligne jusqu'au RC compris
                $ligne = fgets($canal);

                if (!empty($ligne)) {
                    $t = explode(";", $ligne);

                    $rang++;

                    $question = $t[1];
                    $reponse1 = $t[2];
                    $reponse2 = $t[3];
                    $reponse3 = $t[4];
                    $blanc = "";
                    $bonneReponse = $t[6];

                    $lcmd->bindParam(1, $domaine, PDO::PARAM_STR);
                    $lcmd->bindParam(2, $rang, PDO::PARAM_INT);
                    $lcmd->bindParam(3, $question, PDO::PARAM_STR);
                    $lcmd->bindParam(4, $reponse1, PDO::PARAM_STR);
                    $lcmd->bindParam(5, $reponse2, PDO::PARAM_STR);
                    $lcmd->bindParam(6, $reponse3, PDO::PARAM_STR);
                    $lcmd->bindParam(7, $blanc, PDO::PARAM_STR);
                    $lcmd->bindParam(8, $bonneReponse, PDO::PARAM_INT);

                    $lcmd->execute();
                }
            } /// boucle
            $lcnx->commit();
            // --- Fermeture du fichier
            fclose($canal);
            seDeconnecter($lcnx);

            // --- Affichage
            $lsMessage .= "Transfert terminé !!!<br>";
        } else {
            $lsMessage .= "Le fichier source n'existe pas !!!<br>";
        }
    } catch (Exception $exc) {
        $lcnx->rollBack();
        $lsMessage .= $exc->getMessage() . "<br>";
    }
} else {
    $lsMessage .= "Veuillez sélectionner un domaine !<br>";
}

//include './txt_2_bd_ihm.php';

$smarty->assign("tableauTXT", $tFiles);
$smarty->assign("message", $lsMessage);

$smarty->display('txt_2_bd_ihm.tpl');
?>
