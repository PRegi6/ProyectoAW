<?php
    
    require_once __DIR__ . "/includes/config.php";

    $tituloPagina = "Modificar Playlists";

    $form = new es\ucm\fdi\aw\FormModificarPlaylist();

    if (isset($_POST['borrarPlaylist'])) { //si queremos borrar una cancion
        $idPlaylist = $_POST['borrarPlaylist'] ?? '';
        es\ucm\fdi\aw\Playlist::borrarPlaylist($idPlaylist);
        header("Location: playlistUsuario.php");
    }
    else if (isset($_POST['modificarPlaylist'])) { //si queremos modificarla lo que hacemos es crear una session temporal para que guarde los datos
        $datosPlaylist = json_decode($_POST['modificarPlaylist']);
        $_SESSION['datosPlaylist'] = $datosPlaylist;
        $contenidoPrincipal = $form->gestionaModificarDatos($datosPlaylist); //generamos el formulario
    }
    else if(isset($_POST['Aplicar'])){ //Cuando le demos a Aplicar en el formulario saltara aqui y en caso de que haya errores se mostrara los datos anterior que estan guardados en la session
        $datosPlaylist = $_SESSION['datosPlaylist'];
        $contenidoPrincipal = $form->gestionaModificarDatos($datosPlaylist);
    }
    else{ //en caso de que no pulsemos ninguna muestra las canciones
        unset($_SESSION['datosPlaylist']); //Cuando acabo el formulario quito la variable de session
        $contenidoPrincipal = es\ucm\fdi\aw\Usuario::verPlaylists($_SESSION['email']);
    }
        

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
