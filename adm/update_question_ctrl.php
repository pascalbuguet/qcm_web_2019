<?php
/*
 * update_question_ctrl.php
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

session_start();

require_once '../daos/Connexion.php';
require_once '../libs/smarty/Smarty.class.php';
$smarty = new Smarty;

$lsMessage = "";
$listeQcms = "";
$listeQuestions = "";

$qcm = "";
$question = "";
$reponse1 = "";
$reponse2 = "";
$reponse3 = "";
$bonneReponse = "";

$lcnx = seConnecter("../conf/locale.ini");

try {
    /*
     * LISTE QCMS
     */
    $sql = "SELECT qcm FROM qcms ORDER BY qcm";
    $lrs = $lcnx->query($sql);
    $lrs->setFetchMode(PDO::FETCH_NUM);

    // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
    foreach ($lrs as $record) {
        // Récupération des valeurs par concaténation et interpolation
        $listeQcms .= "<option>$record[0]</option>\n";
    }
    // Fermeture du curseur (facultatif)
    $lrs->closeCursor();


    /*
     * LISTE QUESTIONS
     */
    $qcm = filter_input(INPUT_GET, "qcms");
    $btnSelectQCM = filter_input(INPUT_GET, "btnSelectQCM");
    //echo "<hr>$qcms<hr>";
    if ($btnSelectQCM != null) {
        //$_SESSION["qcm"] = $qcm;

        // ORDRE SQL
        $sql = "SELECT id_question, question FROM questions WHERE qcm = ? ORDER BY question";

        // COMPILATION
        $lrs = $lcnx->prepare($sql);
        // VALORISATION DES PARAMETRES
        $lrs->bindParam(1, $qcm);
        // EXECUTION DE LA REQUETE
        $lrs->execute();

        $lrs->setFetchMode(PDO::FETCH_NUM);

        // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
        foreach ($lrs as $record) {
            // Récupération des valeurs par concaténation et interpolation
            $listeQuestions .= "<option value='$record[0]'>$record[1]</option>\n";
        }
        // Fermeture du curseur (facultatif)
        $lrs->closeCursor();
    }

    /*
     * AFFICHAGE ENREGISTREMENT
     */
    $questions = filter_input(INPUT_GET, "questions");
    $btnSelectQuestion = filter_input(INPUT_GET, "btnSelectQuestion");
    //echo "<hr>$questions<hr>";
    if ($btnSelectQuestion != null) {
        //echo "<hr>$questions<hr>";
        // ORDRE SQL
        $sql = "SELECT * FROM questions WHERE id_question = ?";

        // COMPILATION
        $lrs = $lcnx->prepare($sql);
        // VALORISATION DES PARAMETRES
        $lrs->bindParam(1, $questions);
        // EXECUTION DE LA REQUETE
        $lrs->execute();
        // SELECT ONE
        $lrs->setFetchMode(PDO::FETCH_ASSOC);

        $enr = $lrs->fetch();

        $qcm = $enr["qcm"];
        $question = $enr["question"];
        $reponse1 = $enr["reponse_1"];
        $reponse2 = $enr["reponse_2"];
        $reponse3 = $enr["reponse_3"];
        $bonneReponse = $enr["bonne_reponse"];

        $_SESSION["idQuestion"] = $enr["id_question"];

        $lrs->closeCursor();
    }


    /*
     * MODIFICATION
     */
    $btnValiderUpdate = filter_input(INPUT_GET, "btnValiderUpdate");
    //echo "<hr>$qcm<hr>";
    if ($btnValiderUpdate != null) {
        //echo "modif";
        $lsMessage .= "MODIF - ";
        $lcnx->beginTransaction();

        $qcm = filter_input(INPUT_GET, "qcm");
        $question = filter_input(INPUT_GET, "question");
        $reponse1 = filter_input(INPUT_GET, "reponse1");
        $reponse2 = filter_input(INPUT_GET, "reponse2");
        $reponse3 = filter_input(INPUT_GET, "reponse3");
        $bonneReponse = filter_input(INPUT_GET, "bonneReponse");

        // ORDRE SQL
        $sql = "UPDATE questions SET question=?, reponse_1=?, reponse_2=?, reponse_3=?, bonne_reponse=? WHERE id_question = ?";

        // COMPILATION
        $lcmd = $lcnx->prepare($sql);
        // VALORISATION DES PARAMETRES
        $lcmd->bindParam(1, $question);
        $lcmd->bindParam(2, $reponse1);
        $lcmd->bindParam(3, $reponse2);
        $lcmd->bindParam(4, $reponse3);
        $lcmd->bindParam(5, $bonneReponse);
        $lcmd->bindParam(6, $_SESSION["idQuestion"]);
        // EXECUTION DE LA REQUETE
        $lcmd->execute();

        $lcnx->commit();

        $lsMessage = $lcmd->rowcount() . " enregistrement modifié";
    } else {
        //$lsMessage .= "Pas de modif";
    }
} catch (Exception $exc) {
    $lsMessage .= $exc->getMessage();
}
$lcnx = null;

$smarty->assign("qcms", $listeQcms);
$smarty->assign("questions", $listeQuestions);

$smarty->assign("qcm", $qcm);
$smarty->assign("question", $question);
$smarty->assign("reponse1", $reponse1);
$smarty->assign("reponse2", $reponse2);
$smarty->assign("reponse3", $reponse3);
$smarty->assign("bonneReponse", $bonneReponse);

$smarty->assign("message", $lsMessage);

$smarty->display('update_question_ihm.tpl');
?>
