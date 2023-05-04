<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Nueva playlist";
    $idPlaylist = $_POST['idPlaylist'] ?? '';
    $playlist = es\ucm\fdi\aw\Playlist::obtenerInfoPlaylist($idPlaylist);
    $form = new es\ucm\fdi\aw\FormModificarPlaylist($idPlaylist);
    $contenidoPrincipal = $form->gestionaModificarDatos([$idPlaylist, $playlist->getNombre(), $playlist->getDuracion()]);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>