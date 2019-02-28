<?php
/* Smarty version 3.1.33, created on 2019-02-21 11:03:15
  from 'C:\xampp\htdocs\QCM_web_2019\adm\bd_2_txt_ihm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c6e776380c110_12344751',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db6c12fabb890d4ad84f0a6f477c5f248cc89300' => 
    array (
      0 => 'C:\\xampp\\htdocs\\QCM_web_2019\\adm\\bd_2_txt_ihm.tpl',
      1 => 1550741297,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu.tpl' => 1,
  ),
),false)) {
function content_5c6e776380c110_12344751 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet"> 
        <title>bd_2_txt_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php $_smarty_tpl->_subTemplateRender('file:menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <h3>BD 2 TXT</h3>

            <section class='row'> 

                <h3>EN TRAVAUX</h3>

                <form action="" method="GET" class="form-horizontal" role="form" >
                    <div class="form-group"> 
                        <div class="col-sm-offset-2  col-sm-8"> 
                            <button type="submit" class="btn btn-success">Valider</button> 
                        </div> 
                    </div> 
                </form>
            </section>

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
