<?php
require_once __DIR__ . "/includes/Usuario.php";

class Admin
{

    public function __construct()
    {
    }

    public function borrarUsuarios($email)
    {

        $user = Usuario::buscaPerfil($email);
        if ($user) {
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

    public function borrarCancion($idCancion)
    {

        $cancion = Cancion::buscaPorId($idCancion);
        if ($cancion) {
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM canciones WHERE idCancion='%s'", $idCancion);
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
}
