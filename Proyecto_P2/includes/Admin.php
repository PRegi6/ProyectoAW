<?php
namespace es\ucm\fdi\aw;
class Admin
{

    public function __construct()
    {
    }

    public static function borrarUsuarios($email)
    {

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM perfil WHERE email='%s'", $email);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $rs->free();
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function borrarCancion($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM canciones WHERE idCancion=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $rs->free();
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    public function renameUsuario($email, $nombre)
    {
        $user = Usuario::buscaPerfil($email);
        if ($user) {
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("UPDATE perfil SET nombre='%s' WHERE email='%s'", $nombre, $email);
            $rs = $conn->query($query);
            $result = false;
            if ($rs) {
                $rs->free();
                $result = true;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return $result;
        }
    }

    public static function modificarDatosPerfil($datos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE perfil SET contraseña='%s', nombre='%s', apellidos='%s', rol='%s' WHERE email='%s'"
        , Usuario::hashPassword($datos[1])
        , $datos[2]
        , $datos[3]
        , $datos[4]
        , $datos[0]
        );
        $rs = $conn->query($query);
        if ($rs) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function modificarDatosUsuario($datos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuarios SET contraseña='%s', nombre='%s', apellidos='%s', rol='%s', tipoPlan='%s', fechaExpiracionPlan='%s' WHERE email='%s'"
        , Usuario::hashPassword($datos[1])
        , $datos[2]
        , $datos[3]
        , $datos[4]
        , $datos[5]
        , $datos[6]
        , $datos[0]
        );
        $rs = $conn->query($query);
        if ($rs) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function modificarCancion($datos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE canciones SET nombreCancion='%s', genero='%s', nombreAlbum='%s', duracion='%s', rutaCancion='%s', rutaImagen='%s' WHERE idCancion='%s'"
        , $datos[1]
        , $datos[2]
        , $datos[3]
        , $datos[4]
        , $datos[5]
        , $datos[6]
        , $datos[0]
        );
        $rs = $conn->query($query);
        if ($rs) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function modificarPlanPago($datos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE plandepago SET precio='%s', duracionPlan='%s' WHERE tipoPlan='%s'"
        , $datos[0]
        , $datos[1]
        , $datos[2]
        , $datos[0]
        );
        $rs = $conn->query($query);
        if ($rs) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function cambiaraAdmin($datos)
    {
        if(self::borrarUsuario($datos[0])){
            self::insertaAdmin($datos);
        }
        return false;
    }

    public static function borrarUsuario($email)
    {

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM usuarios WHERE email='%s'", $email);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $rs->free();
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function insertaAdmin($datos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO admin (email, contraseña, nombre, apellidos, rol) VALUES ('%s', '%s', '%s', '%s', '%s')",
            $datos[0],
            Usuario::hashPassword($datos[1]),
            $datos[2],
            $datos[3],
            $datos[4]
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }

    public function cambiarPassword($email, $nuevoPass)
    {
        $user = Usuario::buscaUsuario($email);
        $user->cambiaPassword($nuevoPass);
    }

    //FUNCIONES PARA OBTENER DATOS DE BD

    public static function mostrarUsuarios()
    {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = "SELECT * FROM usuarios";
        $resultado = $conn->query($consulta);

        // Construcción dinámica de la tabla con los resultados de la consulta
        $contenidoPrincipal = "<h1>Administrar usuarios</h1>";
        $contenidoPrincipal .= "<table border='1'>";
        $contenidoPrincipal .= "<tr><th>Email</th><th>Contraseña</th><th>Nombre</th><th>Apellidos</th><th>Rol</th><th>Tipo Plan</th><th>Fecha Expiracion</th><th>Borrar</th><th>Modificar</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            $contenidoPrincipal .= "<tr>";
            $contenidoPrincipal .= "<td>" . $fila['email'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['contraseña'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['nombre'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['apellidos'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['rol'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['tipoPlan'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['fechaExpiracionPlan'] . "</td>";
            $contenidoPrincipal .= "<td><a href='borrarUsuario.php?email={$fila['email']}'>Borrar</td>";
            $info = [$fila['email'], $fila['contraseña'], $fila['nombre'], $fila['apellidos'], $fila['rol'], $fila['tipoPlan'], $fila['fechaExpiracionPlan']];
            $info_encoded = urlencode(json_encode($info));
            $contenidoPrincipal .= "<td><a href='modificarUsuario.php?info={$info_encoded}'>Editar</td>";
            $contenidoPrincipal .= "</tr>";
        }
        $resultado->free();

        $contenidoPrincipal .= "</table>";
        return $contenidoPrincipal;
    }

    public static function mostrarCanciones()
    {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = "SELECT * FROM canciones";
        $resultado = $conn->query($consulta);

        // Construcción dinámica de la tabla con los resultados de la consulta
        $contenidoPrincipal = "<h1>Administrar canciones</h1>";
        $contenidoPrincipal .= "<table border='1'>";
        $contenidoPrincipal .= "<tr><th>ID Cancion</th><th>Nombre</th><th>Género</th><th>Álbum</th><th>Duración</th><th>Ruta Canción</th><th>Ruta Imagen</th><th>Borrar</th><th>Modificar</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            $contenidoPrincipal .= "<tr>";
            $contenidoPrincipal .= "<td>" . $fila['idCancion'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['nombreCancion'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['genero'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['nombreAlbum'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['duracion'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['rutaCancion'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['rutaImagen'] . "</td>";
            $contenidoPrincipal .= "<td><a href='borrarCancion.php?id={$fila['idCancion']}'>Borrar</td>";
            $info = [$fila['idCancion'], $fila['nombreCancion'], $fila['genero'], $fila['nombreAlbum'], $fila['duracion'], $fila['rutaCancion'], $fila['rutaImagen']];
            $info_encoded = urlencode(json_encode($info));
            $contenidoPrincipal .= "<td><a href='modificarCancion.php?info={$info_encoded}'>Editar</td>";
            $contenidoPrincipal .= "</tr>";
        }
        $resultado->free();

        $contenidoPrincipal .= "</table>";
        return $contenidoPrincipal;
    }

    public static function mostrarPlanes()
    {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = "SELECT * FROM plandepago";
        $resultado = $conn->query($consulta);

        // Construcción dinámica de la tabla con los resultados de la consulta
        $contenidoPrincipal = "<h1>Administrar Planes</h1>";
        $contenidoPrincipal .= "<table border='1'>";
        $contenidoPrincipal .= "<tr><th>Tipo Plan</th><th>Precio</th><th>Duracion</th><th>Modificar</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            $contenidoPrincipal .= "<tr>";
            $contenidoPrincipal .= "<td>" . $fila['tipoPlan'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['precio'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['duracionPlan'] . "</td>";
            $info = [$fila['tipoPlan'], $fila['precio'], $fila['duracionPlan']];
            $info_encoded = urlencode(json_encode($info));
            $contenidoPrincipal .= "<td><a href='modificarPlan.php?info={$info_encoded}'>Editar</td>";
            $contenidoPrincipal .= "</tr>";
        }
        $resultado->free();
        
        $contenidoPrincipal .= "</table>";
        return $contenidoPrincipal;
    }

    public static function selectorPlanes($tipoPlan)
    {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = "SELECT * FROM plandepago";
        $resultado = $conn->query($consulta);
        
        $contenidoPrincipal = "<select name= 'tipoPlan'>";
        while ($fila = $resultado->fetch_assoc()) {
            $selecionado = ($fila['tipoPlan'] == $tipoPlan) ? " selected" : "";
            $contenidoPrincipal .= "<option value=" . $fila['tipoPlan'] . $selecionado . " > " . $fila['tipoPlan'] . "</option>";
        }
        $resultado->free();

        $contenidoPrincipal .= "</select>";
        return $contenidoPrincipal;
    }

    public static function mostrarAnuncios($email)
    {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = "SELECT * FROM gestionanuncios WHERE email='$email'";
        $resultado = $conn->query($consulta);

        // Construcción dinámica de la tabla con los resultados de la consulta
        $contenidoPrincipal = "<h1>Administrar Planes</h1>";
        $contenidoPrincipal .= "<table border='1'>";
        $contenidoPrincipal .= "<tr><th>Email</th><th>Id Anuncio</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            $contenidoPrincipal .= "<tr>";
            $contenidoPrincipal .= "<td>" . $fila['email'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['idAnuncio'] . "</td>";
            $contenidoPrincipal .= "</tr>";
        }
        $resultado->free();

        $contenidoPrincipal .= "</table>";
        return $contenidoPrincipal;
    }
}
