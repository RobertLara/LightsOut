<style>
    body {
        background-color: #3498db;
    }
</style>

<div id="headerwrap">
    <div class="container">
        <div class="row">
            <h2 class="text-center color-white">Nivells disponibles per jugar</h2>
            <h4 class="text-center color-white">Amb els teus millors resultats</h4>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-2 col-xs-offset-0 col-xs-12 col-sm-10 col-sm-offset-1">
                <?php
                //Mostra tots els nivell disponibles per jugar.
                if(isset($getGames)){

                    for($i=0;$i<$getGames;$i++){
                        include('application/views/game/box_level_user.php');
                    }

                }

                ;?>
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div><!-- /headerwrap -->

	
