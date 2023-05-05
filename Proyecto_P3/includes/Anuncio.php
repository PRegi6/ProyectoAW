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

    public static function anadirAnuncio($rutaAnuncio, $email)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO anuncios(rutaAnuncio) VALUES ('%s')",
            $conn->real_escape_string($rutaAnuncio),
        );

        if ($conn->query($query)) {
            $ultimoIdInsertado = $conn->insert_id;
            $query2 = sprintf(
                "INSERT INTO gestionanuncios(email, idAnuncio) VALUES ('%s', %d)",
                $conn->real_escape_string($email),
                $conn->real_escape_string($ultimoIdInsertado),
            );
            if ($conn->query($query2)) {
                return true;
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function mostrarAnuncios(){
        $listaAnuncios = Anuncio::obtenerAnuncios(); 
        $contenidoPrincipal = "";
        $contenidoPrincipal = "<div class='anuncios'>";
        foreach($listaAnuncios as $anuncio){
            $contenidoPrincipal .= "<div class='anuncio'>";
            $contenidoPrincipal .= "<img src='{$anuncio->getRutaImagen()}' class='imagen' title='Imagen anuncio'>";
            $contenidoPrincipal .= "<form method='POST' action='gestionAnuncios.php'>";
            $contenidoPrincipal .= "<input type='hidden' name='idAnuncio' value='{$anuncio->getId()}'>";
            $contenidoPrincipal .= "<button class='btn' type='submit' name='borrar' title='Borrar anuncio'>Eliminar Anuncio</button>";
            $contenidoPrincipal .= "</form>";
            $contenidoPrincipal .= "</div>";
        }
        $contenidoPrincipal .= "<div class='anadirAnuncio'>";
        $contenidoPrincipal .= "<form method='POST' action='gestionAnuncios.php'>";
        $contenidoPrincipal .= "<button class='btn' type='submit' name='anadirAnuncio' title='Añadir anuncio'><i class='fa fa-plus'></i></button>";
        $contenidoPrincipal .= "</form>";
        $contenidoPrincipal .= "</div>";
        $contenidoPrincipal .= "</div>";
        return $contenidoPrincipal;
    }

    public function getID(){
        return $this->idAnuncio;
    }
    public function getRutaImagen(){
        return $this->rutaAnuncio;
    }

}