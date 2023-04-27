<?php
    require_once __DIR__ . '/includes/config.php';

    unset($_SESSION['login']);
    unset($_SESSION['email']);
    unset($_SESSION['nombre']);
    if (isset($_SESSION['rol']) && $_SESSION['rol'] == es\ucm\fdi\aw\Usuario::USER_ROLE) { //Para que no de error cuando cierras sesión
        unset($_SESSION['tipoPlan']);
    }
    unset($_SESSION['rol']);

    session_destroy();

    $tituloPagina = 'Logout';
    $contenidoPrincipal = <<<EOS
        <h1>Hasta pronto!</h1> 
        <script>
            localStorage.clear();
        </script>
        EOS;

    require __DIR__ . '/includes/vistas/plantillas/plantilla.php';
