<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?= $tituloPagina ?></title>
        <link rel="stylesheet" href="./css/estiloPanelInicio.css">
        <script src="./jscript/script.js" defer></script>
        <link rel="shortcut icon" href='<?=RUTA_IMGS?>/Altavoz2.png' type="image/x-icon">
    </head>
    
    <body>
        <?php
            require(RAIZ_APP.'/vistas/comun/cabIni.php');
        ?>

        <section class="panelCentral">
             <div class="contenidoPrincipal">
                 <?=$contenidoPrincipal?>
             </div>
         </section>
    </body>
</html>
