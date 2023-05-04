<?php
require_once __DIR__ . "/includes/config.php";

// Recibimos los datos enviados por la petición AJAX
$idCancion = $_POST['idCancion'] ?? '';
$idPlaylist = $_POST['idPlaylist'] ?? '';
$duracionCancion = $_POST['duracionCancion'] ?? '';
$accion = $_POST['accion'] ?? '';

// Ejecutamos la función PHP correspondiente según la acción enviada
if ($accion == "agregar-me-gusta") {
    es\ucm\fdi\aw\Cancion::agregarMeGusta($idCancion, $idPlaylist);
    es\ucm\fdi\aw\Cancion::anadirDuracion($idPlaylist, $duracionCancion);
} else if ($accion == "quitar-me-gusta") {
    es\ucm\fdi\aw\Cancion::quitarMeGusta($idCancion, $idPlaylist);
    es\ucm\fdi\aw\Cancion::quitarDuracion($idPlaylist, $duracionCancion);
}

    $tituloPagina = "BeatHouse";

    $idPlaylistMeGusta = es\ucm\fdi\aw\Playlist::idPlaylistMeGusta($_SESSION['email']);
    $ListaCanciones = es\ucm\fdi\aw\Playlist::listaCancionesPlaylist($idPlaylistMeGusta);

    $contenidoPrincipal = es\ucm\fdi\aw\Playlist::mostrarPlaylist($idPlaylistMeGusta, $ListaCanciones);

require RAIZ_APP . "/vistas/plantillas/plantilla.php";