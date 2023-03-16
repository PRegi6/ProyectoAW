<?php
    require_once __DIR__."/includes/config.php";
    $tituloPagina = "BeatHouse";
    
    
    
    $db = Aplicacion::getInstance()->getConexionBd();

    // Consulta SQL para obtener los datos de la tabla
    $consulta = "SELECT * FROM usuarios";
    $resultado = $db->query($consulta);

    // Construcción dinámica de la tabla con los resultados de la consulta
    $contenidoTabla = "<table border='1'>";
    while ($fila = $resultado->fetch_assoc()) {
        $contenidoTabla .= "<tr>";
        $contenidoTabla .= "<td>".$fila['email']."</td>";
        $contenidoTabla .= "<td>".$fila['contraseña']."</td>";
        $contenidoTabla .= "<td>".$fila['nombre']."</td>";
        $contenidoTabla .= "<td>".$fila['apellidos']."</td>";
        $contenidoTabla .= "<td>".$fila['rol']."</td>";
        $contenidoTabla .= "<td>".$fila['tipoPlan']."</td>";
        $contenidoTabla .= "<td>".$fila['fechaExpiracionPlan']."</td>";
        $contenidoTabla .= "</tr>";
    }
    $contenidoTabla .= "</table>";

    // Concatenamos la variable en la cadena HEREDOC
    $contenidoPrincipal = <<<EOS
        <h1>Administrar usuarios</h1>

        <select name="operacion">
            <option value='borrar'>Borrar usuario</option>
            <option value='rename'>Renombrar usuario</option>
            <option value='cambiarPass'>Cambiar contraseña</option>
        </select>
    EOS;
        $contenidoPrincipal.=$contenidoTabla;


    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>