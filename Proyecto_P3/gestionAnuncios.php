<?php
    require_once __DIR__."/includes/config.php";

    $tituloPagina = "Anuncios";
    // $contenidoPrincipal = es\ucm\fdi\aw\Admin::mostrarAnuncios($_SESSION['email']);
    $contenidoPrincipal = "";
    $form = new es\ucm\fdi\aw\FormAnadirAnuncio();
    $idAnuncio = $_POST['idAnuncio'] ?? '';
    if(isset($_POST['borrar'])){
        es\ucm\fdi\aw\Anuncio::eliminarAnuncio($idAnuncio);
        $contenidoPrincipal = es\ucm\fdi\aw\Anuncio::mostrarAnuncios();
    }
    else if(isset($_POST['anadirAnuncio'])){
        $contenidoPrincipal = $form->gestiona();
    }
    else if(isset($_POST['Aplicar'])){
        $contenidoPrincipal = $form->gestiona();
        $contenidoPrincipal = es\ucm\fdi\aw\Anuncio::mostrarAnuncios();
    }
    else{
        $contenidoPrincipal = es\ucm\fdi\aw\Anuncio::mostrarAnuncios();
    }
    require RAIZ_APP."/vistas/plantillas/plantilla.php";