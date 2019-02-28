<?php
/* Smarty version 3.1.33, created on 2019-02-21 06:43:17
  from 'C:\xampp\htdocs\QCM_web_2019\adm\txt_2_bd_ihm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c6e3a751da447_53856261',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ceca9ac0c303053ec9d798dfe8da2bd60a308e44' => 
    array (
      0 => 'C:\\xampp\\htdocs\\QCM_web_2019\\adm\\txt_2_bd_ihm.tpl',
      1 => 1550727793,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu.tpl' => 1,
  ),
),false)) {
function content_5c6e3a751da447_53856261 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet"> 
        <title>txt_2_bd_ihm</title>
    </head>

    <body>
        <div class='container'>

            <?php $_smarty_tpl->_subTemplateRender('file:menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <h3>Transfert txt 2 bd</h3>

            <section class='row'> 

                <form action="txt_2_bd_ctrl.php" method="GET" class="form-horizontal" role="form" >

                    <div class="form-group"> 
                        <label for="domaine" class="col-sm-2 control-label">Domaines ?</label> 
                        <div class="col-sm-8"> 
                            <select class="form-control" id="domaine" name="domaine">
                                
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tableauTXT']->value, 'item');
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
