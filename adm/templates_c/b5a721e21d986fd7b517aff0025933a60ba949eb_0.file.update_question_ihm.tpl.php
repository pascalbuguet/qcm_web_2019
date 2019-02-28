<?php
/* Smarty version 3.1.33, created on 2019-02-21 12:26:35
  from 'C:\xampp\htdocs\QCM_web_2019\adm\update_question_ihm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c6e8aeb6555a2_33407359',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b5a721e21d986fd7b517aff0025933a60ba949eb' => 
    array (
      0 => 'C:\\xampp\\htdocs\\QCM_web_2019\\adm\\update_question_ihm.tpl',
      1 => 1550748389,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu.tpl' => 1,
  ),
),false)) {
function content_5c6e8aeb6555a2_33407359 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>update_question_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php $_smarty_tpl->_subTemplateRender('file:menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
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
                                <?php echo $_smarty_tpl->tpl_vars['qcms']->value;?>

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
                                <?php echo $_smarty_tpl->tpl_vars['questions']->value;?>

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
                            <input type="text" class="form-control" id="qcm" name="qcm" placeholder="QCM ?" value="<?php echo $_smarty_tpl->tpl_vars['qcm']->value;?>
"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="question" class="col-sm-2 control-label">Question</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="question" name="question" placeholder="Question" value="<?php echo $_smarty_tpl->tpl_vars['question']->value;?>
"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse1" class="col-sm-2 control-label">Réponse 1</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse1" name="reponse1" placeholder="Réponse 1 ?" value="<?php echo $_smarty_tpl->tpl_vars['reponse1']->value;?>
"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse2" class="col-sm-2 control-label">Réponse 2</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse2" name="reponse2" placeholder="Réponse 2 ?" value="<?php echo $_smarty_tpl->tpl_vars['reponse2']->value;?>
"> 
                        </div> 
                    </div> 

                    <div class="form-group"> 
                        <label for="reponse3" class="col-sm-2 control-label">Réponse 3</label> 
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="reponse3" name="reponse3" placeholder="Réponse 3 ?" value="<?php echo $_smarty_tpl->tpl_vars['reponse3']->value;?>
"> 
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
                        <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

                    </label>
                </div>
            </div>

        </div>
    </body>
</html>

<?php }
}
