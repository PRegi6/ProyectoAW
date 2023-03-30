<?php
    require_once __DIR__ . "/includes/config.php";
    require "./includes/Admin.php";

    $tituloPagina = "Planes";
    $contenidoPrincipal = Admin::mostrarPlanes();

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";