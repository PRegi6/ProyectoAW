<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Playlist Ususarios";

    $idPlaylist = $_POST['idPlaylist'] ?? '';
    $idCancion = $_POST['idCancion'] ?? '';
    $duracion = $_POST['duracionCancion'] ?? '';

    if(isset($_POST['borrar'])){
        es\ucm\fdi\aw\Playlist::borrarCancionPlaylist($idPlaylist, $idCancion);
        es\ucm\fdi\aw\Cancion::quitarDuracion($idPlaylist, $duracion);
    }
    
    $ListaCanciones = es\ucm\fdi\aw\Playlist::listaCancionesPlaylist($idPlaylist);
    $formato = "";
    $contenidoPrincipal = es\ucm\fdi\aw\Playlist::mostrarPlaylist($idPlaylist, $ListaCanciones, $formato);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>