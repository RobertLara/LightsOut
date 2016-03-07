<!DOCTYPE html>
<html lang="ca">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php
            if(isset($title))
                echo $title;
            else
                echo "LightsOut";
            ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/main.css');?>" rel="stylesheet" />

        <?php

        //Fitxer CSS a importar sí estan indicats
        if(isset($css_to_load)){
            var_dump($css_to_load);
            if(is_array($css_to_load)){

                foreach($css_to_load as $file){
                    echo '<link rel="stylesheet" href="';
                    if(substr($file,0,2)=='//'){    //En cas de recurs extern
                        echo $file;
                    }else{
                        echo base_url("assets/css/".$file);
                    }
                    echo '">';
                }
            }else{
                echo '<link rel="stylesheet" href="';
                if(substr($file,0,2)=='//'){    //En cas de recurs extern
                    echo $file;
                }else{
                    echo base_url("assets/css/".$$css_to_load);
                }
                echo '">';
            }

        }


        ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
    <div id="msgModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Informació</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tancar</button>
                </div>
            </div>
        </div>
    </div>


        <div class="">
