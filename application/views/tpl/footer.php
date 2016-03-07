</div>
<script src="<?php echo base_url('assets/js/jquery-1.12.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<?php
//Carrega de fitxer JS sí són indicats
if (isset($js_to_load)) {
    if (is_array($js_to_load)) {

        foreach ($js_to_load as $file) {
            echo '<script type="text/javascript" src="';
            if (substr($file, 0, 2) == '//') {      //En cas de recurss extern
                echo $file;
            } else {
                echo base_url("assets/js/" . $file);
            }
            echo '"></script>';
        }

    } else {
        echo '<script type="text/javascript" src="';

        if (substr($js_to_load, 0, 2) == '//') {    //En cas de recurss extern
            echo $js_to_load;
        } else {
            echo base_url("assets/js/" . $js_to_load);
        }

        echo '"></script>';
    }

}
    //En cas de mostrar missatge mostra modal amb el contingut del missatge
if (isset($msg)) {
    echo '<script>jQuery(function() {jQuery("#msgModal").modal("show");jQuery("#msgModal .modal-body").html("<p>' . $msg . '</p>")});</script>';
}

?>

</body>

</html>
