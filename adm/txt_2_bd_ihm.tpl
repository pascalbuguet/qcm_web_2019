<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../libs/bootstrap/css/bootstrap.css" rel="stylesheet"> 
        <title>txt_2_bd_ihm</title>
    </head>

    <body>
        <div class='container'>

            {include file='menu.tpl'}

            <h3>Transfert txt 2 bd</h3>

            <section class='row'> 

                <form action="txt_2_bd_ctrl.php" method="GET" class="form-horizontal" role="form" >

                    <div class="form-group"> 
                        <label for="domaine" class="col-sm-2 control-label">Domaines ?</label> 
                        <div class="col-sm-8"> 
                            <select class="form-control" id="domaine" name="domaine">
                                {*
                                <option value="">Sélectionnez</option>
                                <option>c</option>
                                <option>python</option>
                                <option>sql</option>
                                <option>php</option>
                                <option>java</option>
                                <option>javascript</option>

                                <option>big_data_generalites</option>
                                <option>big_data_sql</option>
                                <option>big_data_mongodb</option>
                                <option>big_data_neo4j</option>
                                <option>big_data_cassandra</option>
                                <option>big_data_redis</option>
                                *}

                                {foreach $tableauTXT as $item}
                                    <option>{$item}</option>
                                {/foreach}

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
                        {$message}
                    </label> 
                </div> 
            </div> 
        </div>
    </body>
</html>
