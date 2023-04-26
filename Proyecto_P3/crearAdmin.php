<?php
    
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Crear Administrador";

    $form = new es\ucm\fdi\aw\FormCrearAdmin();

    if (isset($_POST['crearAdmin'])) { //si queremos modificarla lo que hacemos es crear una session temporal para que guarde los datos
        $contenidoPrincipal = $form->gestiona(); //generamos el formulario
    }
    else if(isset($_POST['Continuar'])){ //Cuando le demos a Aplicar en el formulario saltara aqui y en caso de que haya errores se mostrara los datos anterior que estan guardados en la session
        if (isset($_POST['datosAdmin'])) { // Por si se le da a crear con TODOS los campos vacios
            $datosAdmin = $_SESSION['datosAdmin'];
            $contenidoPrincipal = $form->gestionaModificarDatos($datosAdmin);
        }
        else {
            $contenidoPrincipal = $form->gestiona(); 
        }
    }
    else{ //en caso de que no pulsemos ninguna muestra las canciones
        unset($_SESSION['datosAdmin']); //Cuando acabo el formulario quito la variable de session
        $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarUsuarios();
    }
        

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
