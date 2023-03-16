<?php 
require_once __DIR__.'/includes/config.php';


unset($_SESSION['login']);
unset($_SESSION['email']);
unset($_SESSION['nombre']);
unset($_SESSION['rol']);
unset($_SESSION['esAdmin']);

session_destroy();

$tituloPagina = 'Logout';
$contenidoPrincipal = <<<EOS
<h1>Hasta pronto!</h1>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';