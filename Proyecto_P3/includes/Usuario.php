<?php
namespace es\ucm\fdi\aw;

class Usuario
{

    public const ADMIN_ROLE = "admin";

    public const USER_ROLE = "usuario";

    
    public static function crea($datosUsuario)
    {
        $usuario = new Usuario($datosUsuario[0], self::hashPassword($datosUsuario[1]), $datosUsuario[2], $datosUsuario[3], $datosUsuario[4], $datosUsuario[5], $datosUsuario[6]);
        $usuario->insertaPerfil($usuario);
        $usuario->insertaUsuario($usuario);
        Playlist::crearPlaylistMeGusta($datosUsuario[0]);
        return $usuario;
    }
    
    public static function login($email, $password)
    {
        $usuario = self::buscaPerfil($email);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }
    
    public static function buscarCorreo($email)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM perfil WHERE email='%s'", $email);
        $rs = $conn->query($query);
        if ($rs) {
            $datosUsuario = $rs->fetch_assoc();
            if ($datosUsuario) {
                return true;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function buscaPerfil($email)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM perfil WHERE email='%s'", $email);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $datosUsuario = $rs->fetch_assoc();
            if ($datosUsuario) {
                $result = new Usuario($datosUsuario['email'], $datosUsuario['contraseña'], $datosUsuario['nombre'], $datosUsuario['apellidos'], $datosUsuario['rol'], null, null);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    public static function buscaUsuario($email)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE email='%s'", $email);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $datosUsuario = $rs->fetch_assoc();
            if ($datosUsuario) {
                $result = new Usuario($datosUsuario['email'], $datosUsuario['contraseña'], $datosUsuario['nombre'], $datosUsuario['apellidos'], $datosUsuario['rol'], $datosUsuario['tipoPlan'], $datosUsuario['fechaExpiracionPlan']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function insertaPerfil($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO perfil(email, contraseña, nombre, apellidos, rol) VALUES ('%s', '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($usuario->email),
            $conn->real_escape_string($usuario->password),
            $conn->real_escape_string($usuario->nombre),
            $conn->real_escape_string($usuario->apellidos),
            $conn->real_escape_string($usuario->rol)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }

    private static function insertaUsuario($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO usuarios(email, contraseña, nombre, apellidos, rol, tipoPlan, fechaExpiracionPlan) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($usuario->email),
            $conn->real_escape_string($usuario->password),
            $conn->real_escape_string($usuario->nombre),
            $conn->real_escape_string($usuario->apellidos),
            $conn->real_escape_string($usuario->rol),
            $conn->real_escape_string($usuario->tipoPlan),
            $conn->real_escape_string($usuario->fechaExpiracionPlan)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }

    public static function asociarCancionArtista($idCancion, $email){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO subencanciones(idCancion, email) VALUES ('%s', '%s')",
            $conn->real_escape_string($idCancion),
            $conn->real_escape_string($email)
        );

        if ($conn->query($query)) {
            $idCancion = mysqli_insert_id($conn);
            return $idCancion;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function verPlaylists($email) {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = "SELECT * FROM playlist WHERE email='$email' AND nombrePlaylist != 'ME GUSTA'";
        $resultado = $conn->query($consulta);

        // Construcción dinámica de la tabla con los resultados de la consulta
        $contenidoPrincipal = "<h1>Mis playlists</h1>";
        $contenidoPrincipal .= "<table border='1'>";
        $contenidoPrincipal .= "<tr><th>Nombre</th><th>Duración</th><th>Borrar</th><th>Modificar</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            $contenidoPrincipal .= "<tr>";
            $contenidoPrincipal .= "<td>" . $fila['nombrePlaylist'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['duracionPlaylist'] . "</td>";
            $info = [$fila['idPlaylist'], $fila['nombrePlaylist'], $fila['email'], $fila['duracionPlaylist']];
            $datos = json_encode($info);
            $contenidoPrincipal .= "<td>
                <form action='playlistUsuario.php' method='POST'>
                    <button type='submit' name='borrarPlaylist' value='{$fila['idPlaylist']}'>Borrar</button>
                </form>
            </td>";
            $contenidoPrincipal .= "<td>
                <form action='playlistUsuario.php' method='POST'>
                    <button type='submit' name='modificarPlaylist' value='{$datos}'>Editar</button>
                </form>
            </td>";          
            $contenidoPrincipal .= "</tr>";
        }
        $resultado->free();

        $contenidoPrincipal .= "</table>";
        $contenidoPrincipal .= "<form action='crearPlaylist.php' method='POST'>
                    <button type='submit' name='crearPlaylist'>Crear playlist</button>
                </form>"; 
        return $contenidoPrincipal;
    }

    public static function getDatos($email){
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = sprintf("SELECT * FROM usuarios WHERE email='%s'", $email);
        $resultado = $conn->query($consulta);

        if ($fila = $resultado->fetch_assoc()) {
            $info = [$fila['email'], $fila['contraseña'], $fila['nombre'], $fila['apellidos'], $fila['rol'], $fila['tipoPlan'], $fila['fechaExpiracionPlan']];
            $datos = json_encode($info);   
        }
        $resultado->free();

        return $datos;
    }

    public static function opcionesUsuario() {
        $opciones = <<<EOS
        <div class="dropdown">
            <button class="dropbtn">{$_SESSION['nombre']} ▼</button>
            <div class="dropdown-content">
                <a href="cambiarPerfil.php">Mis datos</a>
                <a href="cambiarPlan.php">Cambiar plan</a>
                <a href="cambiarPassUsuario.php">Cambiar contraseña</a>
                <a href='logout.php'>Cerrar sesión</a>
            </div>
        </div>
        EOS;
        return $opciones;
    }


    private $email;
    private $password;
    private $nombre;
    private $apellidos;
    private $rol;
    private $tipoPlan;
    private $fechaExpiracionPlan;

    private function __construct($email, $password, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracionPlan)
    {
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->rol = $rol;
        $this->tipoPlan = $tipoPlan;
        $this->fechaExpiracionPlan = $fechaExpiracionPlan;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getTipoPlan()
    {
        return $this->tipoPlan;
    }

    public function getFechaExpPlan()
    {
        return $this->fechaExpiracionPlan;
    }

    public function setTipoPlan($plan)
    {
        $this->tipoPlan = $plan;
    }

    public function setFechaExpPlan($fecha)
    {
        $this->fechaExpiracionPlan = $fecha;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
}
