<?php
namespace es\ucm\fdi\aw;

class Playlist{

    private $idPlaylist;
    private $nombrePlaylist;
    private $email;
    private $duracion;
    private $listaCanciones;
    private $numCanciones;


    public function __construct($idPlaylist, $nombrePlaylist, $email, $duracion, $numCanciones, $listaCanciones) 
    {
        $this->idPlaylist = $idPlaylist;
        $this->nombrePlaylist = $nombrePlaylist;
        $this->email = $email;
        $this->duracion = $duracion;
        $this->numCanciones = $numCanciones;
        $this->listaCanciones = $listaCanciones;
    }

    public static function insertaPlaylist($datos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO playlist(nombrePlaylist, email, duracionPlaylist) VALUES ('%s', '%s', '%s')",
            $conn->real_escape_string($datos[0]),
            $conn->real_escape_string($datos[1]),
            $conn->real_escape_string(0)
        );

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function modificarPlaylist($datos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE playlist SET nombrePlaylist='%s', duracionPlaylist='%s' WHERE idPlaylist=%d"
        , $datos[1]
        , $datos[3]
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

    public static function borrarPlaylist($idPlaylist) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM playlist WHERE idPlaylist='%s'", $idPlaylist);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function mostrarCanciones($idPlaylist) {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = "SELECT canciones.* FROM canciones
                 JOIN contienen ON canciones.idCancion = contienen.idCancion
                 WHERE contienen.idPlaylist = '$idPlaylist'";
        $resultado = $conn->query($consulta);

        // Construcción dinámica de la tabla con los resultados de la consulta
        $contenidoPrincipal = "<h1>Canciones de la playlist</h1>";
        $contenidoPrincipal .= "<table border='1'>";
        $contenidoPrincipal .= "<tr><th>Nombre</th><th>Género</th><th>Albúm</th><th>Duración</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            $contenidoPrincipal .= "<tr>";
            $contenidoPrincipal .= "<td>" . $fila['nombreCancion'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['genero'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['nombreAlbum'] . "</td>";
            $contenidoPrincipal .= "<td>" . $fila['duracion'] . "</td>";
            $contenidoPrincipal .= "</tr>";
        }
        $resultado->free();

        $contenidoPrincipal .= "</table>";
        return $contenidoPrincipal;
    }

    public static function crearPlaylistMeGusta($email)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO playlist(nombrePlaylist, email, duracionPlaylist) VALUES ('%s', '%s', '%s')",
            $conn->real_escape_string("ME GUSTA"),
            $conn->real_escape_string($email),
            $conn->real_escape_string("0")
        );

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function idPlaylistMeGusta($email){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "SELECT * FROM playlist WHERE email='%s' AND nombrePlaylist='ME GUSTA'",
            $conn->real_escape_string($email)
        );

        $rs = $conn->query($query);
        if ($rs) {
            $playlist = $rs->fetch_assoc();
            return $playlist['idPlaylist'];
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return "";
    }
    
    public static function listaCancionesMeGusta($idPlaylist)
    {
        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM contienen c JOIN canciones can WHERE c.idCancion = can.idCancion AND c.idPlaylist = $idPlaylist";
        $result = $conn->query($query);

        if (!$result->num_rows > 0) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {

            foreach ($result as $rs) {
                $cancion = new Cancion(
                    $rs['idCancion'],
                    $rs['nombreCancion'],
                    $rs['genero'],
                    $rs['nombreAlbum'],
                    $rs['duracion'],
                    $rs['rutaCancion'],
                    $rs['rutaImagen']
                );
                array_push($lista, $cancion);
            }
            $result->free();
        }

        return $lista;
    }

    public function añadirCancion($idCancion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO contienen(idPlaylist, idCancion) VALUES ('%s', '%s')",
            $conn->real_escape_string(self::getIdPlaylist()),
            $conn->real_escape_string($idCancion),
        );

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        $this->numCanciones++;
    }

    private function getIdPlaylist() {
        return $this->idPlaylist;
    }

}