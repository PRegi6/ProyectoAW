<?php 
    require_once __DIR__."/includes/config.php";

    $form = new es\ucm\fdi\aw\FormContacto();
    $html = $form->gestiona();

    $tituloPagina = "Contacto - BeatHouse";

    $contenidoPrincipal = $html;

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
