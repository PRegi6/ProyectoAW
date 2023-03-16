<?php
    require_once __DIR__."/includes/config.php";
    $tituloPagina = "BeatHouse";
    $contenidoPrincipal = <<<EOS
        <h1>Página Principal</h1>
    EOS;

    require RAIZ_APP."/vistas/plantillas/plantilla.php";
?>