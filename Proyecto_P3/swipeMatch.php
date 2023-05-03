<?php
use es\ucm\fdi\aw\Usuario;

    require_once __DIR__ . "/includes/config.php";
    $tituloPagina = "SwipeMatch - BeatHouse";

    
    if (!isset($_SESSION['login'])) {

        $contenidoPrincipal = <<<EOS

            <div class="noPermitido">
                <p><a href="registro.php">Regístrese</a> o <a href="login.php">inicie sesión</a> para poder visualizar este contenido</p>
            </div>

        EOS;

    } else {

        $contenidoPrincipal = <<<EOS

        <div class="swipeMatch">

        <div class="descartar">
            <button id="dislike">
                <img id="icon_dislike" src="https://cdn-icons-png.flaticon.com/512/996/996724.png"/>
            </button>
        </div>
        
        <div class="containerTarjeta">
            <div class="tarjeta"> 

                <div class="anverso">
                    <img id="caratula" src="https://source.unsplash.com/random/?city,night"/>
                </div>

                <div class="reverso">
                    <h1>Titulo de la canción</h1>
                    <h2>Artista de la canción</h2>
                </div>

            </div>
        </div>

        <div class="gustar">
            <button id="like">
                <img id="icon_like" src="https://cdn-icons-png.flaticon.com/512/1175/1175578.png"/>
            </button>
        </div>

        </div>
    
        EOS;
    }

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
?>