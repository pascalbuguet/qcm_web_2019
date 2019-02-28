<?php
/*
 * identification.php
 */

session_start();

$nomInit = "";
$prenomInit = "";
$dateDeNaissanceInit = "";
$emailInit = "";

/*
 * INIT EN TEST
 */

//$nomInit = "Buguet";
//$prenomInit = "Pascal";
//$dateDeNaissanceInit = "03/10/1955";
//$emailInit = "pb@gmail.com";

/*
 * CONTROLE DES SAISIES
 */

/**
 * 
 * @param type $nom
 * @param type $prenom
 * @param type $dateDeNaissance
 * @param type $email
 * @param type $telephone
 * @return string
 */
function controlerSaisies($nom, $prenom, $dateDeNaissance, $email, $telephone) {
    $lsMessage = "";
    $lbKO = 0;

    if (strlen($nom) < 2) {
        $lsMessage .= "<br>Nom trop court, ";
        $lbKO++;
    }
    if (strlen($prenom) < 2) {
        $lsMessage .= "Prénom trop court, ";
        $lbKO++;
    }
    if (!preg_match("#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#", $dateDeNaissance)) {
        $lsMessage .= "Date de naissance incorrecte, ";
        $lbKO++;
    }
    if (!preg_match("/^[0-9a-z_-]+([.][0-9a-z_-]+)?@[0-9a-z._-]{2,}[.][a-z]{2,5}$/i", $email)) {
        $lsMessage .= "E-mail incorrect, ";
        $lbKO++;
    }

    if (!empty($telephone)) {
        if (!preg_match("/^[0-9]{10}$/", $telephone)) {
            $lsMessage .= "Téléphone incorrect, ";
            $lbKO++;
        }
    }

    if ($lbKO == 0) {
        $lsMessage = "OK";
    } else {
        $lsMessage = "&nbsp;&nbsp;&nbsp;" . substr($lsMessage, 0, -2);
    }

    return $lsMessage;
}

/*
 * REMPLISSAGE DE LA LISTE DES STAGES
 */

function getStages($lcnx) {
    $lsStages = "";

    $sql = "SELECT stage FROM stages ORDER BY stage";
    $lrs = $lcnx->query($sql);
    $lrs->setFetchMode(PDO::FETCH_NUM);

    // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
    foreach ($lrs as $record) {
        // Récupération des valeurs par concaténation et interpolation
//        if ($record[0] == "CDA") {
//            $lsStages .= "<option value='$record[0]' selected>$record[0]</option>";
//        } else {
//            $lsStages .= "<option value='$record[0]'>$record[0]</option>";
//        }
        $lsStages .= "<option value='$record[0]'>$record[0]</option>";
    }
    // Fermeture du curseur (facultatif)
    $lrs->closeCursor();

    return $lsStages;
}

/*
 * REMPLISSAGE DE LA LISTE DES QCMS
 */

function getQCMS($lcnx) {

    $lsQCMs = "";

    //$sql = "SELECT qcm FROM qcms ORDER BY qcm";
    $sql = "SELECT DISTINCT qcm FROM questions ORDER BY qcm";
    $lrs = $lcnx->query($sql);
    $lrs->setFetchMode(PDO::FETCH_NUM);

    // On boucle sur les lignes en récupérant le contenu des colonnes 1 et 2
    foreach ($lrs as $record) {
        $lsQCMs .= "<option value='$record[0]'>$record[0]</option>";
        // Récupération des valeurs par concaténation et interpolation
//        if ($record[0] == "php") {
//            $lsQCMs .= "<option value='$record[0]' selected>$record[0]</option>";
//        } else {
//            $lsQCMs .= "<option value='$record[0]'>$record[0]</option>";
//        }
    }
    // Fermeture du curseur (facultatif)
    $lrs->closeCursor();

    return $lsQCMs;
}

$lsMessage = "";
$lsStages = "";
$lsQCMs = "";

require_once '../daos/Connexion.php';

$lcnx = seConnecter("../conf/locale.ini");
try {
    /*
     * LISTE Stages
     */
    $lsStages = getStages($lcnx);

    /*
     * LISTE QCMS
     */
    $lsQCMs = getQCMS($lcnx);

    /*
     * 
     */

    $btnValider = filter_input(INPUT_GET, "btnValider");

    if ($btnValider != null) {
        $nom = filter_input(INPUT_GET, "nom");
        $prenom = filter_input(INPUT_GET, "prenom");
        $dateDeNaissanceFR = filter_input(INPUT_GET, "dateDeNaissance");
        $email = filter_input(INPUT_GET, "email");
        $telephone = filter_input(INPUT_GET, "telephone");
        $stage = filter_input(INPUT_GET, "stages");
        $qcm = filter_input(INPUT_GET, "qcms");

        if ($nom != null && $prenom != null && $dateDeNaissanceFR != null && $stage != null && $qcm != null && $email != null) {
            $lsOK = controlerSaisies($nom, $prenom, $dateDeNaissanceFR, $email, $telephone);
            if ($lsOK == "OK") {
                /*
                 * CONTROLE DEJA EXISTANT ?
                 */
                $tDate = explode("/", $dateDeNaissanceFR);
                $dateDeNaissanceUS = $tDate[2] . "-" . $tDate[1] . "-" . $tDate[0];

                $sql = "SELECT * FROM candidats WHERE nom = ? AND prenom = ? and date_de_naissance = ?";
                $lrs = $lcnx->prepare($sql);
                $lrs->bindParam(1, $nom);
                $lrs->bindParam(2, $prenom);
                $lrs->bindParam(3, $dateDeNaissanceUS);
                $lrs->execute();
                $lrs->setFetchMode(PDO::FETCH_ASSOC);
                $enr = $lrs->fetch();
                // CANDIDAT INEXISTANT
                if ($enr == false) {
                    /*
                     * NOUVEAU CANDIDAT
                     */
                    $lcnx->beginTransaction();
                    $sql = "INSERT INTO candidats(nom,prenom,date_de_naissance,stage,email,telephone) VALUES(?,?,?,?,?,?)";
                    $lcmd = $lcnx->prepare($sql);

                    $lcmd->bindParam(1, $nom, PDO::PARAM_STR);
                    $lcmd->bindParam(2, $prenom, PDO::PARAM_STR);
                    $lcmd->bindParam(3, $dateDeNaissanceUS, PDO::PARAM_STR);
                    $lcmd->bindParam(4, $stage, PDO::PARAM_STR);
                    $lcmd->bindParam(5, $email, PDO::PARAM_STR);
                    $lcmd->bindParam(6, $telephone, PDO::PARAM_STR);
                    $lcmd->execute();
                    /*
                     * CANDIDAT-QCM
                     */
                    /*
                     * GET NEW ID CANDIDAT
                     */
                    $sql = "SELECT LAST_INSERT_ID()";
                    $lrs = $lcnx->query($sql);
                    $lrs->setFetchMode(PDO::FETCH_NUM);
                    $enr = $lrs->fetch();
                    $idCandidat = $enr[0];

                    $sql = "INSERT INTO candidats_qcms(id_candidat, qcm, date_qcm) VALUES(?,?,?)";
                    $lcmd = $lcnx->prepare($sql);
                    $lcmd->bindParam(1, $idCandidat);
                    $lcmd->bindParam(2, $qcm);
                    $dateQcm = date("Y-m-d H:i:s");
                    $lcmd->bindParam(3, $dateQcm);
                    $lcmd->execute();
                    /*
                     * COMMIT
                     */
                    $lcnx->commit();
                    $lsMessage = "Candidat inséré";
                } else {
                    // Message
                    $lsMessage = "Candidat déjà existant";
                    $idCandidat = $enr["id_candidat"];
                    $nom = $enr["nom"];
                    $prenom = $enr["prenom"];
                    $dateDeNaissanceUS = $enr["date_de_naissance"];
                    $tDate = explode("-", $dateDeNaissanceUS);
                    $dateDeNaissanceFR = $tDate[2] . "/" . $tDate[1] . "/" . $tDate[0];
                    $email = $enr["email"];
                    $telephone = $enr["telephone"];
                    
                     $sql = "INSERT INTO candidats_qcms(id_candidat, qcm, date_qcm) VALUES(?,?,?)";
                    $lcmd = $lcnx->prepare($sql);
                    $lcmd->bindParam(1, $idCandidat);
                    $lcmd->bindParam(2, $qcm);
                    $dateQcm = date("Y-m-d");
                    $lcmd->bindParam(3, $dateQcm);
                    $lcmd->execute();
                }
                //echo "<br>$lsMessage";
                /*
                 * SESSION
                 */
                $_SESSION["idCandidat"] = $idCandidat;
                $_SESSION["nom"] = $nom;
                $_SESSION["prenom"] = $prenom;
                $_SESSION["dateDeNaissanceFR"] = $dateDeNaissanceFR;
                $_SESSION["email"] = $email;
                $_SESSION["telephone"] = $telephone;
                $_SESSION["stage"] = $stage;
                $_SESSION["qcm"] = $qcm;

                header("location: questionnaire.php");
            } else {
                // SAISIES INCORRECTES
                $lsMessage = $lsOK;
            }
        } else {
            $lsMessage .= "Saisies insuffisantes";
            $lsMessage .= "<br>Toutes les saisies sont obligatoires sauf le téléphone !!!";
        }
    } else {
        $lsMessage .= "Toutes les saisies sont obligatoires sauf le téléphone !!!";
        $lsMessage .= "<br>Le nom avec au moins 2 lettres";
        $lsMessage .= "<br>Le prénom avec au moins 2 lettres";
        $lsMessage .= "<br>Sélectionnez un stage";
        $lsMessage .= "<br>Sélectionnez un questionnaire";
        $lsMessage .= "<br>Première requête et NOM absent";
    }
} catch (Exception $exc) {
    //$lcnx->rollBack();
    $lsMessage = $exc->getMessage();
}
$lcnx = null;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <style>
            .label-default{background: white;}
        </style>
        <title>Identification</title>
    </head>

    <body>
        <div class='container'>
            <h1>Identification</h1>

            <section class='row'>
                <form class="form-horizontal" role="form" action="" method="GET">

                    <div class="form-group">
                        <label for="nom" class="col-md-3">Nom</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom ?" value="<?php
                            if (isSet($nom))
                                echo $nom;
                            else
                                echo $nomInit;
                            ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prenom" class="col-sm-3">Prénom</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom ?" value="<?php
                            if (isSet($prenom))
                                echo $prenom;
                            else
                                echo $prenomInit;
                            ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dateDeNaissance" class="col-sm-3">Date de naissance (JJ/MM/AAAA)</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="dateDeNaissance" name="dateDeNaissance" placeholder="Date de naissance ?" value="<?php
                            if (isSet($dateDeNaissanceFR))
                                echo $dateDeNaissanceFR;
                            else
                                echo $dateDeNaissanceInit;
                            ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-3">E-mail</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="email" name="email" placeholder="E-mail ?" value="<?php
                            if (isSet($email))
                                echo $email;
                            else
                                echo $emailInit;
                            ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telephone" class="col-sm-3">Téléphone (10 chiffres consécutifs)</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Téléphone (facultatif) ?" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stages" class="col-sm-3">Stage</label>
                        <div class="col-sm-7">
                            <select class="form-control" size="3" id="stages" name="stages">
                                <?php
                                echo $lsStages;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="qcms" class="col-sm-3">Questionnaire</label>
                        <div class="col-sm-7">
                            <select class="form-control" size="3" id="qcms" name="qcms">
                                <?php
                                echo $lsQCMs;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-7">
                            <button type="submit" name="btnValider" value="OK" class="btn btn-success">Valider&nbsp;&nbsp;&nbsp;</button>
                            <p>
                                <?php
                                echo $lsMessage;
                                ?>
                            </p>
                        </div>

                </form>

            </section>

            <div class="form-group">

            </div>

        </div>
    </body>
</html>
