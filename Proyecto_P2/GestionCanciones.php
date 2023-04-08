<?php
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Canciones";
    $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarCanciones();

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
