<?php
    require_once __DIR__."/includes/config.php";
    require_once __DIR__."/includes/FormRegistro.php";

    $form = new FormRegistro();
    $html = $form->gestiona();

    $tituloPagina = "Registro - BeatHouse";

    $contenidoPrincipal = $html;

    require RAIZ_APP."/vistas/plantillas/plantillaInicio.php";