/* 
 * questionnaire.js
 */

var tempsRestant = 0;
var nbQuestions = 0;
var i = 0;
var tQuestions;
var nbBonnesReponses = 0;
/**
 * 
 * @return {undefined}
 */
function init() {
//    console.log("init");
    i = 1;
    $("#btnSuivante").click(function () {
        var reponse = 0;
        if ($("#rbReponse1").prop('checked') == true) {
            reponse = 1;
        }
        if ($("#rbReponse2").prop('checked') == true) {
            reponse = 2;
        }
        if (tQuestions[i - 1].reponse_3 != "" && $("#rbReponse3").prop('checked') == true) {
            reponse = 3;
        }
        var bonneReponse = tQuestions[i - 1].bonne_reponse;
        console.log("Réponse : " + reponse);
        console.log("Bonne réponse : " + tQuestions[i - 1].bonne_reponse);
        if (reponse == bonneReponse) {
            nbBonnesReponses++;
        }
        $("#note").val(nbBonnesReponses);
        i++;
        afficherQuestion();
        afficherCompteur();
    });
    setInterval(afficherTempsRestant, 1000 * 60);
    /*
     * Le nombre de questions
     */
    var jqXHRCount = $.get("../daos/GetNbQuestionsByQCM.php",
            {qcm: $("#qcm").html()}
    );
    jqXHRCount.done(function (data) {
//        console.log(data);
        nbQuestions = data;
        afficherCompteur();
        tempsRestant = (data / 2) + 1;
        //$("#tempsRestant").html("Il vous reste " + tempsRestant + " minute(s)");
        afficherTempsRestant();
    });
    /*
     * Les questions
     */
    let jqXHRQuestions = $.get("../daos/GetQuestionsByQCM.php",
            {qcm: $("#qcm").html()}
    );
    jqXHRQuestions.done(function (data) {
        console.log(data);
//        console.log(data.length);
        tQuestions = data;
        afficherQuestion();
    });
}

/**
 * 
 * @return {undefined}
 */
function afficherTempsRestant() {
    tempsRestant--;
    $("#tempsRestant").html("Il vous reste " + tempsRestant + " minute(s)");
    if (tempsRestant === 0) {
        window.location("resultat.php?resultat=OK");
    }
}

/**
 * 
 * @return {undefined}
 */
function afficherCompteur() {
    $("#compteur").html("Question " + i + " sur " + nbQuestions);
}

/**
 * 
 * @return {undefined}
 */
function afficherQuestion() {
//    console.log("i : " + i);
//    console.log("nbQuestions : " + nbQuestions);

    $("#rbReponse1").prop('checked', false);
    $("#rbReponse2").prop('checked', false);
    $("#rbReponse3").prop('checked', false);
    if (i > nbQuestions) {
        var avis = "KO";
        var note = (nbBonnesReponses / nbQuestions) * 100;
        note = Number.parseFloat(note).toFixed(0);
        if (note > 50) {
            avis = "OK";
        }
        $("#note").prop("type", "text");
        $("#note").prop("disabled", "disabled");
        $("#note").val("Votre note : " + note + " %, Avis : " + avis);
        /*
         * REQUETE AJAX POUR METTRE A JOUR LE RESULTAT DANS LA TABLE candidats_qcms
         */

        var jqXHRUpdate = $.get("../daos/CandidatsQcmsUpdate.php",
                {
                    note: note + " %",
                    avis : avis,
                    id_candidat : $("#idCandidat").val(),
                    qcm : $("#qcmChoisi").val()
                }
        );
        jqXHRUpdate.done(function (data) {
            console.log(data);
            var reponse = data;
            alert(reponse);
        });
        //window.location("resultat.php?avis=" + avis + "&note=" + note);
    } else {
        //nbBonnesReponses++;
        $("#question").html(tQuestions[i - 1].question);
        $("#lblReponse1").html(tQuestions[i - 1].reponse_1);
        $("#lblReponse2").html(tQuestions[i - 1].reponse_2);
        if (tQuestions[i - 1].reponse_3 == "") {
            $("#lblRbReponse3").hide();
            $("#lblReponse3").hide();
        } else {
            $("#lblRbReponse3").show();
            $("#lblReponse3").show();
            $("#lblReponse3").html(tQuestions[i - 1].reponse_3);
        }
    }
}


/*
 * MAIN
 */
$(document).ready(init);
