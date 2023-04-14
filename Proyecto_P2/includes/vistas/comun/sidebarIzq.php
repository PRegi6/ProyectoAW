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
                    <li><a href='gestionPlaylist.php'>Playlist</a></li>
                    <li><a href='gestionContenido.php'>Gestion de Contenido</a></li>
                </ul>";
            }
            else {
                echo"<ul>
                    <li><a href='index.php'>Inicio</a></li>
                    <li><a href='tendencias.php'>Tendencias</a></li>
                    <li><a href='meGusta.php'>Me gusta</a></li>
                    <li><a href='gestionPlaylist.php'>Playlist</a></li>
                </ul>";
            }
        }
    
    ?>
</section>


