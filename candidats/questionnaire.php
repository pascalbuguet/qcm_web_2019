<?php
/*
 * questionnaire.php
 */
session_start();

require_once '../daos/Connexion.php';

$lsMessage = "";
$lsQuestion = "";
$lsReponse1 = "";
$lsReponse2 = "";
$lsReponse3 = "";

$nom = $_SESSION["nom"];
$prenom = $_SESSION["prenom"];
$dateDeNaissance = $_SESSION["dateDeNaissance"];
$qcm = $_SESSION["qcm"];

$lcnx = seConnecter("../conf/locale.ini");

try {
    /*
     * NOMBRE DE QUESTIONS
     */
    $sql = "SELECT COUNT(*) FROM questions WHERE qcm = ?";
    $lrs = $lcnx->prepare($sql);
    $lrs->bindParam(1, $qcm);
    $lrs->execute();
    $enr = $lrs->fetch();
    $nbQuestions = $enr[0];

    $lrs->closeCursor();
    /*
     * QUESTIONS
     */
    $sql = "SELECT * FROM questions WHERE qcm = ?";
    $lrs = $lcnx->prepare($sql);
    $lrs->bindParam(1, $qcm);
    $lrs->execute();
    $enr = $lrs->fetch();

    $lsQuestion = $enr["question"];
    $lsReponse1 = $enr["reponse_1"];
    $lsReponse2 = $enr["reponse_2"];
    $lsReponse3 = $enr["reponse_3"];

    $lrs->closeCursor();
    //$lrs->setFetchMode(PDO::FETCH_NUM);
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
        <title>Questionnaire</title>
        <script src="../libs/jquery/jquery.js"></script>
        <script src="../js/questionnaire.js"></script>
    </head>

    <body>
        <div class='container'>

            <h3>Questionnaire</h3>

<!--            <section class='row'>
                <form class="form-horizontal" role="form" action="" method="GET">

                    <div class="form-group">
                        <label for="qcm" class="col-md-1">QCM</label>
                        <label id="qcm" class="col-md-11"><?php echo $qcm; ?></label>
                    </div>

                    <div class="form-group">
                        <label for="question" class="col-md-1">Question</label>
                        <p id="question" class="col-md-11"><?php echo $lsQuestion; ?></p>
                    </div>

                    <div class="form-group">
                        <label for="reponse1" class="col-md-1">1)</label>
                        <p id="reponse1" class="col-md-11"><?php echo $lsReponse1; ?></p>
                    </div>

                    <div class="form-group">
                        <label for="reponse2" class="col-md-1">2)</label>
                        <p id="reponse2" class="col-md-11"><?php echo $lsReponse2; ?></p>
                    </div>

                    <div class="form-group">
                        <label for="reponse3" class="col-md-1">3)</label>
                        <p id="reponse3" class="col-md-11"><?php echo $lsReponse3; ?></p>
                    </div>


                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" id="rbReponse1" value="1" checked> Réponse 1
                        </label>
                        <label class="radio-inline">
                            <input type="radio" id="rbReponse2" value="2"> Réponse 2
                        </label>
                        <label class="radio-inline">
                            <input type="radio" id="rbReponse3" value="3"> Réponse 3
                        </label>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <button id="btnValider" type="button" class="btn btn-success">Valider</button>
                        </div>
                    </div>
                </form>
            </section>-->

            <section class='row'>
                <form class="form-horizontal" role="form" action="" method="GET">

                    <div class="form-group">
                        <label class="col-md-1">QCM</label>
                        <label id="qcm" class="col-md-11"><?php echo $qcm; ?></label>
                    </div>

                    <div class="form-group">
                        <label class="col-md-1">Question</label>
                        <label id="question" class="col-md-11"></label>
                    </div>

<!--                    <div class="form-group">
                        <label for="reponse1" class="col-md-1">1)</label>
                        <label id="reponse1" class="col-md-11"></label>
                    </div>-->

<!--                    <div class="form-group">
                        <label for="reponse2" class="col-md-1">2)</label>
                        <label id="reponse2" class="col-md-11"></label>
                    </div>-->

<!--                    <div class="form-group">
                        <label id="lblReponse3" for="reponse3" class="col-md-1">3)</label>
                        <label id="reponse3" class="col-md-10"></label>
                    </div>-->

                    <div class="form-group">
                        <label for="rbReponse1" class="radio-inline">
                            <input type="radio" name="rbReponse" id="rbReponse1" value="1"> 
                            <label for="rbReponse1" id="lblReponse1">Réponse 1</label>
                        </label>
                        <label for="rbReponse2" class="radio-inline">
                            <input type="radio" name="rbReponse" id="rbReponse2" value="2">
                            <label for="rbReponse2" id="lblReponse2">Réponse 2</label>
                        </label>
                        <label for="rbReponse3" id="lblRbReponse3" class="radio-inline">
                            <input type="radio" name="rbReponse" id="rbReponse3" value="3">
                            <label for="rbReponse3" id="lblReponse3">Réponse 3</label>
                        </label>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <button id="btnSuivante" type="button" class="btn btn-success">Suivante</button>
                        </div>
                    </div>
                </form>
            </section>

            <section class='row'>
                <div class="form-group">
                    <label id="compteur" class="col-md-2">Question 1/10</label>
                    <label id="tempsRestant" class="col-md-8">Il vous reste 15 minutes</label>
                </div>
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

            <input type="hidden" name="qcmChoisi" id="qcmChoisi" value="<?php echo $_SESSION["qcm"]; ?>" />
            <input type="hidden" name="idCandidat" id="idCandidat" value="<?php echo $_SESSION["idCandidat"]; ?>" />
            <p class="col-sm-8">
                <input type="hidden" id="note" />
            </p>
        </div>
    </body>
</html>

