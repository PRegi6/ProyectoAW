<?php
    
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Crear playlist";

    $form = new es\ucm\fdi\aw\FormCrearPlaylist();

    $contenidoPrincipal = $form->gestiona();

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
