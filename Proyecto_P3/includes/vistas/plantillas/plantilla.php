<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link id="estilo" rel="stylesheet" type="text/css" href="<?=RUTA_CSS?>/estiloPagina.css">
    <link id="estilo" rel="stylesheet" type="text/css" href="<?=RUTA_CSS?>/swipe.css">
    <link rel="stylesheet" href="<?=RUTA_CSS?>/estiloreproductor.css">
    <script src="<?=RUTA_JS?>/script.js" defer></script>
    <link rel="shortcut icon" type="image/x-icon" href="<?=RUTA_IMGS?>/Altavoz2.png">  
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
                require(RAIZ_APP.'/vistas/comun/reproductor.php');
                require(RAIZ_APP.'/vistas/comun/popUp.php');
            ?>
        </section> 
    </main>
    
    <?php 
        require(RAIZ_APP.'/vistas/comun/footer.php');
    ?>
</body>
</html>