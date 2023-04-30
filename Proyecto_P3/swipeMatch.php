<?php

    require_once __DIR__ . "/includes/config.php";
    $tituloPagina = "SwipeMatch - BeatHouse";

    $contenidoPrincipal = <<<EOS
        
        <!-- esto ira en el css una vez este hecho porque si ya lo pongo en el css no me carga -->
        <style>
            
            body {
                background: linear-gradient(45deg, #061de3, #e306ca);
            }
            
            div {
                justify-content: center;
                align-items: center;
            }
            
            .swipeMatch {
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                margin-top: 1.5rem;
            }
            
            .descartar {
                font-family: serif;
            }
            
            .containerTarjeta {
                height: 22rem;
                width: 18rem;
                position: relative;
            
            }
            
            .containerTarjeta:hover > .tarjeta {
                cursor: pointer;
                overflow: hidden;
                transform: rotateY(180deg);
            }            
            
            .tarjeta {
                height: 100%;
                width: 100%;
                position: relative;
                transition: transform 1500ms;
                transform-style: preserve-3d;
                
            }
            
            .anverso {
                background-image: url(https://source.unsplash.com/random/);
            }
            
            .reverso {
                background-color: #3a3a3a;
                font-family: monospace;
                transform: rotateY(180deg);
            
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 2rem;
            }
            
            .anverso,.reverso {
                height: 22rem;
                width: 18rem;
                border-radius: 2rem;
                position: absolute;
                backface-visibility: hidden;
            }
            
            .gustar {
                font-family: cursive;
            }

            .descartar,.gustar {
                height: 5rem;
                width: 14rem;
                border-radius: 2rem;
            }

            #icon_like {
                height: 48px;
                width: 48px;
            }
            
            #icon_dislike {
                height: 40px;
                width: 40px;
            }

            #like, #dislike {
                height: 100%;
                width: 100%;
                border-radius: 2rem;
                opacity:0.3;
                background-position: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }

        </style>

        <div class="swipeMatch">

        <div class="descartar">
            <button id="dislike">
                <img id="icon_dislike" src="https://cdn-icons-png.flaticon.com/512/996/996724.png"/>
            </button>
        </div>
        
        <div class="containerTarjeta">
            <div class="tarjeta"> 

                <div class="anverso">
                    <h1>este es el frontal de la tarjeta</h1>
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

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
?>