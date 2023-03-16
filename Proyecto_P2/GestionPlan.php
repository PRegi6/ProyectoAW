<?php
    require_once __DIR__."/includes/config.php";
    $tituloPagina = "BeatHouse";
    
    
    
    $db = Aplicacion::getInstance()->getConexionBd();

    // Consulta SQL para obtener los datos de la tabla
    $consulta = "SELECT * FROM plandepago";
    $resultado = $db->query($consulta);

    // Construcción dinámica de la tabla con los resultados de la consulta
    $contenidoTabla = "<table border='1'>";
    while ($fila = $resultado->fetch_assoc()) {
        $contenidoTabla .= "<tr>";
        $contenidoTabla .= "<td>".$fila['tipoPlan']."</td>";
        $contenidoTabla .= "<td>".$fila['precio']."</td>";
        $contenidoTabla .= "<td>".$fila['duracionPlan']."</td>";
        $contenidoTabla .= "</tr>";
    }
    $contenidoTabla .= "</table>";

    // Concatenamos la variable en la cadena HEREDOC
    $contenidoPrincipal = <<<EOS
        <h1>Administrar planes</h1>

        <select name="operacion">
            <option value='CambiarPlan'>Cambiar tipo de plan</option>
            <option value='CambiarDuracion'>Cambiar duracion de plan</option>
            <option value='CambiarPrecio'>Cambiar precio de plan</option>
            
        </select>
    EOS;
        $contenidoPrincipal.=$contenidoTabla;


    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>