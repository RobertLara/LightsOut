<!-- Block  -->
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
    <div class="panel panel-yellow" data-level="<?php echo $i+1;?>">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-12 text-right">
                    <!-- Nivell amb estrelles -->
                    <div class="huge"><i class="fa fa-star"></i><?php echo $i + 1; ?><i class="fa fa-star"></i></div>
                    <div>
                        <span>
                        <?php
                        if ($getUserRankingTime[$i]->time == null) {    //En cas de no estar definit cap record
                            echo "No definit";
                        } else {
                            echo $getUserRankingTime[$i]->time;
                        }
                        ?>
                        </span>
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div>
                        <span>
                        <?php
                        if ($getUserRankingMoves[$i]->moves == 0){    //En cas de no estar definit cap record
                            echo "No definit";
                        }else{
                            echo $getUserRankingMoves[$i]->moves;
                        }
                        ?>
                        </span>
                        <i class="fa fa-hand-pointer-o"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>