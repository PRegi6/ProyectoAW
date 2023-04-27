<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Cambiar perfil";
    if ($_SESSION['rol'] == es\ucm\fdi\aw\Usuario::ADMIN_ROLE) {
        $datos_encoded = es\ucm\fdi\aw\Admin::getDatos($_SESSION['email']);
        $datos = json_decode($datos_encoded);
    
        $form = new es\ucm\fdi\aw\FormModificarDatosAdmin();

        $contenidoPrincipal = $form->gestionaModificarDatos($datos);
    }
    else {
        $datos_encoded = es\ucm\fdi\aw\Usuario::getDatos($_SESSION['email']);
        $datos = json_decode($datos_encoded);
    
        $form = new es\ucm\fdi\aw\FormModificarDatosUsuario();

        $contenidoPrincipal = $form->gestionaModificarDatos($datos);
    }
    
    

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>