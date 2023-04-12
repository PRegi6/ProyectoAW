<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Contenido";
    $contenidoPrincipal = "
    <ul>
        <li><a href='AñadirCancion.php'>Añadir cancion</a></li>
        <li><a href='borrarCancion.php'>Borrar cancion</a></li>
        <li><a href='modificarCancion.php'>Modificar cancion</a></li>
    </ul>
    ";

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
