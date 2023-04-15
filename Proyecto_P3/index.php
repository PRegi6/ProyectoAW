<?php
require_once __DIR__ . "/includes/config.php";
$tituloPagina = "BeatHouse";

$contenidoPrincipal = <<<EOS
        <form class="buscador" action= "index.php" method="POST">
            <input type="text" placeholder="Buscar" name="buscador">
            <button type="submit" class="boton-buscador" name="submit">
                <i class="fa fa-search" title="buscador"></i>
            </button>
        </form>
    EOS;


if (isset($_POST['submit'])) {
    if (!empty($_POST['buscador'])) {
        $ListaCanciones = es\ucm\fdi\aw\Cancion::listaCanciones($_POST['buscador']);
        if (empty($ListaCanciones)) {
            $contenidoPrincipal .= "No hay resultados";
        } else {
            if (!isset($_SESSION['login']) || ($_SESSION['rol'] == es\ucm\fdi\aw\Usuario::ADMIN_ROLE)) {
                $contenidoPrincipal .= es\ucm\fdi\aw\Cancion::mostrarCanciones($ListaCanciones);
            } else {
                $contenidoPrincipal .= es\ucm\fdi\aw\Cancion::mostrarCancionesTotal($ListaCanciones);
            }
        }
    }
}

require RAIZ_APP . "/vistas/plantillas/plantilla.php";
