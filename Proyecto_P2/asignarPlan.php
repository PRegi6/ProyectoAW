<?php
require_once __DIR__ . "/includes/config.php";
require_once __DIR__ . "/includes/Plan.php";
require_once __DIR__ . "/includes/Usuario.php";

$plns = Plan::cargarPlanes();

$tituloPagina = "Elige tu plan";

$contenidoPrincipal = Plan::mostrarPlanes($plns);
$fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato "YYYY-MM-DD"
$nueva_fecha = date('Y-m-d', strtotime('+30 days', strtotime($fecha_actual))); // Suma 30 dÃ­as a la fecha actual y obtiene la nueva fecha en el mismo formato

if (isset($_GET["datos"])) {
    $datos_encoded = $_GET["datos"];
    $datos = json_decode(urldecode($datos_encoded));
    if (isset($_POST["basico"])) {

        $usuario = Usuario::crea([$datos[0], $datos[1], $datos[2], $datos[3], Usuario::USER_ROLE, "basico", $nueva_fecha]);
        $_SESSION['login'] = true;
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['rol'] = $usuario->getRol();
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['tipoPlan'] = $usuario->getTipoPlan();
        header("Location: index.php");
        exit();
    } else if (isset($_POST["premium"])) {
        $usuario = Usuario::crea([$datos[0], $datos[1], $datos[2], $datos[3], Usuario::USER_ROLE, "premium", $nueva_fecha]);
        $_SESSION['login'] = true;
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['rol'] = $usuario->getRol();
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['tipoPlan'] = $usuario->getTipoPlan();
        header("Location: index.php");
        exit();
    } else if (isset($_POST["artista"])) {
        $usuario = Usuario::crea([$datos[0], $datos[1], $datos[2], $datos[3], Usuario::USER_ROLE, "artista", $nueva_fecha]);
        $_SESSION['login'] = true;
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['rol'] = $usuario->getRol();
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['tipoPlan'] = $usuario->getTipoPlan();
        header("Location: index.php");
        exit();
    } else {
        echo "Selecciona un plan";
    }
}
require RAIZ_APP . "/vistas/plantillas/plantillaInicio.php";
