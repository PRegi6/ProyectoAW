<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Modificar playlist";
    $idPlaylist = $_POST['idPlaylist'] ?? '';
    $contenidoPrincipal = "";
    $playlist = es\ucm\fdi\aw\Playlist::obtenerInfoPlaylist($idPlaylist);
    $form = new es\ucm\fdi\aw\FormModificarPlaylist();
    $contenidoPrincipal = $form->gestionaModificarDatosMensaje([$idPlaylist, $playlist->getNombre(), $playlist->getDuracion()]);
    
    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>