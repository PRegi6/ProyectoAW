<?php

namespace es\ucm\fdi\aw;

require_once __DIR__ . "/config.php";

class Anuncio{

    private $idAnuncio;
    private $rutaAnuncio;
    public function __construct($idAnuncio, $rutaAnuncio)
    {
        $this->idAnuncio = $idAnuncio;
        $this->rutaAnuncio = $rutaAnuncio;
    }

    public static function obtenerAnuncios()
    {
        $listaAnuncios = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM anuncios";
        $result = $conn->query($query);
        if ($result) {
            foreach ($result as $rs) {
                $anuncio = new Anuncio(
                    $rs['idAnuncio'],
                    $rs['rutaAnuncio']
                );
                array_push($listaAnuncios, $anuncio);
            }
            $result->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $listaAnuncios;
    }

    public static function eliminarAnuncio($idPlaylist)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM anuncios WHERE idAnuncio= %d", $idPlaylist);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function getID(){
        return $this->idAnuncio;
    }
    public function getRutaImagen(){
        return $this->rutaAnuncio;
    }

}