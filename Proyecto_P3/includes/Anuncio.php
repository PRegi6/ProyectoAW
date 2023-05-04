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

    public function getID(){
        return $this->idAnuncio;
    }
    public function getRutaImagen(){
        return $this->rutaAnuncio;
    }

}