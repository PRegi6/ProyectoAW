<?php

require_once __DIR__.'/Cancion.php';


class ListaCanciones{

    //Num de canciones en la lista
    private $numCanciones;

    //Lista de Canciones
    private $Canciones;



    public function __construct() 
    {
        $this->numCanciones = 0;
        $this->Canciones = array();
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



}
