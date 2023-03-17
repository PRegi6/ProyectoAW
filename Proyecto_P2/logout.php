<?php 
    require_once __DIR__.'/includes/config.php';

    unset($_SESSION['login']);
    unset($_SESSION['email']);
    unset($_SESSION['nombre']);
    if($_SESSION['rol']==Usuario::USER_ROLE){
        unset($_SESSION['tipoPlan']);
        unset($_SESSION['fechaExpiracion']);
    }
    unset($_SESSION['rol']);

    session_destroy();

    $tituloPagina = 'Logout';
    $contenidoPrincipal = <<<EOS
        <h1>Hasta pronto!</h1>
    EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';