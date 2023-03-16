<?php
 require_once __DIR__."/includes/Usuario.php";



class Admin{


    private $email;
    private $contrasena;
    private $nombre;
    private $apellidos;
    private $rol;



    private function __construct($email, $contrasena, $nombre, $apellidos, $rol)
    {
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->rol = $rol;
    }


    public function borrarUsuarios($email){
        
        $user=Usuario::buscarPorEmail($email);
        if($user){

            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM perfil WHERE email='%s'", $email);
            $rs = $conn->query($query);
            $result = false;
            if ($rs) {
                $rs->free();
                $result=true;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return $result;


        }
    }

    public function renameUsuario($email, $nombre){
        $user=Usuario::buscarPorEmail($email);
        if($user){

            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("UPDATE perfil SET nombre='%s' WHERE email='%s'", $nombre, $email);
            $rs = $conn->query($query);
            $result = false;
            if ($rs) {
                $rs->free();
                $result=true;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return $result;


        }
    }

    public function cambiarPassword($email, $nuevoPass){
        $user=Usuario::buscarPorEmail($email);
        $user->cambiarPassword($nuevoPass);
    }


















}
