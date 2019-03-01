<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>delete_qcm_ihm</title>
    </head>

    <body>
        <div class='container'>

            {include file='../boundaries/menu.tpl'}

            <h1>DELETE QCM</h1>

            <!--
            AFFICHAGE LISTE QCMS
            -->
            <section class='row'>
                <form class="form-horizontal" role="form" action="" method="GET">
                    <div class="form-group">
                        <label for="qcms" class="col-sm-2 control-label">QCMs</label>
                        <div class="col-sm-8">
                            <select class="form-control" size="5" id="qcms" name="qcms">
                                {foreach $qcms as $item}
                                    <option>{$item}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-8">
                            <input name="btnDeleteQCM" type="submit" class="btn btn-success" value="Valider Suppression QCM" />
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

