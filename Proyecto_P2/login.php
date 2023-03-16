<?php 
    require_once __DIR__."/includes/config.php";
    require_once __DIR__."/includes/FormLogin.php";

    $form = new FormLogin();
    $html = $form->gestiona();

    $tituloPagina = "Login - BeatHouse";

    $contenidoPrincipal = $html;

    require RAIZ_APP."/vistas/plantillas/plantillaInicio.php";

?>