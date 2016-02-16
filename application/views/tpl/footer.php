</div>
<script src="<?php echo base_url('assets/js/jquery-1.12.0.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<?php

if(isset($js_to_load)){
    if($js_to_load!=''){

        foreach($js_to_load as $file){
            echo '<script type="text/javascript" src="';
            echo base_url("assets/js/".$file);
            echo '"></script>';
        }

    }

}

?>

    </body>

</html>
