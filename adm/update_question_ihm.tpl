<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>update_question_ihm</title>
    </head>

    <body>
        <div class='container'>

            {include file='menu.tpl'}
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
                                {$qcms}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-8">
                            <input name="btnSelectQCM" type="submit" class="btn btn-success" value="Valider Sélection QCM" />
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
                                {$questions}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-8">
                            <input name="btnSelectQuestion" type="submit" class="btn btn-success" value="Valider Sélection question" />
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
                            <input type="text" class="form-control" id="qcm" name="qcm" placeholder="QCM ?" value="{$qcm}"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="question" class="col-sm-2 control-label">Question</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="question" name="question" placeholder="Question" value="{$question}"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse1" class="col-sm-2 control-label">Réponse 1</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse1" name="reponse1" placeholder="Réponse 1 ?" value="{$reponse1}"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse2" class="col-sm-2 control-label">Réponse 2</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse2" name="reponse2" placeholder="Réponse 2 ?" value="{$reponse2}"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse3" class="col-sm-2 control-label">Réponse 3</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse3" name="reponse3" placeholder="Réponse 3 ?" value="{$reponse3}"> 
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
                            <input name="btnValiderUpdate" type="submit" class="btn btn-success" value="Valider modification" />
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
                        {$message}
                    </label>
                </div>
            </div>

        </div>
    </body>
</html>

