<?php
/*
 * new_question.php
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

session_start();

$lsMessage = "";
$lsQcms="";

$lcnx = seConnecter("../../conf/locale.ini");

/*
 * Remplissage de la liste déroulante des QCMs de la BD
 */

$sql = "SELECT qcm FROM qcms ORDER BY qcm";
$lrs = $lcnx->query($sql);
while($enr = $lrs->fetch()){
    $lsQcms .= "<option>" . $enr[0] . "</option>\n";
    
}
$lrs->closeCursor();

$qcm = filter_input(INPUT_GET, "qcm");
if ($qcm != null) {
    $lsMessage = "Jusque là tout va bien !!!";

    $question = filter_input(INPUT_GET, "question");
    $reponse1 = filter_input(INPUT_GET, "reponse1");
    $reponse2 = filter_input(INPUT_GET, "reponse2");
    $reponse3 = filter_input(INPUT_GET, "reponse3");

    $bonneReponse = filter_input(INPUT_GET, "bonneReponse");

    if ($question != null && $reponse1 != null && $reponse2 != null && $bonneReponse != null) {

        try {
            $lcnx->beginTransaction();
            $sql = "INSERT INTO questions(qcm, rang, question, reponse_1, reponse_2, reponse_3, blanc, bonne_reponse) VALUES(?,?,?,?,?,?,?,?)";

            $lcmd = $lcnx->prepare($sql);

            $blanc = "";
            $rang = 1;
            if ($reponse3 == "") {
                
            }

            $lcmd->bindParam(1, $qcm, PDO::PARAM_STR);
            $lcmd->bindParam(2, $rang);
            $lcmd->bindParam(3, $question, PDO::PARAM_STR);
            $lcmd->bindParam(4, $reponse1, PDO::PARAM_STR);
            $lcmd->bindParam(5, $reponse2, PDO::PARAM_STR);
            $lcmd->bindParam(6, $reponse3, PDO::PARAM_STR);
            $lcmd->bindParam(7, $blanc, PDO::PARAM_STR);
            $lcmd->bindParam(8, $bonneReponse);

            $lcmd->execute();

            $lcnx->commit();
        } catch (Exception $exc) {
            $lcnx->rollBack();
            $lsMessage = $exc->getMessage();
        }
    } else {
        $lsMessage = "Toutes les saisies sont obligatoires !!!";
    }
} else {
    $lsMessage = "Veuillez saisir un domaine !";
}
$qcm = "";
if (isSet($_SESSION["qcm"])) {
    $qcm = $_SESSION["qcm"];
}

$lcnx = null;

$smarty->assign("qcms", $lsQcms);
$smarty->assign("message", $lsMessage);

$smarty->display('../boundaries/new_question_ihm.tpl');

?>

