<?php

class Cancion{

    private $id;
    private $nombre;
    private $genero;
    private $nombreAlbum;
    private $duracion;
    private $rutaCancion;
    private $rutaImagen;

    private function __construct($id, $nombre, $genero, $nombreAlbum, $duracion, $rutaCancion, $rutaImagen){
        
        $this->id = $id;
        $this->nombre = $nombre;
        $this->genero = $genero;
        $this->nombreAlbum = $nombreAlbum;
        $this->duracion = $duracion;
        $this->rutaCancion = $rutaCancion;
        $this->rutaImagen = $rutaImagen;
    }


    public static function listaCanciones($cadenaCancion){

        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM canciones WHERE nombreCancion LIKE '%$cadenaCancion%'";
        $result = $conn->query($query);

        if(!$result->num_rows > 0){
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            
            foreach($result as $rs){
                $cancion = new Cancion($rs['idCancion'], $rs['nombreCancion'], 
                $rs['genero'], $rs['nombreAlbum'], $rs['duracion'], 
                $rs['rutaCancion'], $rs['rutaImagen']);
                array_push($lista, $cancion); 
            }
            $result->free();
        }

        return $lista;
    }

    public static function buscarPorAlbum($nombreAlbum){

        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c WHERE c.nombreAlbum='%s'", $nombreAlbum);
        $result = $conn->query($query);

        if(!$result->num_rows > 0){
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            
            foreach($result as $rs){
                $cancion = new Cancion($rs['idCancion'], $rs['nombre'], 
                $rs['genero'], $rs['nombreAlbum'], $rs['duracion'], 
                $rs['rutaCancion'], $rs['rutaImagen']);
                $lista[] = $cancion;
            }

            $result->free();
        }

        return $lista;
    }


    public static function buscarPorArtista($artista){

        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c JOIN subencanciones s WHERE c.idCancion = s.idCancion AND s.email = '%s", $artista->getEmail());
        $result = $conn->query($query);

        if(!$result->num_rows > 0){
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{

            foreach($result as $rs){
                $cancion = new Cancion($rs['idCancion'], $rs['nombre'], 
                $rs['genero'], $rs['nombreAlbum'], $rs['duracion'], 
                $rs['rutaCancion'], $rs['rutaImagen']);
                $lista[] = $cancion;
            }

            $result->free();
        }
    }


    public static function buscarPorGenero($genero){

        $lista = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c WHERE c.genero='%s'", $genero);
        $result = $conn->query($query);

        if(!$result->num_rows > 0){
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            
            foreach($result as $rs){
                $cancion = new Cancion($rs['idCancion'], $rs['nombre'], 
                $rs['genero'], $rs['nombreAlbum'], $rs['duracion'], 
                $rs['rutaCancion'], $rs['rutaImagen']);
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
                $result = new Cancion($datosUsuario['idCancion'], $datosUsuario['nombreCancion'], 
                $datosUsuario['genero'], $datosUsuario['nombreAlbum'], 
                $datosUsuario['duracion'], $datosUsuario['rutaCancion'], $datosUsuario['rutaImagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    public static function buscarPorNombre($nombre){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c WHERE c.nombre='%s'", $nombre);
        $result = $conn->query($query);

        if(!$result){
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            $rs = $result->fetch_assoc();
            if($rs){
                $cancion = new Cancion($rs['idCancion'], $rs['nombre'], 
                $rs['genero'], $rs['nombreAlbum'], $rs['duracion'], 
                $rs['rutaCancion'], $rs['rutaImagen']);
            }
            $rs->free();
        }

        return $cancion;
    } 


    public static function insertaCancion($cancion){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO canciones(nombreCancion, genero, nombreAlbum, duracion, rutaCancion, rutaImagen) VALUES ('%s', '%s', '%s', '%s','%s', '%s')"
        ,$conn->real_escape_string($cancion->nombre)
        , $conn->real_escape_string($cancion->genero)
        , $conn->real_escape_string($cancion->nombreAlbum)
        , $conn->real_escape_string($cancion->duracion)
        , $conn->real_escape_string($cancion->rutaCancion)
        , $conn->real_escape_string($cancion->rutaImagen)
        );

        if($conn->query($query)){
            $cancion->id = $conn->insert_id;
            $result = true;
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    public static function borraCancion($nombreCancion){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM canciones WHERE nombreCancion=%d", $nombreCancion);
        $rs = $conn->query($query);
        if($rs){
            $rs->free();
            $result = true;
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }


    public static function actualiza($cancion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE canciones U SET nombreCancion = '%s', genero='%s', nombreAlbum='%s', duracion='%s', rutaCancion='%s', rutaImagen='%s' WHERE U.idCancion=%d"
            , $conn->real_escape_string($cancion->nombre)
            , $conn->real_escape_string($cancion->genero)
            , $conn->real_escape_string($cancion->nombreAlbum)
            , $conn->real_escape_string($cancion->duracion)
            , $conn->real_escape_string($cancion->rutaCancion)
            , $conn->real_escape_string($cancion->rutaImagen)
            , $cancion->id
        );
        if ( $conn->query($query) ) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    public function guarda(){
        if($this->id !== null){
            return self::actualiza($this);
        }
        return self::insertaCancion($this);
    }

                  
    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getGenero(){
        return $this->genero;
    }

    public function getNombreAlbum(){
        return $this->nombreAlbum;
    }

    public function getDuracion(){
        return $this->duracion;
    }

    public function getRutaCancion(){
        return $this->rutaCancion;
    }

    public function getRutaImagen(){
        return $this->rutaImagen;
    }

}