<!-- Block  -->
<div class="col-lg-3 col-md-4">
    <div class="panel panel-yellow" data-level="<?php echo $i+1;?>">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-12 text-right">
                    <div class="huge"><i class="fa fa-star"></i><?php echo $i + 1; ?><i class="fa fa-star"></i></div>
                    <div>
                        <?php
                        if ($getUserRankingTime[$i]->time == null) {
                            echo "No definit";
                        } else {
                            echo $getUserRankingTime[$i]->time;
                        }
                        ?>
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div>
                        <?php
                        if ($getUserRankingMoves[$i]->moves == 0){
                            echo "No definit";
                        }else{
                            echo $getUserRankingMoves[$i]->moves;
                        }

                        ?>
                        <i class="fa fa-hand-pointer-o"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>