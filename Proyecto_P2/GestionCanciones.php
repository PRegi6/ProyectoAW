<?php
    require_once __DIR__."/includes/config.php";
    $tituloPagina = "BeatHouse";
    
    
    
    $db = Aplicacion::getInstance()->getConexionBd();

    // Consulta SQL para obtener los datos de la tabla
    $consulta = "SELECT * FROM canciones";
    $resultado = $db->query($consulta);

    // Construcción dinámica de la tabla con los resultados de la consulta
    $contenidoTabla = "<table border='1'>";
    while ($fila = $resultado->fetch_assoc()) {
        $contenidoTabla .= "<tr>";
        $contenidoTabla .= "<td>".$fila['idCancion']."</td>";
        $contenidoTabla .= "<td>".$fila['nombreCancion']."</td>";
        $contenidoTabla .= "<td>".$fila['genero']."</td>";
        $contenidoTabla .= "<td>".$fila['nombreAlbum']."</td>";
        $contenidoTabla .= "<td>".$fila['duracion']."</td>";
        $contenidoTabla .= "<td>".$fila['rutaCancion']."</td>";
        $contenidoTabla .= "<td>".$fila['rutaImagen']."</td>";
        $contenidoTabla .= "</tr>";
    }
    $contenidoTabla .= "</table>";

    // Concatenamos la variable en la cadena HEREDOC
    $contenidoPrincipal = <<<EOS
        <h1>Administrar canciones</h1>

        <select name="operacion">
            <option value='borrar'>Borrar cancion</option>
            <option value='borrarPlaylist'>Borrar playlist</option>
            
        </select>
    EOS;
        $contenidoPrincipal.=$contenidoTabla;


    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>