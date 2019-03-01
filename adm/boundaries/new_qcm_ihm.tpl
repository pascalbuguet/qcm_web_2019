<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../libs/bootstrap/css/bootstrap.css" rel="stylesheet">
        <title>new_qcm_ihm</title>
    </head>

    <body>
        <div class='container'>

            {include file='../boundaries/menu.tpl'}
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
                        {$message}
                    </label>
                </div>
            </div>

            <div class="form-group ">
                <label for="qcm" class="col-sm-12">Pour mémoire</label>
                <div class="col-sm-12">
                    <select class="form-control" size="5">
                       {$qcms}
                    </select>
                </div>
            </div>

        </div>
    </body>
</html>

