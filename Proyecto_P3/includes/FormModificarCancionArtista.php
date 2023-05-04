<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormModificarCancionArtista extends Formulario {

    public function __construct() {
        parent::__construct('formModificarCancionArtista', ['urlRedireccion' => 'cancionesArtista.php', 'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $idCancion =$datos[0] ?? '';
        $nombreCancion = $datos[1] ?? '';
        $genero = $datos[2] ?? '';
        $nombreAlbum = $datos[3] ?? '';
        $duracion = $datos[4] ?? '';
        $rutaCancion = $datos[5] ?? '';
        $rutaImagen = $datos[6] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreCancion', 'genero', 'nombreAlbum', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar Datos Canción</h1>
                        {$htmlErroresGlobales}
                        <input type="hidden" name="idCancion" value={$idCancion} />
                        <label for= 'nombreCancion'>Nombre: </label>
                        <input type="text" placeholder="NombreCancion" id="nombreCancion" name="nombreCancion" value="{$nombreCancion}"><br>
                        {$erroresCampos['nombreCancion']}<br>

                        <label for='genero'>Género: </label>
                        <input type="text" placeholder="Genero" id="genero" name="genero" value='{$genero}'><br>
                        {$erroresCampos['genero']}<br>
        
                        <label for ='nombreAlbum'>Álbum: </label>
                        <input type ="text" placeholder =" NombreAlbum" id ="nombreAlbum" name="nombreAlbum" value= '{$nombreAlbum}'><br>
                        {$erroresCampos['nombreAlbum']}<br>

                        <input type="hidden" name="duracion" value='{$duracion}' />
                        <input type="hidden" name="rutaCancion" value='{$rutaCancion}' />
                        <input type="hidden" name="rutaImagen" value='{$rutaImagen}' />

                        <label for ='imagenCancion'>Imagen Cancion:</label>
                        <img src='{$rutaImagen}' alt="Imagen" id='imagenCancion'>
                        <br>

                        <input type="file" id="imagen" name="imagen" accept="image/*"><br>
                        {$erroresCampos['imagen']}<br>

                        <input class="BotonForm" type ="submit" value ="Aplicar Cambios" name ="aceptarModificacion"><br><br>
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
        $idCancion =$datos['idCancion'] ?? '';

        $nombreCancion = trim($datos['nombreCancion'] ?? '');
        $nombreCancion = filter_var($nombreCancion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombreCancion || empty($nombreCancion)) {
            $this->errores['nombreCancion'] = 'El nombre de la canción no es válido.';
        }

        $genero = trim($datos['genero'] ?? '');
        $genero = filter_var($genero, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$genero || empty($genero)) {
            $this->errores['genero'] = 'El género de la canción no es válido.';
        }

        $nombreAlbum = trim($datos['nombreAlbum'] ?? '');
        $nombreAlbum = filter_var($nombreAlbum, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreAlbum || empty($nombreAlbum)) {
            $this->errores['nombreAlbum'] = 'El nombre del álbum no es válido.';
        }

        $duracion = trim($datos['duracion'] ?? '');
        $rutaCancion = trim($datos['rutaCancion'] ?? '');
        $rutaImagen = trim($datos['rutaImagen'] ?? '');

        $imagen = $_FILES['imagen'] ?? '';
        $tmp_nameI = $imagen['tmp_name']?? '';
        $img_file = $imagen['name']?? '';

        if(empty($imagen) || empty($tmp_nameI) || empty($img_file)){
            $this->errores['imagen'] = 'Inserta una imagen.';
        }
        
        if (count($this->errores) === 0) {
            $nuevaRuta = "./img/music" . '/' . $img_file;
            if($nuevaRuta != $rutaImagen){ //SI es la mimsa no hago nada
                // Borra la imagen anterior solo si es diferente a la nueva ruta
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
                $rutaImagen = $nuevaRuta;
                if(move_uploaded_file($tmp_nameI, $rutaImagen)){
                }
                else{
                    $this->errores['insertar'] = 'Error al insertar la imagen o cancion';
                }
            }

            Admin::modificarCancion([$idCancion, $nombreCancion, $genero, $nombreAlbum, $duracion, $rutaCancion, $rutaImagen]);
        }
    }
}