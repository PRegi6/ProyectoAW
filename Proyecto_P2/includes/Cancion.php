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




    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
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




























?>