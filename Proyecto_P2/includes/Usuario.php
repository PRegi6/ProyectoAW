<?php

class Usuario
{

    public const ADMIN_ROLE = "admin";

    public const USER_ROLE = "usuario";

    public const ARTISTA_ROLE = "artista";

    public const PREMIUM_ROLE = "premium";

    public static function login($email, $password)
    {
        $usuario = self::buscaPorEmail($email);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }
    
    public static function crea($datosUsuario)
    {
        $usuario = new Usuario($datosUsuario[0], self::hashPassword($datosUsuario[1]), $datosUsuario[2], $datosUsuario[3], $datosUsuario[4], $datosUsuario[5], $datosUsuario[6]);
        $usuario->insertaPerfil($usuario);
        $usuario->insertaUsuario($usuario);

        return $usuario;
    }

    public static function buscaPorEmail($email)
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
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function insertaPerfil($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO perfil(email, contraseña, nombre, apellidos, rol) VALUES ('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->contrasena)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
            , $conn->real_escape_string($usuario->rol)
        );
        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }
   
    private static function insertaUsuario($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuarios(email, contraseña, nombre, apellidos, rol, tipoPlan, fechaExpiracionPlan) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->contrasena)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
            , $conn->real_escape_string($usuario->rol)
            , $conn->real_escape_string($usuario->tipoPlan)
            , $conn->real_escape_string($usuario->fechaExpiracionPlan)
        );
        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }
    
    private $email;
    private $contrasena;
    private $nombre;
    private $apellidos;
    private $rol;
    private $tipoPlan;
    private $fechaExpiracionPlan;

    private function __construct($email, $contrasena, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracionPlan)
    {
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->rol = $rol;
        $this->tipoPlan = $tipoPlan;
        $this->fechaExpiracionPlan = $fechaExpiracionPlan;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRol() {
        return $this->rol;
    }

    public function compruebaPassword($password)
    {
        return ($password == $this->contrasena);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->contrasena = self::hashPassword($nuevoPassword);
    }


    public function borrarUsuario($email){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("DELETE FROM usuarios WHERE usuarios.email='jrubioczo@gmail.com'"
        , $conn->real_escape_string($usuario->email));


        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }



}