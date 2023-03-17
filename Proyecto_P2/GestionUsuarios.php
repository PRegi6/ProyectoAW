<?php
    require_once __DIR__."/includes/config.php";
    require_once __DIR__."/includes/Admin.php";

    $tituloPagina = "Usuarios";
    $contenidoPrincipal = Admin::mostrarUsuarios();

    require RAIZ_APP."/vistas/plantillas/plantilla.php";