<?php
    require_once __DIR__ . "/includes/config.php";
    require_once __DIR__ . "/includes/Admin.php";

    $tituloPagina = "Canciones";
    $contenidoPrincipal = Admin::mostrarCanciones();

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
