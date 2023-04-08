<?php 
    require "./includes/config.php";

    $email = (isset($_GET['email'])) ? $_GET['email'] : null;
    if(!empty($email)){
        es\ucm\fdi\aw\Admin::borrarUsuarios($email);
    }

    header("Location: gestionUsuarios.php");
