<?php
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Planes";
    $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarPlanes();

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";