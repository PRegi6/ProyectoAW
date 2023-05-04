<?php
    
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Modificar Usuarios";

    $form = new es\ucm\fdi\aw\FormModificarUsu();

    if (isset($_POST['borrarUsuario'])) { //si queremos borrar una cancion
        $email = $_POST['borrarUsuario'] ?? '';
        es\ucm\fdi\aw\Admin::borrarUsuario($email);
        es\ucm\fdi\aw\Admin::borrarPerfil($email);
        es\ucm\fdi\aw\Playlist::borrarPlaylistMeGusta($email);
        header("Location: gestionUsuarios.php");
    }

    else if (isset($_POST['modificarUsuario'])) { //si queremos modificarla lo que hacemos es crear una session temporal para que guarde los datos
        $datosUsuario = json_decode($_POST['modificarUsuario']);
        $_SESSION['datosUsuario'] = $datosUsuario;
        $contenidoPrincipal = $form->gestionaModificarDatos($datosUsuario); //generamos el formulario
    }
    else if(isset($_POST['Aplicar'])){ //Cuando le demos a Aplicar en el formulario saltara aqui y en caso de que haya errores se mostrara los datos anterior que estan guardados en la session
        $datosUsuario = $_SESSION['datosUsuario'];
        $contenidoPrincipal = $form->gestionaModificarDatos($datosUsuario);
    }
    else{ //en caso de que no pulsemos ninguna muestra las canciones
        unset($_SESSION['datosUsuario']); //Cuando acabo el formulario quito la variable de session
        $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarUsuarios();
    }
        

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
