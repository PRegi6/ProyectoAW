<?php
    
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Modificar Planes";

    $form = new es\ucm\fdi\aw\FormModificarPlan();

    if (isset($_POST['modificarPlan'])) { //si queremos modificarla lo que hacemos es crear una session temporal para que guarde los datos
        $datosPlan = json_decode($_POST['modificarPlan']);
        $_SESSION['datosPlan'] = $datosPlan;
        $contenidoPrincipal = $form->gestionaModificarDatos($datosPlan); //generamos el formulario
    }
    else if(isset($_POST['Aplicar'])){ //Cuando le demos a Aplicar en el formulario saltara aqui y en caso de que haya errores se mostrara los datos anterior que estan guardados en la session
        $datosPlan = $_SESSION['datosPlan'];
        $contenidoPrincipal = $form->gestionaModificarDatos($datosPlan);
    }
    else{ //en caso de que no pulsemos ninguna muestra las canciones
        unset($_SESSION['datosPlan']); //Cuando acabo el formulario quito la variable de session
        $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarPlanes();
    }

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
