<?php 
    require_once __DIR__."/includes/config.php";

    $form = new es\ucm\fdi\aw\FormLogin();
    $html = $form->gestiona();

    $tituloPagina = "Login - BeatHouse";

    $contenidoPrincipal = $html;

    require RAIZ_APP."/vistas/plantillas/plantillaInicio.php";
