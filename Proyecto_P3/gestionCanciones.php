<?php
    
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Modificar Canciones";

    $form = new es\ucm\fdi\aw\FormModificarCancion();

    if (isset($_POST['borrarCancion'])) { //si queremos borrar una cancion
        $idCancion = $_POST['borrarCancion'] ?? '';
        es\ucm\fdi\aw\Cancion::cambiarDuracion($idCancion);
        es\ucm\fdi\aw\Admin::borrarCancion($idCancion);

        header("Location: gestionCanciones.php");
    }

    else if (isset($_POST['modificarCancion'])) { //si queremos modificarla lo que hacemos es crear una session temporal para que guarde los datos
        $datosCancion = json_decode($_POST['modificarCancion']);
        $_SESSION['datosCancion'] = $datosCancion;
        $contenidoPrincipal = $form->gestionaModificarDatos($datosCancion); //generamos el formulario
    }
    else if(isset($_POST['Aplicar'])){ //Cuando le demos a Aplicar en el formulario saltara aqui y en caso de que haya errores se mostrara los datos anterior que estan guardados en la session
        $datosCancion = $_SESSION['datosCancion'];
        $contenidoPrincipal = $form->gestionaModificarDatos($datosCancion);
    }
    else{ //en caso de que no pulsemos ninguna muestra las canciones
        unset($_SESSION['datosCancion']); //Cuando acabo el formulario quito la variable de session
        $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarCanciones();
    }
        

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
