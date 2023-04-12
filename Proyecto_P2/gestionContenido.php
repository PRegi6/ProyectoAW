<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Contenido";
    $contenidoPrincipal = es\ucm\fdi\aw\Usuario::verMisCanciones().<<<EOS
    <ul>
        <li><a href="AñadirCancion.php">Añadir cancion</a></li>
        <li><a href="borrarCancion.php">Borrar cancion</a></li>
    </ul>
    EOS;

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
