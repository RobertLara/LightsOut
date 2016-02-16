<style>
    body {
        background-color: #3498db;
    }
</style>


<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-2 col-md-6 col-xs-12 col-sm-10 col-sm-offset-2">

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
            <div class="col-lg-4 col-md-offset-1 col-md-6 col-xs-12 col-sm-10   ">


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
                    <button type="submit" name="log-me-in" id="submit" tabindex="5" class="btn btn-lg btn-primary">
                        Afegir nou usuari
                    </button>
                </div>
                <?php echo form_close(); ?>




            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div><!-- /headerwrap -->

	
