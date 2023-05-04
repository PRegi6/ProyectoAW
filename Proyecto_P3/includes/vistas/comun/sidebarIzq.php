<section class="panelIzquierdo">
    <?php
    use es\ucm\fdi\aw\Playlist;

        if(!isset($_SESSION['login'])){
            $email = "";
            echo"<ul>
                    <li><a href='index.php'>Inicio</a></li>
                    <li><a href='tendencias.php'>Tendencias</a></li>
                </ul>";  
        }
        else{
            $email = $_SESSION['email'];
            $playlistUsuario = Playlist::playlistUsuario($email);
            if($_SESSION['rol']== 'admin'){
                echo"<ul>
                        <li><a href='index.php'>Inicio</a></li>
                        <li><a href='gestionUsuarios.php'>Usuarios</a></li>
                        <li><a href='gestionCanciones.php'>Canciones</a></li>
                        <li><a href='gestionTendencias.php'>Tendencias</a></li>
                        <li><a href='gestionPlan.php'>Gestión Plan</a></li>
                        <li><a href='gestionAnuncios.php'>Gestión de anuncios</a></li>
                    </ul>";
            }

            else if ($_SESSION['tipoPlan'] == 'artista'){
                echo"<ul>
                    <li><a href='index.php'>Inicio</a></li>
                    <li><a href='tendencias.php'>Tendencias</a></li>
                    <li><a href='meGusta.php'>Me gusta</a></li>
                    <li><a href='cancionesArtista.php'>Mis canciones</a></li>
                    <li id='crearPlaylist'><a>Crear Playlist</a></li>
                    <li id='lineaSeparacion'></li>
                        <div class ='playlist'>
                            {$playlistUsuario}
                        </div>
                    </ul>";
            }
            else {
                echo"<ul>
                    <li><a href='index.php'>Inicio</a></li>
                    <li><a href='tendencias.php'>Tendencias</a></li>
                    <li><a href='meGusta.php'>Me gusta</a></li>
                    <li id='crearPlaylist'><a>Crear Playlist</a></li>
                    <li id='lineaSeparacion'></li>
                        <div class ='playlist'>
                            {$playlistUsuario}
                        </div>
                    </ul>";
            }
        }
    
    ?>
</section>

<script>

const crearPlaylistLink = document.getElementById('crearPlaylist');
const playlistDiv = document.querySelector('.playlist');

if (crearPlaylistLink != null) {
    crearPlaylistLink.addEventListener('click', function() {
    var  email = "<?php echo $email?>";
    var nombre = "Nueva Playlist";
    const nuevaPlaylist = document.createElement('li');
    nuevaPlaylist.innerHTML = '<a href="mostrarPlaylist">' + nombre + '</a>';
    playlistDiv.appendChild(nuevaPlaylist);

    // hacer la petición AJAX
    const rutaDirectorio = window.location.pathname.split('/').slice(0, -1).join('/');
    const url = rutaDirectorio + '/crearPlaylist.php';
    console.log(rutaDirectorio); // "/ruta/al/directorio"
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // aquí puedes hacer algo si la petición fue exitosa
        } else {
            console.log("ERROR");
            // aquí puedes manejar errores si la petición falló
        }
    };
    xhr.send(`email=${email}&nombre=${nombre}&accion=crearPlaylist`);
    location.reload();
});
}

</script>

