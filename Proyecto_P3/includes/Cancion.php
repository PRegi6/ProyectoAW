<?php
namespace es\ucm\fdi\aw;

require_once __DIR__ . "/config.php";


class Cancion
{

    private $id;
    private $nombre;
    private $genero;
    private $nombreAlbum;
    private $duracion;
    private $rutaCancion;
    private $rutaImagen;

    public function __construct($id, $nombre, $genero, $nombreAlbum, $duracion, $rutaCancion, $rutaImagen)
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

    public static function buscarPorArtista($email)
    {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = sprintf("SELECT * FROM canciones c JOIN subencanciones s WHERE c.idCancion = s.idCancion AND s.email = '%s", $email);
        $resultado = $conn->query($consulta);

        // Construcción dinámica de la tabla con los resultados de la consulta
        $contenidoPrincipal = "<h1>Mis canciones</h1>";
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
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO canciones(nombreCancion, genero, nombreAlbum, duracion, rutaCancion, rutaImagen) VALUES ('%s', '%s', '%s', '%s','%s', '%s')",
            $conn->real_escape_string($cancion[0]),
            $conn->real_escape_string($cancion[1]),
            $conn->real_escape_string($cancion[2]),
            $conn->real_escape_string($cancion[3]),
            $conn->real_escape_string($cancion[4]),
            $conn->real_escape_string($cancion[5])
        );

        if ($conn->query($query)) {
            $idCancion = mysqli_insert_id($conn);
            return $idCancion;
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

    public static function gestionTendencias($ListaCanciones)
    {
        $contenidoPrincipal = "";
        $contenidoPrincipal .= "<ul class='lista-canciones'>";
        $idPlaylistTendencias = 0;
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
            $tendencia = $cancion->tendencia($idPlaylistTendencias);
            $iconoTendencia = $tendencia ? "<i class='fa fa-check-square-o' aria-hidden='true'></i>" : "<i class='fa fa-square-o' aria-hidden='true'></i>";
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
                        <button class="boton-tendencia" title="Tendencia" id="boton-tendencia{$cancion->getId()}" onclick='cambiarIconoTendencia({$cancion->getId()}, {$idPlaylistTendencias}, {$cancion->getDuracion()})'>
                            {$iconoTendencia}
                        </button>
                        <input type="hidden" id="valor{$cancion->getId()}" value="{$tendencia}" />
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
        $idPlaylistMeGusta = Playlist::idPlaylistMeGusta($_SESSION['email']);
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
            $tituloBoton = $meGusta ? "Quitar de Me gusta" : "Añadir a Me gusta";
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
                        <button class="boton-corazon" title="$tituloBoton" id="boton-corazon{$cancion->getId()}" onclick='cambiarIcono({$cancion->getId()}, {$idPlaylistMeGusta}, {$cancion->getDuracion()})'>
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

    public static function mostrarCancionesArtista($email)
    {
        // Consulta SQL para obtener los datos de la tabla
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = sprintf("SELECT * FROM canciones c JOIN subencanciones s WHERE c.idCancion = s.idCancion AND s.email = '%s'", $email);
        $resultado = $conn->query($consulta);

        $contenidoPrincipal = "<h1>Mis canciones</h1>";
        if (mysqli_num_rows($resultado) > 0) {
            // Construcción dinámica de la tabla con los resultados de la consulta
            $contenidoPrincipal .= "<table border='1'>";
            $contenidoPrincipal .= "<tr><th>Nombre</th><th>Género</th><th>Álbum</th><th>Borrar</th><th>Modificar</th></tr>";
            while ($fila = $resultado->fetch_assoc()) {
                $contenidoPrincipal .= "<tr>";
                $contenidoPrincipal .= "<td>" . $fila['nombreCancion'] . "</td>";
                $contenidoPrincipal .= "<td>" . $fila['genero'] . "</td>";
                $contenidoPrincipal .= "<td>" . $fila['nombreAlbum'] . "</td>";
                $info = [$fila['idCancion'], $fila['nombreCancion'], $fila['genero'], $fila['nombreAlbum'], $fila['duracion'], $fila['rutaCancion'], $fila['rutaImagen']];
                //necesito codificar en un json debido a que un arrya no se puede pasar directamente porque da un error 
                $datos = json_encode($info);
                $contenidoPrincipal .= "<td>
                    <form action='cancionesArtista.php' method='POST'>
                        <button type='submit' name='borrarCancion' value='{$datos}'>Borrar</button>
                    </form>
                </td>";
                $contenidoPrincipal .= "<td>
                    <form action='cancionesArtista.php' method='POST'>
                        <button type='submit' name='modificarDatosCancion' value='{$datos}'>Editar</button>
                    </form>
                </td>";          
                $contenidoPrincipal .= "</tr>";
            }
            $resultado->free();
            $contenidoPrincipal .= "</table>";
        }
        else{
            $contenidoPrincipal .= "No has subido ninguna cancion.";
        }
        $contenidoPrincipal .= "<form action='anadirCancion.php' method='POST'>
                    <button type='submit' name='anadirCancion'>Añadir Cancion</button>
                </form>";
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

    public function tendencia($idPlaylist)
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
