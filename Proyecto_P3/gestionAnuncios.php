<?php
    require_once __DIR__."/includes/config.php";

    $tituloPagina = "Anuncios";
    // $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarAnuncios($_SESSION['email']);

    $idAnuncio = $_POST['idAnuncio'] ?? '';
    if(isset($_POST['borrar'])){
        es\ucm\fdi\aw\Anuncio::eliminarAnuncio($idAnuncio);
    }
    else if(isset($_POST['anadirCancion'])){


    }

    $listaAnuncios = es\ucm\fdi\aw\Anuncio::obtenerAnuncios(); 
        $contenidoPrincipal = "<div class='anuncios'>";
        foreach($listaAnuncios as $anuncio){
            $contenidoPrincipal .= "<div class='anuncio'>";
            $contenidoPrincipal .= "<img src='{$anuncio->getRutaImagen()}' class='imagen'>";
            $contenidoPrincipal .= "<form method='POST' action='gestionAnuncios.php'>";
            $contenidoPrincipal .= "<input type='hidden' name='idAnuncio' value='{$anuncio->getId()}'>";
            $contenidoPrincipal .= "<button class='eliminarAnuncio' type='submit' name='borrar'>Eliminar Anuncio</button>";
            $contenidoPrincipal .= "</form>";
            $contenidoPrincipal .= "</div>";
        }
        $contenidoPrincipal .= "<div class='anadirAnuncio'>";
        $contenidoPrincipal .= "<form method='POST' action='gestionAnuncios.php'>";
        $contenidoPrincipal .= "<button class='anadirAnuncio' type='submit' name='anadirCancion'><i class='fa fa-plus'></i></button>";
        $contenidoPrincipal .= "</form>";
        $contenidoPrincipal .= "</div>";
        $contenidoPrincipal .= "</div>";
    require RAIZ_APP."/vistas/plantillas/plantilla.php";