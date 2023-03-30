<?php
    require_once __DIR__."/includes/config.php";
    require_once __DIR__."/includes/Cancion.php";
    $tituloPagina = "BeatHouse";

    $contenidoPrincipal = <<<EOS
        <form class="buscador" action= "index.php" method="POST">
            <input type="text" placeholder="Buscar" name="buscador">
            <button type="submit" class="boton-buscador" name="submit">
                <i class="fa fa-search" title="buscador"></i>
            </button>
        </form>
    EOS;


    if(isset($_POST['submit'])){
        if(!empty($_POST['buscador'])){
            $ListaCanciones = Cancion::listaCanciones($_POST['buscador']);
            if(empty($ListaCanciones)){
                $contenidoPrincipal .= "No hay resultados";
            }
            else{
                $contenidoPrincipal .= "<ul class='lista-canciones'>";
                foreach($ListaCanciones as $cancion){
                    $contenidoPrincipal .= <<<EOS
                        <li >
                            <img src="{$cancion->getRutaImagen()}" alt="{$cancion->getNombre()}">
                            <div class="play">
                                <i class="fa fa-play-circle fa-5x"></i>
                            </div>
                            <div class="infoCancion">
                                <div class="nombre-genero">
                                    <h3>{$cancion->getNombre()}</h3>
                                    <p>{$cancion->getNombreAlbum()}</p>
                                </div>
                                <p>{$cancion->getGenero()}</p>
                                <p class="duracion">{$cancion->getDuracion()}</p>
                            </div>
                        </li>
                        EOS;
                    }
                $contenidoPrincipal .= "</ul>";
            }

        }
    }

    require RAIZ_APP."/vistas/plantillas/plantilla.php";