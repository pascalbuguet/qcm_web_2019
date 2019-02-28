<?php
/*
 * delete_question.php
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

require_once '../daos/Connexion.php';

$lsMessage = "";
$lsQCMs = "";
$lsQuestions = "";

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
        $lsQCMs .= "<option value='$record[0]'>$record[0]</option>";
    }
    // Fermeture du curseur (facultatif)
    $lrs->closeCursor();


    /*
     * LISTE QUESTIONS
     */
    $qcms = filter_input(INPUT_GET, "qcms");
    if ($qcms != null) {
        // ORDRE SQL
        $sql = "SELECT id_question, question FROM questions_test WHERE qcm = ? ORDER BY question";

        // COMPILATION
        $lrs = $lcnx->prepare($sql);
        // VALORISATION DES PARAMETRES
        $lrs->bindParam(1, $qcms);
        // EXECUTION DE LA REQUETE
        $lrs->execute();

        $lrs->setFetchMode(PDO::FETCH_NUM);

        // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
        foreach ($lrs as $record) {
            // Récupération des valeurs par concaténation et interpolation
            $lsQuestions .= "<option value='$record[0]'>$record[1]</option>";
        }
        // Fermeture du curseur (facultatif)
        $lrs->closeCursor();
    }

    /*
     * SUPPRESSION
     */
    $questions = filter_input(INPUT_GET, "questions");
    if ($questions != null) {
        $lcnx->beginTransaction();
        
        // ORDRE SQL
        $sql = "DELETE FROM questions_test WHERE id_question = ?";

        // COMPILATION
        $lcmd = $lcnx->prepare($sql);
        // VALORISATION DES PARAMETRES
        $lcmd->bindParam(1, $questions);
        // EXECUTION DE LA REQUETE
        $lcmd->execute();
        
        $lcnx->commit();
        
        $lsMessage = $lcmd->rowcount() . " enregistrement supprimé";
    }
} catch (Exception $exc) {
    $lsMessage = $exc->getMessage();
}
$lcnx = null;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>delete_question_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php
            include 'menu.php';
            ?>
            <h1>DELETE Question</h1>

            <!--
            AFFICHAGE LISTE QCMS
            -->
            <section class='row'>
                <form class="form-horizontal" role="form" action="" method="GET">
                    <div class="form-group">
                        <label for="qcms" class="col-sm-2 control-label">QCMs</label>
                        <div class="col-sm-8">
                            <select class="form-control" size="5" id="qcms" name="qcms">
                                <?php
                                echo $lsQCMs;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-8">
                            <button name="btnSelectQCM" type="submit" class="btn btn-success">Valider Sélection QCM</button>
                        </div>
                    </div>
                </form>
            </section>

            <!--
            AFFICHAGE LISTE QUESTIONS
            -->

            <section class='row'>
                <form class="form-horizontal" role="form" action="" method="GET">
                    <div class="form-group">
                        <label for="questions" class="col-sm-2 control-label">Questions</label>
                        <div class="col-sm-8">
                            <select class="form-control" size="5" id="questions" name="questions">
                                <?php
                                echo $lsQuestions;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-8">
                            <button name="btnDeleteQuestion" type="submit" class="btn btn-success">Valider DELETE question</button>
                        </div>
                    </div>
                </form>
            </section>
            <!--
            MESSAGE
            -->
            <div class="form-group">
                <div class="col-md-offset-2 col-sm-8">
                    <label>
                        <?php
                        echo $lsMessage;
                        ?>
                    </label>
                </div>
            </div>

        </div>
    </body>
</html>

