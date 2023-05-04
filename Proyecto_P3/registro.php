<?php
    require_once __DIR__."/includes/config.php";

    $form = new es\ucm\fdi\aw\FormRegistro();
    $html = $form->gestionaRegistro();

    $tituloPagina = "Registro - BeatHouse";

    $contenidoPrincipal = $html;

    require RAIZ_APP."/vistas/plantillas/plantillaInicio.php";