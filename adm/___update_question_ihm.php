<?php
/*
 * update_question.php
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

$lsMessage = "";
$lsQCMs = "";
$lsQuestions = "";

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
        $lsQCMs .= "<option value='$record[0]'>$record[0]</option>";
    }
    // Fermeture du curseur (facultatif)
    $lrs->closeCursor();


    /*
     * LISTE QUESTIONS
     */
    $qcms = filter_input(INPUT_GET, "qcms");
    //echo "<hr>$qcms<hr>";
    if ($qcms != null) {
        $_SESSION["qcm"] = $qcms;

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
     * AFFICHAGE ENREGISTREMENT
     */
    $questions = filter_input(INPUT_GET, "questions");
    //echo "<hr>$questions<hr>";
    if ($questions != null) {
        // ORDRE SQL
        $sql = "SELECT * FROM questions_test WHERE id_question = ?";

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
    $qcm = filter_input(INPUT_GET, "qcm");
    //echo "<hr>$qcm<hr>";
    if ($qcm != null) {
        //echo "modif";
        $lsMessage .= "MODIF - ";
        $lcnx->beginTransaction();

        $question = filter_input(INPUT_GET, "question");
        $reponse1 = filter_input(INPUT_GET, "reponse1");
        $reponse2 = filter_input(INPUT_GET, "reponse2");
        $reponse3 = filter_input(INPUT_GET, "reponse3");
        $bonneReponse = filter_input(INPUT_GET, "bonneReponse");

        // ORDRE SQL
        $sql = "UPDATE questions_test SET question=?, reponse_1=?, reponse_2=?, reponse_3=?, bonne_reponse=? WHERE id_question = ?";

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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>update_question_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php
            include 'menu.php';
            ?>
            <h3>UPDATE Question</h3>

            <!--
            AFFICHAGE LISTE QCMS
            -->
            <section class='row'>
                <form class="form-horizontal" role="form" action="" method="GET">
                    <div class="form-group">
                        <label for="qcms" class="col-sm-2 control-label">QCMs</label>
                        <div class="col-sm-8">
                            <select class="form-control" size="3" id="qcms" name="qcms">
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
                            <select class="form-control" size="3" id="questions" name="questions">
                                <?php
                                echo $lsQuestions;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-8">
                            <button name="btnSelectQuestion" type="submit" class="btn btn-success">Valider Sélection question</button>
                        </div>
                    </div>
                </form>
            </section>


            <!--
            AFFICHAGE UNE QUESTION
            -->
            <section class='row'> 
                <form class="form-horizontal" role="form" action="" method="GET"> 

                    <div class="form-group"> 
                        <label for="qcm" class="col-sm-2 control-label">QCM</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="qcm" name="qcm" placeholder="QCM ?" value="<?php if (isSet($_SESSION["qcm"])) echo $_SESSION["qcm"]; else echo $qcm; ?>"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="question" class="col-sm-2 control-label">Question</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="question" name="question" placeholder="Question" value="<?php echo $question; ?>"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse1" class="col-sm-2 control-label">Réponse 1</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse1" name="reponse1" placeholder="Réponse 1 ?" value="<?php echo $reponse1; ?>"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse2" class="col-sm-2 control-label">Réponse 2</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse2" name="reponse2" placeholder="Réponse 2 ?" value="<?php echo $reponse2; ?>"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse3" class="col-sm-2 control-label">Réponse 3</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse3" name="reponse3" placeholder="Réponse 3 ?" value="<?php echo $reponse3; ?>"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="bonneReponse" class="col-sm-2 control-label">Bonne réponse</label> 
                        <div class="col-sm-8"> 
                            <select class="form-control" size="3" id="bonneReponse" name="bonneReponse">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <div class="col-md-offset-2 col-sm-8"> 
                            <button name="btnValiderUpdate" type="submit" class="btn btn-success">Valider modification</button> 
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

