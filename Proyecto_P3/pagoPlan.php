<?php
    require_once __DIR__."/includes/config.php";

    $form = new es\ucm\fdi\aw\FormPagoPlan();

    $tituloPagina = "Pago de la suscripción";

    $valores = $_SESSION['valores'];
    $plan = $_SESSION['plan'];
    $valores = json_decode($valores);
    // Combinar los valores en un nuevo arreglo
    $datos = array_merge($valores, [$plan]);

    $contenidoPrincipal = $form->gestionaModificarDatos($datos);

    require RAIZ_APP."/vistas/plantillas/plantillaInicio.php";