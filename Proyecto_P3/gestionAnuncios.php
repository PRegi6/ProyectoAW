<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Anuncios";
    $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarAnuncios($_SESSION['email']);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
