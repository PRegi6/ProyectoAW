<?php
require_once __DIR__ . "/includes/config.php";

function convertirTiempo($segundos) {
    $horas = floor($segundos / 3600);
    $minutos = floor(($segundos - ($horas * 3600)) / 60);
    $segundos = $segundos - ($horas * 3600) - ($minutos * 60);

    if ($horas > 0) {
        $tiempo = $horas . "h " . $minutos . "m " . $segundos . "s";
    } else {
        $tiempo = $minutos . "m " . $segundos . "s";
    }

    return $tiempo;
}

    $tituloPagina = "BeatHouse";

    $contenidoPrincipal = <<<EOS
            <div class="info-meMegusta">
                <h1> Canciones que te gustan </h1>
        EOS;

    $idPlaylistMeGusta = es\ucm\fdi\aw\Playlist::idPlaylistMeGusta($_SESSION['email']);
    $ListaCanciones = es\ucm\fdi\aw\Playlist::listaCancionesMeGusta($idPlaylistMeGusta);
    if (empty($ListaCanciones)) {
        $contenidoPrincipal .= <<<EOS
            No hay resultados
            </div>
        EOS;
    } else {
        $canciones = array();
        foreach ($ListaCanciones as $cancion) {
            $info = array(
                'img' => $cancion->getRutaImagen(),
                'name' => $cancion->getNombre(),
                'artist' => $cancion->getNombreAlbum(),
                'music' => $cancion->getRutaCancion()
            );
            array_push($canciones, $info);
        }
        $numCanciones = count($canciones);
        $duracionPlaylist = es\ucm\fdi\aw\Cancion::obtenerDuracionPlaylist($idPlaylistMeGusta);
        $stringDuracion = convertirTiempo($duracionPlaylist);
        $datosJson = json_encode($canciones);
        $contenidoPrincipal .= <<<EOS
            <div class="play" onclick='reproducirSeleccionado($datosJson)'>
                <i class="fa fa-play-circle fa-5x"></i>
            </div>
            <h3>Total de canciones $numCanciones</h3>
            <h3>Tiempo aproximado {$stringDuracion}</h3>
            </div>
        EOS;
        $contenidoPrincipal .= es\ucm\fdi\aw\Cancion::mostrarCancionesTotal($ListaCanciones);
    }

require RAIZ_APP . "/vistas/plantillas/plantilla.php";
