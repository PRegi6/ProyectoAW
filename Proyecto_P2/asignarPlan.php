<?php
require_once __DIR__ . "/includes/config.php";

    // Función para asignar el plan al usuario
    function asignarPlan($plan, $valores, &$contenidoPrincipal) {    
        $fecha_actual = date('Y-m-d');
        $nueva_fecha = date('Y-m-d', strtotime('+30 days', strtotime($fecha_actual)));
        //Como se crea 
        //$email, $password, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracionPlan
        $usuario = es\ucm\fdi\aw\Usuario::crea([$valores[0], $valores[1], $valores[2], $valores[3], es\ucm\fdi\aw\Usuario::USER_ROLE, $plan, $nueva_fecha]);
        $_SESSION['login'] = true;
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['rol'] = $usuario->getRol();
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['tipoPlan'] = $usuario->getTipoPlan();
        header("Location: index.php");
        exit();
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
