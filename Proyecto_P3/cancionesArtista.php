<?php
    require_once __DIR__."/includes/config.php";

    $tituloPagina = "Mis Canciones";

    $form = new es\ucm\fdi\aw\FormModificarCancionArtista();

    if (isset($_POST['borrarCancion'])) { //si queremos borrar una cancion
        $datosCancion = json_decode($_POST['borrarCancion']);
        es\ucm\fdi\aw\Admin::borrarCancion($datosCancion[0]); //BORRAMOS DE LA BASE DE DATOS
        if(file_exists($datosCancion[5])) { //BORRAMOS LA CANCION DEL DIRECTORIO
            unlink($datosCancion[5]);
        }
        if(file_exists($datosCancion[6])) { //BORRAMOS LA IMAGEN DEL DIRECTORIO
            unlink($datosCancion[6]);
        }
        header("Location: cancionesArtista.php");
    }

    else if (isset($_POST['modificarDatosCancion'])) { //si queremos modificarla lo que hacemos es crear una session temporal para que guarde los datos
        $datosCancion = json_decode($_POST['modificarDatosCancion']);
        $_SESSION['datosCancion'] = $datosCancion;
        $contenidoPrincipal = $form->gestionaModificarDatos($datosCancion); //generamos el formulario
    }
    else if(isset($_POST['aceptarModificacion'])){ //Cuando le demos a Aplicar en el formulario saltara aqui y en caso de que haya errores se mostrara los datos anterior que estan guardados en la session
        $datosCancion = $_SESSION['datosCancion'];
        $contenidoPrincipal = $form->gestionaModificarDatos($datosCancion);
    }
    else{ //en caso de que no pulsemos ninguna muestra las canciones
        unset($_SESSION['datosCancion']); //Cuando acabo el formulario quito la variable de session
        $contenidoPrincipal = es\ucm\fdi\aw\Cancion::mostrarCancionesArtista($_SESSION['email']);
    }

    require RAIZ_APP."/vistas/plantillas/plantilla.php";