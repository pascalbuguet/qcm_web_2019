<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../libs/bootstrap/css/bootstrap.css" rel="stylesheet"> 
        <title>bd_2_txt_ihm</title>
    </head>

    <body>
        <div class='container'>

            {include file='../boundaries/menu.tpl'}

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
                        {$message}
                    </label> 
                </div> 
            </div> 
        </div>
    </body>
</html>
