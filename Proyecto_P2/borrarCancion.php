<?php 
    require "./includes/config.php";

    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    if(!empty($id)){
        if(es\ucm\fdi\aw\Admin::borrarCancion($id)) echo "bien";
    }

    header("Location: gestionCanciones.php");
