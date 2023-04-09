<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Planes";
    $datos_encoded = $_GET["info"];
    $datos = json_decode(urldecode($datos_encoded));
    $form = new es\ucm\fdi\aw\FormModificarPlan();
    $contenidoPrincipal = $form->gestionaModificarDatos($datos);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>