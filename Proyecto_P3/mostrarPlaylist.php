<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Playlist Ususarios";

    // $idPlaylist = $_POST['idPlaylist'] ?? '';
    $idPlaylist = $_GET['id'] ?? '';
    
    $ListaCanciones = es\ucm\fdi\aw\Playlist::listaCancionesPlaylist($idPlaylist);

    $contenidoPrincipal = es\ucm\fdi\aw\Playlist::mostrarPlaylist($idPlaylist, $ListaCanciones);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>