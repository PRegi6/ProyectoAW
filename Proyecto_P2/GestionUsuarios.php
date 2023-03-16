<?php
    require_once __DIR__."/includes/config.php";
    $tituloPagina = "BeatHouse";
    
    $db=Aplicacion::getInstance()->getConexionBd();


    // Concatenamos la variable en la cadena HEREDOC
    $contenidoPrincipal = <<<EOS
        <h1>Administrar usuarios</h1>

        <select name="operacion">
            <option value='borrar'>Borrar usuario</option>
            <option value='rename'>Renombrar usuario</option>
            <option value='cambiarPass'>Cambiar contraseña</option>
        </select>


    EOS;

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>