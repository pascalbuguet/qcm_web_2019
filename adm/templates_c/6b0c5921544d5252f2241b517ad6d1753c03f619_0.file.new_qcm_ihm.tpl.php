<?php
/* Smarty version 3.1.33, created on 2019-02-21 11:19:01
  from 'C:\xampp\htdocs\QCM_web_2019\adm\new_qcm_ihm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c6e7b159bb922_47629669',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6b0c5921544d5252f2241b517ad6d1753c03f619' => 
    array (
      0 => 'C:\\xampp\\htdocs\\QCM_web_2019\\adm\\new_qcm_ihm.tpl',
      1 => 1550743693,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu.tpl' => 1,
  ),
),false)) {
function content_5c6e7b159bb922_47629669 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>new_qcm_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php $_smarty_tpl->_subTemplateRender('file:menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
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
                        <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

                    </label>
                </div>
            </div>

            <div class="form-group ">
                <label for="qcm" class="col-sm-12">Pour mémoire</label>
                <div class="col-sm-12">
                    <select class="form-control" size="5">
                       <?php echo $_smarty_tpl->tpl_vars['qcms']->value;?>

                    </select>
                </div>
            </div>

        </div>
    </body>
</html>

<?php }
}
