<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Tendencias";
    $listaCanciones = es\ucm\fdi\aw\Playlist::getPlaylistTendencias();
    $contenidoPrincipal = "";
    if (empty($listaCanciones)) {
        $contenidoPrincipal .= "No hay tendencias";
    } else {
        $contenidoPrincipal = '<h1>Tendencias mundiales</h1>';
        if (!isset($_SESSION['login'])) {
            $contenidoPrincipal .= es\ucm\fdi\aw\Cancion::mostrarCanciones($listaCanciones);
        } else {
            $contenidoPrincipal .= es\ucm\fdi\aw\Cancion::mostrarCancionesTotal($listaCanciones);
        }
    }

    require RAIZ_APP."/vistas/plantillas/plantilla.php";