<?php 
    require_once __DIR__."/includes/config.php";

    $tituloPagina = "Contacto - BeatHouse";

    $contenidoPrincipal = <<<EOS
        <form action="https://formsubmit.co/franzroq@ucm.es" method="POST">
            <fieldset>
             <legend>
            <h1>Formulario de Contacto</h1>
            </legend>

            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre"><br><br>

            <label for="email">Dirección de Email de Contacto: </label>
            <input type="email" id="email" name="email"><br><br>

            <label for='message'>Mensaje:</label>
            <textarea name='message' id='message' cols='30' rows='5' placeholder='Mensaje'></textarea>
            <div class='form-txt'>
                <a href='#'> Politica de privacidad</a>
                <a href='#'> Terminos y politicas</a>
            </div>
            <input class='btn' type='submit' value='Enviar'>
            </fieldset>
        </form> 
    EOS;

    require RAIZ_APP."/vistas/plantillas/plantilla.php";

/*
    <input type='hidden' name='_text' value="#">
    <input type='hidden' name='_captcha' value='false'>
*/