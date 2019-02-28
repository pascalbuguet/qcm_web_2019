<?php
/* Smarty version 3.1.33, created on 2019-02-21 12:05:45
  from 'C:\xampp\htdocs\QCM_web_2019\adm\delete_question_ihm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c6e8609b92889_28917162',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '268c04d2a52953768517fb77072b4c89d5632506' => 
    array (
      0 => 'C:\\xampp\\htdocs\\QCM_web_2019\\adm\\delete_question_ihm.tpl',
      1 => 1550747131,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu.tpl' => 1,
  ),
),false)) {
function content_5c6e8609b92889_28917162 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>delete_question_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php $_smarty_tpl->_subTemplateRender('file:menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
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
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['qcms']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                    <option><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
                            <select class="form-control" size="5" id="questions" name="questions">
                                <?php if ($_smarty_tpl->tpl_vars['questions']->value != '') {?>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['questions']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value;?>

                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-8">
                            <input name="btnDeleteQuestion" type="submit" class="btn btn-success" value="Valider DELETE question" />
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
