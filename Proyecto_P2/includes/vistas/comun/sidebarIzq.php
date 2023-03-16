<section class="panelIzquierdo">


    <?php
    
    
    
        if(!isset($_SESSION['login'])){
            echo"<ul>
                    <li><a href='.html'>Inicio</a></li>
                    <li><a href='.html'>Tendencias</a></li>
                </ul>";
            
        }
        else{
            if($_SESSION['rol']== 'admin'){
                echo"<ul>
                        <li><a href='GestionUsuarios.php'>Usuarios</a></li>
                        <li><a href='GestionCanciones.php'>Canciones</a></li>
                        <li><a href='.html'>Tendencias</a></li>
                        <li><a href='GestionPlan.php'>Gestión Plan</a></li>
                        <li><a href='.html'>Gestión de anuncios</a></li>
                    </ul>";
            }

            else {
                echo"<ul>
                    <li><a href='.html'>Inicio</a></li>
                    <li><a href='.html'>Tendencias</a></li>
                </ul>";
            }
        }
    
    ?>

    
</section>


