<?php
    
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Modificar Administradores";

    $form = new es\ucm\fdi\aw\FormModificarAdmin();

    if (isset($_POST['borrarAdmin'])) { //si queremos borrar una cancion
        $email = $_POST['borrarAdmin'] ?? '';
        es\ucm\fdi\aw\Admin::borrarAdmin($email);
        es\ucm\fdi\aw\Admin::borrarPerfil($email);
        header("Location: gestionAdmin.php");
    }

    else if (isset($_POST['modificarAdmin'])) { //si queremos modificarla lo que hacemos es crear una session temporal para que guarde los datos
        $datosAdmin = json_decode($_POST['modificarAdmin']);
        $_SESSION['datosAdmin'] = $datosAdmin;
        $contenidoPrincipal = $form->gestionaModificarDatos($datosAdmin); //generamos el formulario
    }
    else if(isset($_POST['Aplicar'])){ //Cuando le demos a Aplicar en el formulario saltara aqui y en caso de que haya errores se mostrara los datos anterior que estan guardados en la session
        $datosAdmin = $_SESSION['datosAdmin'];
        $contenidoPrincipal = $form->gestionaModificarDatos($datosAdmin);
    }
    else{ //en caso de que no pulsemos ninguna muestra las canciones
        unset($_SESSION['datosAdmin']); //Cuando acabo el formulario quito la variable de session
        $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarAdmins();
    }
        

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
