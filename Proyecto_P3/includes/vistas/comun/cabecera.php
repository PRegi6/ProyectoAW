<?php
function mostrarSaludo() {
	if (isset($_SESSION['login']) && ($_SESSION['login']===true)) {
        return "Bienvenido, " . es\ucm\fdi\aw\Usuario::opcionesUsuario();
		
	} else {
		return "<ul>
        <li><a href='registro.php'>Registro</a></li>
        <li><a href='login.php'>Iniciar Sesión</a></li>
    </ul>";
	}
}
?>


<header class="header">
        <div class="logo-titulo"> <!--logo-titulo-usuario es una clase que hace referencia al logo, al titulo y al nav de usuario-->
            <img src="<?=RUTA_IMGS?>/Altavoz2.png" alt="logo" class="logo">
            <h1>BEAT HOUSE</h1>
        </div>
        
        <div class="usuario"> <!--logo-titulo-usuario es una clase que hace referencia al logo, al titulo y al nav de usuario-->
            <!--<ul>
                <li><a href="registro.php">Registro</a></li>
                <li><a href="login.php">Iniciar Sesión</a></li>
            </ul>-->
            <?= mostrarSaludo(); ?>
        </div>
</header>