<!-- Block  -->
<div class="col-lg-3 col-md-4 col-xs-6">
    <div class="panel panel-yellow" data-level="<?php echo $i+1;?>">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-12 text-right">
                    <div class="huge"><i class="fa fa-star"></i><?php echo $i + 1; ?><i class="fa fa-star"></i></div>
                    <div>
                        <?php
                        if($getRankingTime[$i]->username !== null){
                        echo "<span class='username'>".$getRankingTime[$i]->username."</span>";
                        }
                        ?>
                        <span>
                        <?php
                        if ($getRankingTime[$i]->time == null) {
                            echo "No definit";
                        } else {
                            echo $getRankingTime[$i]->time;
                        }
                        ?>
                        </span>
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div>
                        <?php
                        if($getRankingMoves[$i]->username !== null){
                            echo "<span class='username'>".$getRankingMoves[$i]->username."</span>";
                        }
                        ?>
                        <span>
                        <?php
                        if ($getRankingMoves[$i]->moves == 0){
                            echo "No definit";
                        }else{
                            echo $getRankingMoves[$i]->moves;
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