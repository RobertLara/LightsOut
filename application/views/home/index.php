<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-xs-12 col-sm-6">

                <div class="row text-center">
                    <button id="showGlobal" type="button" class="btn btn-success active">Records Globals</button>
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <button id="showUser" type="button" class="btn btn-success">Records Personals</button>
                    <?php endif; ?>
                </div>
                <br/>

                <div class="row" id="recordGlobal">

                    <?php

                    if (isset($getGames)) {

                        for ($i = 0; $i < $getGames; $i++) {
                            include('application/views/game/box_level_global.php');
                        }
                    }

                    ?>
                </div>

                <?php if ($this->session->userdata('logged_in')): ?>
                <div class="row" id="recordUser">

                    <?php

                    if (isset($getGames)) {

                        for ($i = 0; $i < $getGames; $i++) {
                            include('application/views/game/box_level_user.php');
                        }
                    }

                    ?>
                </div>
                <?php endif; ?>


            </div>
            <!-- /col-lg-6 -->
            <div class="col-lg-5 col-md-5 col-xs-12 col-sm-6">
                <img class="img-responsive" src="<?php echo base_url('assets/img/ipad-hand.png'); ?>" alt="">


            </div>
            <!-- /col-lg-6 -->

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div><!-- /headerwrap -->


<div class="container">
    <div class="row mt centered">
        <div class="col-lg-6 col-lg-offset-3">
            <h1>Benvingut al<br/> portal de jocs.</h1>
        </div>
    </div>
    <!-- /row -->

    <div class="row mt centered">
        <div class="col-lg-4">
            <img src="<?php echo base_url('assets/img/ser01.png'); ?>" width="180" alt="">
            <h4>1 - Compatibilitat amb tots els navegadors</h4>

        </div>
        <!--/col-lg-4 -->

        <div class="col-lg-4">
            <img src="<?php echo base_url('assets/img/ser02.png'); ?>" width="180" alt="">
            <h4>2 - Competició</h4>

        </div>
        <!--/col-lg-4 -->

        <div class="col-lg-4">
            <img src="<?php echo base_url('assets/img/ser03.png'); ?>" width="180" alt="">
            <h4>3 - Fàcil de jugar</h4>

        </div>
        <!--/col-lg-4 -->
    </div>
    <!-- /row -->
</div><!-- /container -->

	
