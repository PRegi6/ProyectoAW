<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Anuncios";
    // $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarAnuncios($_SESSION['email']);
    $listaAnuncios = es\ucm\fdi\aw\Anuncio::obtenerAnuncios();
    $contenidoPrincipal = "<div class='anuncios'>";
    foreach($listaAnuncios as $anuncio){
        $contenidoPrincipal .= "<div class='anuncio'>";
        $contenidoPrincipal .= "<img src='{$anuncio->getRutaImagen()}' class='anuncio'>";
        $contenidoPrincipal .= "<form method='POST' action='gestionAnuncios.php'>";
        $contenidoPrincipal .= "<input type='hidden' name='accion' value='{$anuncio->getId()}'>";
        $contenidoPrincipal .= "<button class='eliminarAnuncio' type='submit'><i class='fa fa-times'></i></button>";
        $contenidoPrincipal .= "</form>";
        $contenidoPrincipal .= "</div>";
    }  
    $contenidoPrincipal .= "<div class='anadirAnuncio'>";
    $contenidoPrincipal .= "<form method='POST' action='gestionAnuncios.php'>";
    $contenidoPrincipal .= "<button class='eliminarAnuncio' type='submit'><i class='fa fa-plus'></i></button>";
    $contenidoPrincipal .= "</form>";
    $contenidoPrincipal .= "</div>";
    $contenidoPrincipal .= "</div>";
    require RAIZ_APP."/vistas/plantillas/plantilla.php";
