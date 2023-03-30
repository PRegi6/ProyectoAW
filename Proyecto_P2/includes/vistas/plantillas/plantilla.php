<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
    <link id="estilo" rel="stylesheet" type="text/css" href="<?=RUTA_CSS?>/estilospoty.css">
    <link rel="stylesheet" href="<?=RUTA_CSS?>/estiloreproductor.css">
    <script src="<?=RUTA_JS?>/script.js" defer></script>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=RUTA_CSS?>/buscador.css">

</head>
<body>
    <?php 
        require(RAIZ_APP.'/vistas/comun/cabecera.php');
    ?>

    <main class= "main">
        <?php 
            require(RAIZ_APP.'/vistas/comun/sidebarIzq.php');
        ?>
    
        <section class="panelCentral">
             
            <div class="contenidoPrincipal">
                <?=$contenidoPrincipal?>
            </div>
            <?php
                if(!isset($_SESSION['login'])){
                    require(RAIZ_APP.'/vistas/comun/reproductor.php');
                }
                else{
                    if($_SESSION['rol']!= 'admin'){
                        require(RAIZ_APP.'/vistas/comun/reproductor.php');
                    }
                }
            ?>
        </section> 
    </main>
    
    <?php 
        require(RAIZ_APP.'/vistas/comun/footer.php');
    ?>
</body>
</html>