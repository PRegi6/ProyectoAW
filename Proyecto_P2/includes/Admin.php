<?php
require_once __DIR__ . "/Usuario.php";
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
            echo "bien";
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
        $contenidoPrincipal .= "<tr><th>Email</th><th>Contraseña</th><th>Nombre</th><th>Apellidos</th><th>Rol</th><th>Tipo Plan</th><th>Fecha Expiracion</th><th>Opcion</th></tr>";
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
            $contenidoPrincipal .= "</tr>";
        }

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
        $contenidoPrincipal .= "<tr><th>ID Cancion</th><th>Nombre</th><th>Género</th><th>Álbum</th><th>Duración</th><th>Ruta Canción</th><th>Ruta Imagen</th><th>Acciones</th></tr>";
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
            $contenidoPrincipal .= "</tr>";
        }

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
        $contenidoPrincipal .= "<tr><th>Tipo Plan</th><th>Precio</th><th>Duracion</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            $contenidoPrincipal .= "<tr>";
            $contenidoPrincipal .= "<td>" . $fila['tipoPlan'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['precio'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['duracionPlan'] . "</td>";
            $contenidoPrincipal .= "</tr>";
        }
        $contenidoPrincipal .= "</table>";
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
        $contenidoPrincipal .= "</table>";
        return $contenidoPrincipal;
    }
}
