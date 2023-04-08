<?php

use Cancion as GlobalCancion;

require_once __DIR__ . "/config.php";

// Recibimos los datos enviados por la petición AJAX
$idCancion = $_POST['idCancion'] ?? '';
$idPlaylist = $_POST['idPlaylist'] ?? '';
$duracionCancion = $_POST['duracionCancion'] ?? '';
$accion = $_POST['accion'] ?? '';

// Ejecutamos la función PHP correspondiente según la acción enviada
if ($accion == "agregar-me-gusta") {
    Cancion::agregarMeGusta($idCancion, $idPlaylist);
    Cancion::anadirDuracion($idPlaylist, $duracionCancion);
} else if ($accion == "quitar-me-gusta") {
    Cancion::quitarMeGusta($idCancion, $idPlaylist);
    Cancion::quitarDuracion($idPlaylist, $duracionCancion);
}

class Cancion
{

    private $id;
    private $nombre;
    private $genero;
    private $nombreAlbum;
    private $duracion;
    private $rutaCancion;
    private $rutaImagen;

    private function __construct($id, $nombre, $genero, $nombreAlbum, $duracion, $rutaCancion, $rutaImagen)
    {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->genero = $genero;
        $this->nombreAlbum = $nombreAlbum;
        $this->duracion = $duracion;
        $this->rutaCancion = $rutaCancion;
        $this->rutaImagen = $rutaImagen;
    }


    public static function listaCanciones($cadenaCancion)
    {

        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM canciones WHERE nombreCancion LIKE '%$cadenaCancion%'";
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

    public static function listaCancionesMeGusta($email)
    {
        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM contienen c JOIN canciones can WHERE c.idCancion = can.idCancion";
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

    public static function buscarPorAlbum($nombreAlbum)
    {

        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c WHERE c.nombreAlbum='%s'", $nombreAlbum);
        $result = $conn->query($query);

        if (!$result->num_rows > 0) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {

            foreach ($result as $rs) {
                $cancion = new Cancion(
                    $rs['idCancion'],
                    $rs['nombre'],
                    $rs['genero'],
                    $rs['nombreAlbum'],
                    $rs['duracion'],
                    $rs['rutaCancion'],
                    $rs['rutaImagen']
                );
                $lista[] = $cancion;
            }

            $result->free();
        }

        return $lista;
    }


    public static function buscarPorArtista($artista)
    {

        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c JOIN subencanciones s WHERE c.idCancion = s.idCancion AND s.email = '%s", $artista->getEmail());
        $result = $conn->query($query);

        if (!$result->num_rows > 0) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {

            foreach ($result as $rs) {
                $cancion = new Cancion(
                    $rs['idCancion'],
                    $rs['nombre'],
                    $rs['genero'],
                    $rs['nombreAlbum'],
                    $rs['duracion'],
                    $rs['rutaCancion'],
                    $rs['rutaImagen']
                );
                $lista[] = $cancion;
            }

            $result->free();
        }
    }


    public static function buscarPorGenero($genero)
    {

        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c WHERE c.genero='%s'", $genero);
        $result = $conn->query($query);

        if (!$result->num_rows > 0) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {

            foreach ($result as $rs) {
                $cancion = new Cancion(
                    $rs['idCancion'],
                    $rs['nombre'],
                    $rs['genero'],
                    $rs['nombreAlbum'],
                    $rs['duracion'],
                    $rs['rutaCancion'],
                    $rs['rutaImagen']
                );
                $lista[] = $cancion;
            }

            $result->free();
        }

        return $lista;
    }

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones WHERE idCancion='%s'", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $datosUsuario = $rs->fetch_assoc();
            if ($datosUsuario) {
                $result = new Cancion(
                    $datosUsuario['idCancion'],
                    $datosUsuario['nombreCancion'],
                    $datosUsuario['genero'],
                    $datosUsuario['nombreAlbum'],
                    $datosUsuario['duracion'],
                    $datosUsuario['rutaCancion'],
                    $datosUsuario['rutaImagen']
                );
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    public static function buscarPorNombre($nombre)
    {

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c WHERE c.nombre='%s'", $nombre);
        $result = $conn->query($query);

        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            $rs = $result->fetch_assoc();
            if ($rs) {
                $cancion = new Cancion(
                    $rs['idCancion'],
                    $rs['nombre'],
                    $rs['genero'],
                    $rs['nombreAlbum'],
                    $rs['duracion'],
                    $rs['rutaCancion'],
                    $rs['rutaImagen']
                );
            }
            $rs->free();
        }

        return $cancion;
    }


    public static function insertaCancion($cancion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO canciones(nombreCancion, genero, nombreAlbum, duracion, rutaCancion, rutaImagen) VALUES ('%s', '%s', '%s', '%s','%s', '%s')",
            $conn->real_escape_string($cancion->nombre),
            $conn->real_escape_string($cancion->genero),
            $conn->real_escape_string($cancion->nombreAlbum),
            $conn->real_escape_string($cancion->duracion),
            $conn->real_escape_string($cancion->rutaCancion),
            $conn->real_escape_string($cancion->rutaImagen)
        );

        if ($conn->query($query)) {
            $cancion->id = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
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


    public static function borraCancion($nombreCancion)
    {

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM canciones WHERE nombreCancion=%d", $nombreCancion);
        $rs = $conn->query($query);
        if ($rs) {
            $rs->free();
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }


    public static function actualiza($cancion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE canciones U SET nombreCancion = '%s', genero='%s', nombreAlbum='%s', duracion='%s', rutaCancion='%s', rutaImagen='%s' WHERE U.idCancion=%d",
            $conn->real_escape_string($cancion->nombre),
            $conn->real_escape_string($cancion->genero),
            $conn->real_escape_string($cancion->nombreAlbum),
            $conn->real_escape_string($cancion->duracion),
            $conn->real_escape_string($cancion->rutaCancion),
            $conn->real_escape_string($cancion->rutaImagen),
            $cancion->id
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function mostrarCanciones($ListaCanciones)
    {
        $contenidoPrincipal = "";
        $contenidoPrincipal .= "<ul class='lista-canciones'>";
        foreach ($ListaCanciones as $cancion) {
            $datos = array(
                array(
                    'img' => $cancion->getRutaImagen(),
                    'name' => $cancion->getNombre(),
                    'artist' => $cancion->getNombreAlbum(),
                    'music' => $cancion->getRutaCancion()
                )
            );
            $minutos = gmdate("i:s", $cancion->getDuracion()); // formateamos en "MM:SS"
            $datosJson = json_encode($datos);
            $contenidoPrincipal .= <<<EOS
                <li>
                    <img src="{$cancion->getRutaImagen()}" alt="{$cancion->getNombre()}">
                    <div class="play" onclick='reproducirSeleccionado($datosJson)'>
                        <i class="fa fa-play-circle fa-5x"></i>
                    </div>
                    <div class="infoCancion">
                        <div class="nombre-genero">
                            <h3>{$cancion->getNombre()}</h3>
                            <p>{$cancion->getNombreAlbum()}</p>
                        </div>
                        <p>{$cancion->getGenero()}</p>
                        <p class="duracion">{$minutos}</p>
                    </div>
                </li>
                EOS;
        }
        $contenidoPrincipal .= "</ul>";
        return $contenidoPrincipal;
    }

    public static function mostrarCancionesTotal($ListaCanciones)
    {
        $contenidoPrincipal = "";
        $contenidoPrincipal .= "<ul class='lista-canciones'>";
        $idPlaylistMeGusta = Cancion::idPlaylistMeGusta($_SESSION['email']);
        foreach ($ListaCanciones as $cancion) {
            $datos = array(
                array(
                'img' => $cancion->getRutaImagen(),
                'name' => $cancion->getNombre(),
                'artist' => $cancion->getNombreAlbum(),
                'music' => $cancion->getRutaCancion()
                )
            );
            $minutos = gmdate("i:s", $cancion->getDuracion()); // formateamos en "MM:SS"
            $datosJson = json_encode($datos);
            $meGusta = $cancion->meGusta($idPlaylistMeGusta);
            $iconoCorazon = $meGusta ? "<i class='fa fa-heart fa-2x'></i>" : "<i class='fa fa-heart-o fa-2x'></i>";
            $contenidoPrincipal .= <<<EOS
                <li>
                    <img src="{$cancion->getRutaImagen()}" alt="{$cancion->getNombre()}">
                    <div class="play" onclick='reproducirSeleccionado($datosJson)'>
                        <i class="fa fa-play-circle fa-5x"></i>
                    </div>
                    <div class="infoCancion">
                        <div class="nombre-genero">
                            <h3>{$cancion->getNombre()}</h3>
                            <p>{$cancion->getNombreAlbum()}</p>
                        </div>
                        <p>{$cancion->getGenero()}</p>
                        <button class="boton-corazon" id="boton-corazon{$cancion->getId()}" onclick='cambiarIcono({$cancion->getId()}, {$idPlaylistMeGusta}, {$cancion->getDuracion()})'>
                            {$iconoCorazon}
                        </button>
                        <input type="hidden" id="valor{$cancion->getId()}" value="{$meGusta}" />
                        <p class="duracion">{$minutos}</p>
                    </div>
                </li>
                EOS;
        }
        $contenidoPrincipal .= "</ul>";
        return $contenidoPrincipal;
    }

    public static function  agregarMeGusta($idCancion, $idPlaylist)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO contienen(idPlaylist, idCancion) VALUES (%d, %d)",
            $conn->real_escape_string($idPlaylist),
            $conn->real_escape_string($idCancion)
        );
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function  quitarMeGusta($idCancion, $idPlaylist)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM contienen WHERE idPlaylist = %d AND idCancion = %d",
            $conn->real_escape_string($idPlaylist),
            $conn->real_escape_string($idCancion)
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

    public static function anadirDuracion($idPlaylist, $duracion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE playlist SET duracionPlaylist = duracionPlaylist + '%s' WHERE idPlaylist=%d"
            , $conn->real_escape_string($duracion)
            , $conn->real_escape_string($idPlaylist)
        );

        $rs = $conn->query($query);
        if ($rs) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return false;
    }

    public static function quitarDuracion($idPlaylist, $duracion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE playlist SET duracionPlaylist = duracionPlaylist - '%s' WHERE idPlaylist=%d"
            , $conn->real_escape_string($duracion)
            , $conn->real_escape_string($idPlaylist)
        );

        $rs = $conn->query($query);
        if ($rs) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return false;
    }

    public static function obtenerDuracionPlaylist($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "SELECT * FROM playlist WHERE idPlaylist=%d",
            $conn->real_escape_string($id)
        );

        $rs = $conn->query($query);
        if ($rs) {
            $playlist = $rs->fetch_assoc();
            return $playlist['duracionPlaylist'];
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return "";
    }

    // FUNCION PARA SABER SI UNA CANCION ME GUSTA
    public function meGusta($idPlaylist)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM contienen WHERE idPlaylist=%d AND idCancion=%d"
            , $idPlaylist
            , $this->id
        );
        $rs = $conn->query($query);
        if ($rs) {
            if($rs->fetch_assoc())
                return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return false;
    }



    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::insertaCancion($this);
    }


    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function getNombreAlbum()
    {
        return $this->nombreAlbum;
    }

    public function getDuracion()
    {
        return $this->duracion;
    }

    public function getRutaCancion()
    {
        return $this->rutaCancion;
    }

    public function getRutaImagen()
    {
        return $this->rutaImagen;
    }
}
