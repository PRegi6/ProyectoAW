<section class="panelIzquierdo">
    <?php
        if(!isset($_SESSION['login'])){
            echo"<ul>
                    <li><a href='index.php'>Inicio</a></li>
                    <li><a href='tendencias.php'>Tendencias</a></li>
                </ul>";  
        }
        else{
            if($_SESSION['rol']== 'admin'){
                echo"<ul>
                        <li><a href='index.php'>Inicio</a></li>
                        <li><a href='gestionUsuarios.php'>Usuarios</a></li>
                        <li><a href='gestionCanciones.php'>Canciones</a></li>
                        <li><a href='gestionTendencias.php'>Tendencias</a></li>
                        <li><a href='gestionPlan.php'>Gestión Plan</a></li>
                        <li><a href='gestionAnuncios.php'>Gestión de anuncios</a></li>
                        <li><a href='swipeMatch.php'>SwipeMatch™</a></li>
                    </ul>";
            }
            else if ($_SESSION['tipoPlan'] == 'artista'){
                echo"<ul>
                    <li><a href='index.php'>Inicio</a></li>
                    <li><a href='tendencias.php'>Tendencias</a></li>
                    <li><a href='meGusta.php'>Me gusta</a></li>
                    <li><a href='playlistUsuario.php'>Playlist</a></li>
                    <li><a href='cancionesArtista.php'>Mis canciones</a></li>
                    <li><a href='swipeMatch.php'>SwipeMatch™</a></li>
                </ul>";
            }
            else {
                echo"<ul>
                    <li><a href='index.php'>Inicio</a></li>
                    <li><a href='tendencias.php'>Tendencias</a></li>
                    <li><a href='meGusta.php'>Me gusta</a></li>
                    <li><a href='playlistUsuario.php'>Playlist</a></li>
                    <li><a href='swipeMatch.php'>SwipeMatch™</a></li>
                </ul>";
            }
        }
    
    ?>
</section>


