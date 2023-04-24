<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Cambiar perfil";
    $datos_encoded = es\ucm\fdi\aw\Usuario::getDatos($_SESSION['email']);
    $datos = json_decode($datos_encoded);
    $form = new es\ucm\fdi\aw\FormModificarMisDatos();
    $contenidoPrincipal = $form->gestionaModificarDatos($datos);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>