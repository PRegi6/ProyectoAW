<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Modificar playlist";
    $idPlaylist = $_POST['idPlaylist'] ?? '';
    $contenidoPrincipal = "";
    $playlist = es\ucm\fdi\aw\Playlist::obtenerInfoPlaylist($idPlaylist);
    $form = new es\ucm\fdi\aw\FormModificarPlaylist();
    $contenidoPrincipal = $form->gestionaModificarDatos([$idPlaylist, $playlist->getNombre(), $playlist->getDuracion()]);

    if(isset($_POST['Aplicar'])){
        $contenidoPrincipal = "
        <div class='mensajeModificaciones'>
            <h1>CAMBIOS REALIZADOS CORRECTAMENTE</h1> 
        </div>";
    }

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>