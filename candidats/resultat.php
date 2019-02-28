<?php
/*
 * resultat.php
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>Résultat</title>
    </head>

    <body>
        <div class='container'>
            <h1>Résultat</h1>

            <div class="form-group">
                <div class="col-md-offset-2 col-sm-7">
                    <label>
                        <?php
                        $avis = filter_input(INPUT_GET, "avis");
                        if ($avis != null) {
                            $note = filter_input(INPUT_GET, "note");
                            echo "Note : " . $note . "<br>Résultat : " . $avis;
                            try {
                                session_start();

                                require_once '../daos/Connexion.php';

                                $nom = $_SESSION["nom"];
                                $prenom = $_SESSION["prenom"];
                                $dateDeNaissance = $_SESSION["dateDeNaissance"];
                                $qcm = $_SESSION["qcm"];

                                /*
                                 * CONNEXION
                                 */
                                $lcnx = seConnecter("../conf/locale.ini");
                                $lcnx->beginTransaction();
                                /*
                                 * RECUPERATION ID CANDIDAT
                                 */
                                $sql = "SELECT id_candidat FROM candidats WHERE nom = ? AND prenom = ? AND date_de_naissance = ?";
                                $lrs = $lcnx->prepare($sql);
                                $lrs->bindParam(1, $nom);
                                $lrs->bindParam(2, $prenom);
                                $lrs->bindParam(3, $dateDeNaissance);
                                $lrs->execute();
                                $enr = $lrs->fetch();
                                $idCandidat = $enr[0];
                                $lrs->closeCursor();

                                /*
                                 * AJOUT NOTE ... DANS candidats_qcms
                                 */
                                $now = date("Y-m-d H:i:s");

                                $sql = "INSERT INTO candidats_qcms(id_candidat, qcm, date_qcm, note, avis) VALUES(?,?,?,?,?)";
                                $lcmd = $lcnx->prepare($sql);
                                $lcmd->bindParam(1, $idCandidat);
                                $lcmd->bindParam(2, $qcm);
                                $lcmd->bindParam(3, $now);
                                $lcmd->bindParam(4, $note);
                                $lcmd->bindParam(5, $avis);
                                $lcmd->execute();
                                $lcnx->commit();
                                /*
                                 * DECONNEXION
                                 */
                                $lcnx = null;
                            } catch (Exception $exc) {
                                //echo "<br>" . $exc->getMessage();
                                $lsMessage = "";
                                $lsMessage .= "<br>Une erreur est survenue, nous avons déjà un résultat vous concernant pour ce test !";
                                $lsMessage .= "<br>Veuillez contactez le centre.";
                                echo $lsMessage;
                            }
                        } else {
                            echo "<br>Résultat inconnu";
                        }
                        ?>
                    </label>
                </div>
            </div>

        </div>
    </body>
</html>
