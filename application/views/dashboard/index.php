<style>
    body {
        background-color: #3498db;
    }
</style>


<div id="makeBoard" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Creació d'un nou nivell</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tancar</button>
            </div>
        </div>

    </div>
</div>
<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-2 col-md-6 col-xs-12 col-sm-9 col-sm-offset-1 col-md-offset-3 col-xs-offset-0 col-l-offset-2">

                <table class="table table-striped custab">
                    <thead>
                    <tr>
                        <th>Nom d'usuari</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php


                    foreach($users as $user){
                        include('application/views/dashboard/row.php');
                    }

                    ?>
                    </tbody>
                </table>


            </div>
            <div class="col-lg-4 col-md-offset-4 col-md-4 col-xs-9 col-sm-9 col-sm-offset-3 col-xs-offset-3">


                <?php echo validation_errors('<p class="error">'); ?>
                <?php echo form_open("main/registration"); ?>
                <div class="form-group ">
                    <label for="password" class="sr-only">Nom d'usuari</label>
                    <input type="text" class="form-control" name="username" id="username"
                           autofocus="true" placeholder="Nom d'usuari" value="" tabindex="2" required="true"/>
                </div>

                <div class="form-group ">
                    <label for="password" class="sr-only">Contrasenya</label>
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="Contrasenya" value="" tabindex="2" required="true"/>
                </div>
                <br/>

                <div class="form-group ">
                    <button type="submit" name="log-me-in" id="submit" tabindex="5" class="btn btn-lg btn-success">
                        Afegir nou usuari
                    </button>
                </div>
                <?php echo form_close(); ?>

            </div>


        </div>
        <div class="row col-md-offset-4 col-lg-offset-4 col-sm-offset-4 col-xs-offset-4 col-xs-6 col-sm-8 col-md-8">
            <button id="openMakeBoard" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#makeBoard">Crear nou nivell</button>
        </div>
    </div>
    <!-- /container -->
</div><!-- /headerwrap -->

	
