<?php
namespace es\ucm\fdi\aw;

class Playlist{

    private $idPlaylist;
    private $nombrePlaylist;
    private $email;
    private $duracion;


    public function __construct($idPlaylist, $nombrePlaylist, $email, $duracion) 
    {
        $this->idPlaylist = $idPlaylist;
        $this->nombrePlaylist = $nombrePlaylist;
        $this->email = $email;
        $this->duracion = $duracion;
    }

    public static function convertirTiempo($segundos) {
        $horas = floor($segundos / 3600);
        $minutos = floor(($segundos - ($horas * 3600)) / 60);
        $segundos = $segundos - ($horas * 3600) - ($minutos * 60);
    
        if ($horas > 0) {
            $tiempo = $horas . "h " . $minutos . "m " . $segundos . "s";
        } else {
            $tiempo = $minutos . "m " . $segundos . "s";
        }
    
        return $tiempo;
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

    public static function playlistUsuario($email) {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = "SELECT * FROM playlist WHERE email = '$email' AND nombrePlaylist != 'ME GUSTA'";
        $resultado = $conn->query($consulta);
        $contenidoPrincipal = "";

        while ($fila = $resultado->fetch_assoc()) {
            $contenidoPrincipal .= "<div class='playlist-icono'>";
            $contenidoPrincipal .= "<div class='nombre'>";            
            $contenidoPrincipal .= "<li><a href='mostrarPlaylist.php?id={$fila['idPlaylist']}'>{$fila['nombrePlaylist']}</a></li>";
            $contenidoPrincipal .= "</div>";
            $contenidoPrincipal .= "<div class='opciones'>";
            $contenidoPrincipal .= "<form method='POST' action='crearPlaylist.php'>";
            $contenidoPrincipal .= "<input type='hidden' name='accion' value='eliminarPlaylist'>";
            $contenidoPrincipal .= "<input type='hidden' name='idPlaylist' value='{$fila['idPlaylist']}'>";
            $contenidoPrincipal .= "<button class='BotonForm' type='submit'><i class='fa fa-times'></i></button>";
            $contenidoPrincipal .= "</form>";
            $contenidoPrincipal .= "<form method='POST' action='modificarPlaylist.php'>";
            $contenidoPrincipal .= "<input type='hidden' name='idPlaylist' value='{$fila['idPlaylist']}'>";
            $contenidoPrincipal .= "<button class='BotonForm' type='submit'><i class='fa fa-pencil'></i></button>";
            $contenidoPrincipal .= "</form>";
            $contenidoPrincipal .= "</div>";
            $contenidoPrincipal .= "</div>";
        }
        $resultado->free();
        return $contenidoPrincipal;
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

    public static function mostrarPlaylist($idPlaylist, $ListaCanciones){
        $playlist = Playlist::obtenerInfoPlaylist($idPlaylist);
        $contenidoPrincipal = <<<EOS
            <div class="info-meGusta">
                <div class="tituloYPlay">
                    <h1> {$playlist->nombrePlaylist} </h1> 
        EOS;

        if (empty($ListaCanciones)) {
            $contenidoPrincipal .= <<<EOS
            </div>
            </div>
            <h1>No hay resultados</h1>
                
            EOS;
        }
        else {
            $canciones = array();
            foreach ($ListaCanciones as $cancion) {
                $info = array(
                    'img' => $cancion->getRutaImagen(),
                    'name' => $cancion->getNombre(),
                    'artist' => $cancion->getNombreAlbum(),
                    'music' => $cancion->getRutaCancion()
                );
                array_push($canciones, $info);
            }
            $numCanciones = count($canciones);
            $stringDuracion = Playlist::convertirTiempo($playlist->duracion);
            $datosJson = json_encode($canciones);
            $contenidoPrincipal .= <<<EOS
                <div class="play" onclick='reproducirSeleccionado($datosJson)'>
                    <i class="fa fa-play-circle fa-5x"></i>
                </div>
                </div>
    
                <div class="infoPlaylist">
                    <h3>Total de canciones $numCanciones</h3>
                    <h3>Tiempo aproximado {$stringDuracion}</h3>
                </div>
                </div>
            EOS;
            $contenidoPrincipal .= Cancion::mostrarCancionesTotal($ListaCanciones);
        }
        return $contenidoPrincipal;
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
    
    public static function listaCancionesPlaylist($idPlaylist)
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

    public static function obtenerInfoPlaylist($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "SELECT * FROM playlist WHERE idPlaylist=%d",
            $conn->real_escape_string($id)
        );

        $rs = $conn->query($query);
        if ($rs) {
            $playlist = $rs->fetch_assoc();
            return new Playlist($playlist['idPlaylist'], $playlist['nombrePlaylist'], $playlist['email'], $playlist['duracionPlaylist']);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return "";
    }

    public  function getIdPlaylist() {
        return $this->idPlaylist;
    }
    public function getNombre() {
        return $this->nombrePlaylist;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getDuracion() {
        return $this->duracion;
    }

    public static function borrarPlaylistMeGusta($email) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM playlist WHERE email='%s'", $email);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getPlaylistTendencias() {
        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM contienen c JOIN canciones can WHERE c.idCancion = can.idCancion AND c.idPlaylist = 0";
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
}