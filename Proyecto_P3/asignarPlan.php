<?php
require_once __DIR__ . "/includes/config.php";

    // Función para asignar el plan al usuario
    function asignarPlan($plan, $valores, &$contenidoPrincipal) {    
        $valores = json_encode($valores);
        $_SESSION['valores'] = $valores;
        $_SESSION['plan'] = $plan;
        header("Location: pagoPlan.php");
        exit(); // Salimos del script después de enviar el formulario
    }

    $tituloPagina = "Elige tu plan";

    $valores = $_POST['valores'];
    //[$email, $password, $nombre, $apellidos]
    $datos = explode(',', $valores);
    // Eliminar espacios en blanco al principio y al final de cada cadena
    foreach ($datos as &$valor) {
        $valor = trim($valor);
    }

    $contenidoPrincipal = $datos[0];
    $contenidoPrincipal .= $datos[1];
    $contenidoPrincipal .= $datos[2];
    $contenidoPrincipal .= $datos[3];
    // Asignar el plan seleccionado
    switch ($_POST["tipoPlan"]) {
        case "basico":
            asignarPlan("basico", $datos, $contenidoPrincipal);
            break;
        case "premium":
            asignarPlan("premium", $datos, $contenidoPrincipal);
            break;
        case "artista":
            asignarPlan("artista", $datos, $contenidoPrincipal);
            break;
        default:
            echo "Selecciona un plan";
    }
