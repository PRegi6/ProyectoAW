<?php
    
    require_once __DIR__ . "/includes/config.php";

    //REVISAR EL FORM PARA PODER CAMBIAR EL NOMBRE DE LA PLAYLIST
    $accion = $_POST['accion'] ?? '';
    $idPlaylist = $_POST['idPlaylist'] ?? '';
    $email = $_POST['email'] ?? '';
    $nombrePlaylist = $_POST['nombre'] ?? '';

    if($accion == "crearPlaylist"){
        es\ucm\fdi\aw\Playlist::insertaPlaylist([$nombrePlaylist, $email]);
    }
    else if($accion == "eliminarPlaylist"){
        es\ucm\fdi\aw\Playlist::borrarPlaylist($idPlaylist);
    }
    header('Location: index.php');
    