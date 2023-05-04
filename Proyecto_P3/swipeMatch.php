<?php

    require_once __DIR__ . "/includes/config.php";
    $tituloPagina = "SwipeMatch - BeatHouse";

    $contenidoPrincipal = <<<EOS
        
        <!-- esto ira en el css una vez este hecho porque si ya lo pongo en el css no me carga -->
        <style>
            
            div {
                justify-content: center;
                align-items: center;
            }

            .swipeMatch {
                display: flex;
                flex-direction: row;
                justify-content: space-around;
            }

            .containerTarjeta:hover > .tarjeta {
                overflow: hidden;
                transform: rotateY(180deg);
            }
          
            .descartar {
                font-family: serif;
            }
            
            .tarjeta {
                transition: transform 1500ms;
                transform:style: preserve-3d;
            }

            .anverso {
                background-image: url(https://source.unsplash.com/random/);
            }
          
            .reverso {
                background-color: #3a3a3a;
                font-family: monospace;
                transform: rotateY(180deg);
            }
            
            .anverso,.reverso {
                height: 22rem;
                width: 18rem;
                border-radius : 2rem;
                
            }

            .gustar {
                font-family: cursive;
            }
        </style>

        <div class="swipeMatch">

        <div class="descartar">
            <button id="dislike">hola</button>
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
            <button id="like">adios</button>
        </div>

        </div>
    
    EOS;

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
?>