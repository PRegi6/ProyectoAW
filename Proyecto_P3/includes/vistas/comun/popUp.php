<?php
use es\ucm\fdi\aw\Anuncio;

    $listaAnuncios = Anuncio::obtenerAnuncios();
    if(count($listaAnuncios) == 0){
        $rutaSeleccionado = "#";
    }
    else{
        $indice_aleatorio = array_rand($listaAnuncios);
        $rutaSeleccionado = $listaAnuncios[$indice_aleatorio]->getRutaImagen();
    }

    if(!isset($_SESSION['login'] )|| ($_SESSION['rol'] != 'admin' && $_SESSION['tipoPlan'] == 'basico')){
        echo 
        "<div class='overlay' id='overlay'>
            <div class='popup' id='popup'>
                <a id='bCerrar' class='bCerrar'>X</a>
                <img src='{$rutaSeleccionado}' alt='anuncio' class='anuncio'>";
                if(!isset($_SESSION['login'] )){
                    echo "<a href='registro.php' class='enlace'>Crear una cuenta</a>";
                }
                else{
                    echo "<a href='cambiarPlan.php' class='enlace'>Hazte Premium</a>";
                }
                echo "
            </div>
        </div>";
    }
?>