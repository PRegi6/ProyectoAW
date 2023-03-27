<?php
    require_once __DIR__."/includes/config.php";
    require_once __DIR__."/includes/FormModificarUsu.php";
    
    $tituloPagina = "Canciones";
    $datos_encoded = $_GET["info"];
    $datos = json_decode(urldecode($datos_encoded));
    $form = new FormModificarUsu();
    $contenidoPrincipal = $form->gestionaModificarDatos($datos);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>