<?php

    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Playlist";
    $contenidoPrincipal = es\ucm\fdi\aw\Usuario::verPlaylists($_SESSION['email']);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";