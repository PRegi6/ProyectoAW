<?php
    require_once __DIR__."/includes/config.php";

    $form = new es\ucm\fdi\aw\FormCambiarPlan();

    $tituloPagina = "Cambio de suscripción";

    $datos = es\ucm\fdi\aw\Usuario::getDatos($_SESSION['email']);

    $contenidoPrincipal = $form->gestionaModificarDatos($datos);

    require RAIZ_APP."/vistas/plantillas/plantillaInicio.php";