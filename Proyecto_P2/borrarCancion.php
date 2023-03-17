<?php 
require "./includes/Admin.php";
require "./includes/config.php";

$id = (isset($_GET['id'])) ? $_GET['id'] : null;
if(!empty($id)){
    if(Admin::borrarCancion($id)) echo "bien";
}

header("Location: gestionCanciones.php");
?>