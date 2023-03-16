<?php
 session_start();
 // Capturo las variables username y password
 $username = htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
 $password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));
// Proceso las variables comprobando si es un usuario valido
if ($username == "user" && $password == "userpass"){
    // Establecer la variable de sesion login a true y nombre a "Usuario"
    $_SESSION["login"] = true;
    $_SESSION["nombre"] = "Usuario";
    header('Location: index.php');
	exit();
}
else if ($username == "admin" && $password == "adminpass"){
    // Establecer la variable de sesion login a true y nomnbre a "Administrador"
    // Establecer la variable esAdmin a true
    $_SESSION["login"] = true;
    $_SESSION["nombre"] = "Administrador";
    $_SESSION["esAdmin"] = true;
    header('Location: index.php');
	exit();

}else{

    echo "<h1>ERROR</h1>";
    echo "<p>El usuario o contraseña no son válidos.</p>";
	header('Location: login.php');
	exit();
}

?>

<!--<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>

<div id="contenedor">

	//require("/vistas/comun/cabecera.php");
	//require("/vistas/comun/sidebarIzq.php");

    <main> 
	<article>
        
        // Si el acceso es correcto
        /*if (isset($_SESSION["login"])){
            echo "<h1>Bienvenido " . $_SESSION["nombre"] . "</h1>";
            echo "<p>Usa el menú de la izquierda para navegar.</p>";
        }
        else{
            echo "<h1>ERROR</h1>";
            echo "<p>El usuario o contraseña no son válidos.</p>";
        }
        ?>
	</article>
</main>

	//require("vistas/comun/sidebarDer.php");
	//require("pie.php");
?>
</div>

</body>
</html>-->