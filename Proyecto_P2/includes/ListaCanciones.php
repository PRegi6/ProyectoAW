<?php

require_once __DIR__.'/Cancion.php';


class ListaCanciones{

    //Num de canciones en la lista
    private $numCanciones;

    //Lista de Canciones
    private $Playlist;
    private $id;
    private $nombre;
    private $email;
    private $duracion;


    public function __construct($nombre, $email, $duracion) 
    {
        $this->numCanciones = 0;
        $this->Playlist = [];
        $this->nombre = $nombre;
        $this->email = $email;
        $this->duracion = $duracion;

    }


    public static function buscarPorId($id){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones c WHERE c.idCancion='%s'", $id);
        $result = $conn->query($query);

        if(!$result){
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            $rs = $result->fetch_assoc();
            if($rs){
                $cancion = new Cancion($result['id'], $result['nombre'], 
                $result['genero'], $result['nombreAlbum'], $result['duracion'], 
                $result['rutaCancion'], $result['rutaImagen']);
            }
            $rs->free();
        }

        return $cancion;
    }


    public function añadirCancion($cancion){
        Cancion::insertaCancion($cancion);
        $this->Playlist[$this->numCanciones] = $cancion;
        $this->numCanciones++;
    }


    public static function buscarPlaylistNombre($nombre){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM playlist WHERE nombrePlaylist = '%s'", $nombre);
        $rs = $conn->query($query);
        if($rs){
            $res = $rs->fetch_assoc();
            if($res){
                $buscada = new ListaCanciones($res['nombrePlaylist'], $res['email'], $res['duracion']);
            }
            $res->free();
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $buscada;
    }


    public function buscarEnPlaylistNombre($nombre){
        
        $buscada = null;
        $enc = false;
        $i = 0;

        while(!$enc && $i < $this->numCanciones){
            if($this->Playlist[$i]->getNombre() === $nombre){
                $buscada = $this->Playlist[$i];
                $enc = true;
                /*new Cancion($this->Playlist[$i]->getNombre(),
                 $this->Playlist[$i]->getGenero(), 
                 $this->Playlist[$i]->getNombreAlbum(),
                 $this->Playlist[$i]->getDuracion(), 
                 $this->Playlist[$i]->getRutaCancion())
                $this->Playlist[$i] = */
            }
            ++$i;
        }

        return $buscada;
    }


    /*public function buscarEnPlaylistArtista($artista){
        $canciones = [];
        $cancion = null;

        for($i = 0; $i < $this->numCanciones; ++$i){
            if($this->Playlist[$i]->getEmail())
        }

        while(!$enc && $i < $this->numCanciones){
            if($this->Playlist[$i]->getNombre() === $nombre){
                $buscada = $this->Playlist[$i];
                $enc = true;
               /*new Cancion($this->Playlist[$i]->getNombre(),
                 $this->Playlist[$i]->getGenero(), 
                 $this->Playlist[$i]->getNombreAlbum(),
                 $this->Playlist[$i]->getDuracion(), 
                 $this->Playlist[$i]->getRutaCancion())
                $this->Playlist[$i] = 
            }
            ++$i;
        }

    }*/



}
