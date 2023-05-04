<?php
    require_once __DIR__."/includes/config.php";
    $tituloPagina = "Tendencias";
    $listaCanciones = es\ucm\fdi\aw\Admin::cancionesAplicacion();
    $contenidoPrincipal = "";

    // Recibimos los datos enviados por la petición AJAX
    $idCancion = $_POST['idCancion'] ?? '';
    $idPlaylist = $_POST['idPlaylist'] ?? '';
    $duracionCancion = $_POST['duracionCancion'] ?? '';
    $accion = $_POST['accion'] ?? '';

    // Ejecutamos la función PHP correspondiente según la acción enviada
    if ($accion == "agregar-tendencia") {
        es\ucm\fdi\aw\Cancion::agregarMeGusta($idCancion, $idPlaylist);
        es\ucm\fdi\aw\Cancion::anadirDuracion($idPlaylist, $duracionCancion);
    } else if ($accion == "quitar-tendencia") {
        es\ucm\fdi\aw\Cancion::quitarMeGusta($idCancion, $idPlaylist);
        es\ucm\fdi\aw\Cancion::quitarDuracion($idPlaylist, $duracionCancion);
    }

    if (empty($listaCanciones)) {
        $contenidoPrincipal .= "No hay resultados";
    } else {
        $contenidoPrincipal .= es\ucm\fdi\aw\Cancion::gestionTendencias($listaCanciones);
    }


    require RAIZ_APP."/vistas/plantillas/plantilla.php";