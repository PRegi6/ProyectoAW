<?php
    require_once __DIR__."/includes/config.php";
    
    $tituloPagina = "Nueva playlist";
    $datos = json_decode($_POST['modificarPlaylist']);
    $form = new es\ucm\fdi\aw\FormModificarPlaylist();
    $contenidoPrincipal = $form->gestionaModificarDatos($datos);

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>