
<?php
use es\ucm\fdi\aw\Usuario;

    require_once __DIR__ . "/includes/config.php";

    // Recibimos los datos enviados por la petición AJAX
    $idCancion = $_POST['idCancion'] ?? '';
    $idPlaylist = $_POST['idPlaylist'] ?? '';
    $duracionCancion = $_POST['duracionCancion'] ?? '';
    $accion = $_POST['accion'] ?? '';

    // Ejecutamos la función PHP correspondiente según la acción enviada
    if ($accion == "agregar-cancion") {
        es\ucm\fdi\aw\Cancion::agregarCancionPlaylist($idCancion, $idPlaylist);
        es\ucm\fdi\aw\Cancion::anadirDuracion($idPlaylist, $duracionCancion);
    }

    $tituloPagina = "SwipeMatch - BeatHouse";

    $idPlay = $_POST['anadirCancion'] ?? '';

    $cancionesNoEncontradas = es\ucm\fdi\aw\Playlist::cancionesNotInPlaylist($idPlay);    
    // $listaCancionesNoPlaylist ahora contiene solo las canciones que no están en $listaCancionesPlaylist

    $infoCanciones= [];

    if(!empty($cancionesNoEncontradas)){
        foreach($cancionesNoEncontradas as $cancion){
            $nuevaCancion = array(
                    'img' => $cancion->getRutaImagen(),
                    'name' => $cancion->getNombre(),
                    'artist' => $cancion->getNombreAlbum(),
                    'music' => $cancion->getRutaCancion(),
                    'duracion' => $cancion->getDuracion(),
                    'id' => $cancion->getId()
            );
            array_push($infoCanciones, $nuevaCancion);
        }
        $jsonCanciones = json_encode($infoCanciones);
        $contenidoPrincipal = <<<EOS

        <input type='hidden' id='canciones' value='{$jsonCanciones}'>
        <input type='hidden' id='idPlaylist' value='{$idPlay}'>
        <div class="swipeMatch">

            <div class="descartar">
                <button id="dislike" title='Pasar cancion'>
                    <img id="icon_dislike" src="https://cdn-icons-png.flaticon.com/512/996/996724.png" title='Pasar cancion'/>
                </button>
            </div>
            
            <div class="containerTarjeta">
                <div class="tarjeta"> 
                    <div class="anverso">
                        <img id="caratula" src="#" title='Imagen cancion'/>
                    </div>

                    <div class="reverso">
                        <h1>Titulo de la canción</h1>
                        <h2>Artista de la canción</h2>
                        <h3>Artista de la canción</h3>
                    </div>
                </div>
            </div>

            <div class="gustar">
                <button id="like" title='Añadir a playlist'>
                    <img id="icon_like" src="https://cdn-icons-png.flaticon.com/512/1175/1175578.png" title='Añadir a playlist'/>
                </button>
            </div>

        </div>

        <script>
        // Obtener la lista de canciones desde el servidor
        const listaCanciones = JSON.parse(document.getElementById('canciones').value);
        if(listaCanciones.length != 0){

            // Obtener los elementos de la interfaz de usuario que necesitamos
            var idPlaylist = document.getElementById('idPlaylist');
            const tarjeta = document.querySelector('.tarjeta');
            const caratula = document.getElementById('caratula');
            const titulo = document.querySelector('.reverso h1');
            const artista = document.querySelector('.reverso h2');
            const texto = document.querySelector('.reverso h3');
            const botonMeGusta = document.getElementById('like');
            const botonNoMeGusta = document.getElementById('dislike');
            let cancionActual;

            // Inicializar el índice de la canción actual
            let indiceCancionActual = 0;
            // Función para cargar una canción en la tarjeta
            function cargarCancionEnTarjeta(cancion) {
                caratula.src = cancion.img;
                titulo.innerText = cancion.name;
                artista.innerText = cancion.artist;
                texto.innerText = "Pulsa los botones para agregar la cancion o no";
                cancionActual = [{"img": listaCanciones[indiceCancionActual].img ,"name": listaCanciones[indiceCancionActual].name,"music":listaCanciones[indiceCancionActual].music, "artist": listaCanciones[indiceCancionActual].artist}]
            }

            // Función para cargar la siguiente canción en la lista
            function cargarSiguienteCancion() {
                indiceCancionActual++;
                if (indiceCancionActual == listaCanciones.length) {
                    caratula.src = "./img/fin.png";
                    titulo.innerText = "FIN";
                    artista.innerText = "";
                    texto.innerText = "Pulsa cualquier boton para salir";
                    tarjeta.onclick = function() {
                    }
                } 
                else {
                    cargarCancionEnTarjeta(listaCanciones[indiceCancionActual]);
                }
            }

            tarjeta.onclick = function() {
                reproducirSeleccionado(cancionActual);
            }
            
            // Mostrar la primera canción en la tarjeta
            cargarCancionEnTarjeta(listaCanciones[indiceCancionActual]);

            // Agregar un controlador de eventos para el botón "Me gusta"
            botonMeGusta.addEventListener('click', () => {
                if (indiceCancionActual < listaCanciones.length){
                    anadirCancionPlaylist(listaCanciones[indiceCancionActual].id, idPlaylist.value, listaCanciones[indiceCancionActual].duracion);    
                    cargarSiguienteCancion();
                }
            });

            // Agregar un controlador de eventos para el botón "No me gusta"
            botonNoMeGusta.addEventListener('click', () => {
                if (indiceCancionActual < listaCanciones.length){
                    cargarSiguienteCancion();
                }
            });
            
        }
        </script>
    
        EOS;
    }
    else{
        $contenidoPrincipal = "<div class= 'swipe'>
            <h1>No hay canciones para el swipe</h1>
        </div>";
    }

    require RAIZ_APP . "/vistas/plantillas/plantilla.php";
?>