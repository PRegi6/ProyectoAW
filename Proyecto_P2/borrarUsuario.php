<?php 
    require "./includes/Admin.php";
    require "./includes/config.php";

    $email = (isset($_GET['email'])) ? $_GET['email'] : null;
    if(!empty($email)){
        Admin::borrarUsuarios($email);
    }

    header("Location: gestionUsuarios.php");
