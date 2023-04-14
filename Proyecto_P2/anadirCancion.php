<?php
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Añadir Cancion";
    $form = new es\ucm\fdi\aw\FormAnadirCancion();
    $contenidoPrincipal = $form->gestiona();

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";