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

require_once '../daos/Connexion.php';

session_start();

$lsMessage = "";
$lsQcms="";

$lcnx = seConnecter("../conf/locale.ini");

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
            $sql = "INSERT INTO questions_test(qcm, rang, question, reponse_1, reponse_2, reponse_3, blanc, bonne_reponse) VALUES(?,?,?,?,?,?,?,?)";

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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet"> 
        <title>new_question_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php
            include 'menu.php';
            ?>
            <h1>New Question</h1>

            <section class='row'> 
                <form class="form-horizontal" role="form" action="" method="GET"> 

                    <div class="form-group"> 
                        <label for="qcm" class="col-sm-2 control-label">QCM</label> 
                        <div class="col-sm-8"> 
                            <select class="form-control" size="3" id="qcm" name="qcm">
                                <?php
                                echo $lsQcms;
                                ?>
                            </select>
<!--                            <input type="text" class="form-control" id="qcm" name="qcm" placeholder="QCM ?" value="<?php echo $qcm; ?>"> -->
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="question" class="col-sm-2 control-label">Question</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="question" name="question" placeholder="Question" value=""> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse1" class="col-sm-2 control-label">Réponse 1</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse1" name="reponse1" placeholder="Réponse 1 ?" value=""> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse2" class="col-sm-2 control-label">Réponse 2</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse2" name="reponse2" placeholder="Réponse 2 ?" value=""> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse3" class="col-sm-2 control-label">Réponse 3</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse3" name="reponse3" placeholder="Réponse 3 ?" value=""> 
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
                            <button type="submit" class="btn btn-success">Valider</button> 
                        </div> 
                    </div> 

                </form>

            </section>

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

