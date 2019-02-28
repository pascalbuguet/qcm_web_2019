<?php
/*
 * new_qcm.php
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

session_start();

require_once '../daos/Connexion.php';

$lsMessage = "";
$lsQcmsExistants = "";

$lcnx = seConnecter("../conf/locale.ini");

$qcm = filter_input(INPUT_GET, "qcm");
if ($qcm != null) {
    $lsMessage = "Jusque là tout va bien !!!";

    try {
        $lcnx->beginTransaction();
        $sql = "INSERT INTO qcms(qcm) VALUES(?)";
        $lcmd = $lcnx->prepare($sql);
        $lcmd->bindParam(1, $qcm, PDO::PARAM_STR);
        $lcmd->execute();
        $lcnx->commit();
        $_SESSION["qcm"] = $qcm;
    } catch (Exception $exc) {
        $lcnx->rollBack();
        $lsMessage = $exc->getMessage();
    }
} else {
    $lsMessage = "Toutes les saisies sont obligatoires !!!";
}

try {
    $sql = "SELECT qcm FROM qcms ORDER BY qcm";
    $lrs = $lcnx->query($sql);
    $lrs->setFetchMode(PDO::FETCH_NUM);

    // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
    foreach ($lrs as $lrec) {
        // Récupération des valeurs par concaténation et interpolation
        $lsQcmsExistants .= "<option>$lrec[0]</option>";
    }
    // Fermeture du curseur (facultatif)
    $lrs->closeCursor();
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
        <title>new_qcm_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php
            include 'menu.php';
            ?>
            <h1>New QCM</h1>

            <section class='row'>
                <form class="form-horizontal" role="form" action="" method="GET">

                    <div class="form-group">
                        <label for="qcm" class="col-sm-2 control-label">QCM</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="qcm" name="qcm" placeholder="QCM ?" value="">
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
                <div class="col-md-offset-2 col-md-10">
                    <label>
                        <?php
                        echo $lsMessage;
                        ?>
                    </label>
                </div>
            </div>

            <div class="form-group ">
                <label for="qcm" class="col-sm-12">Pour mémoire</label>
                <div class="col-sm-12">
                    <select class="form-control" size="5">
                        <?php
                        echo $lsQcmsExistants;
                        ?>
                    </select>
                </div>
            </div>

        </div>
    </body>
</html>

