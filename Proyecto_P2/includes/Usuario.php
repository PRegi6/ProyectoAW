<?php


class Usuario
{

    public const ADMIN_ROLE = "admin";

    public const USER_ROLE = "usuario";

    
    public static function crea($datosUsuario)
    {
        $usuario = new Usuario($datosUsuario[0], self::hashPassword($datosUsuario[1]), $datosUsuario[2], $datosUsuario[3], $datosUsuario[4], $datosUsuario[5], $datosUsuario[6]);
        $usuario->insertaPerfil($usuario);
        $usuario->insertaUsuario($usuario);
        
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

    public static function modificarDatosUsuario($datos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuarios SET contraseña='%s', nombre='%s', apellidos='%s', rol='%s', tipoPlan='%s', fechaExpiracionPlan='%s' WHERE email='%s'"
        , self::hashPassword($datos[1])
        , $datos[2]
        , $datos[3]
        , $datos[4]
        , $datos[5]
        , $datos[6]
        , $datos[0]
        );
        $rs = $conn->query($query);
        if ($rs) {
            $rs->free();
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
            self::hashPassword($datos[1]),
            $datos[2],
            $datos[3],
            $datos[4]
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }

    private static function hashPassword($password)
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


    private static function esArtista($usuario){
        return $usuario->getTipoPlan() === "artista";
    }

    public function añadirCancion($cancion){
        if(esArtista($this)){

        }
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
