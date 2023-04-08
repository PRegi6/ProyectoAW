<?php
    require_once __DIR__."/includes/config.php";

    $tituloPagina = "Usuarios";
    $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarUsuarios();

    require RAIZ_APP."/vistas/plantillas/plantilla.php";