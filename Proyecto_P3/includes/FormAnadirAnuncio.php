<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormAnadirAnuncio extends Formulario {

    public function __construct() {
        parent::__construct('formAnadirAnuncio', ['urlRedireccion' => 'gestionAnuncios.php', 'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['insertar', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Añadir Anuncio</h1>
                        {$htmlErroresGlobales}
                        <br>
                        
                        <label for ='imagenCancion'>Imagen del Anuncio:</label>
                        <img src='#' alt="Imagen" id='imagenCancion'>
                        <br>

                        <input type="file" id="imagen" name="imagen" accept="image/*" placeholder='Imagen'><br>
                        {$erroresCampos['imagen']}<br>

                        {$erroresCampos['insertar']}<br>
                        <input class="btn" type ="submit" value ="Añadir Anuncio" name ="Aplicar"><br><br>
                </fieldset> 
            </main>

            <script>
            const cambiarImagenInput = document.getElementById('imagen');
            const vistaPrevia  = document.getElementById('imagenCancion');

            cambiarImagenInput.addEventListener('change', () => {
                const file = cambiarImagenInput.files[0];
                console.log(file);
                const reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = () => {
                    imagenCancion.src = reader.result;
                };
            });
            </script>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $imagen = $_FILES['imagen'] ?? '';
        $tmp_nameI = $imagen['tmp_name']?? '';
        $img_file = $imagen['name']?? '';

        if(empty($imagen) || empty($tmp_nameI) || empty($img_file)){
            $this->errores['imagen'] = 'Inserta una imagen.';
        }
        
        if (count($this->errores) === 0) {
            $rutaImagen = "./img/anuncios" . '/' . $img_file;
            Anuncio::anadirAnuncio($rutaImagen, $_SESSION['email']);
            if(move_uploaded_file($tmp_nameI, $rutaImagen)){
                return true;
            }
            else{
                $this->errores['insertar'] = 'Error al insertar la imagen o cancion';
            }
        }
    }
}