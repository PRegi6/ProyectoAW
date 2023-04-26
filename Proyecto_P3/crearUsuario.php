<?php
    
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Crear Usuario";

    $form = new es\ucm\fdi\aw\FormCrearUsuario();

    if (isset($_POST['crearUsuario'])) { 
        $contenidoPrincipal = $form->gestiona();
    }
    else if(isset($_POST['crear'])){ 
        if (isset($_POST['datosUsuario'])) {
            $datosUsuario = $_SESSION['datosUsuario'];
            $contenidoPrincipal = $form->gestionaModificarDatos($datosUsuario);
        }
        else {
            $contenidoPrincipal = $form->gestiona(); 
        }
    }
    else{
        unset($_SESSION['datosUsuario']);
        $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarUsuarios();
    }
        

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
