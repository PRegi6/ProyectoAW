<?php
    require_once __DIR__."/includes/config.php";
    require_once __DIR__."/includes/Admin.php";
    
    $tituloPagina = "Anuncios";
    $contenidoPrincipal = Admin::mostrarAnuncios($_SESSION['email']);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
