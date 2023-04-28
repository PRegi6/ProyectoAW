<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormAnadirCancion extends Formulario {

    public function __construct() {
        parent::__construct('formAnadirCancion', ['urlRedireccion' => 'cancionesArtista.php', 'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombreCancion = $datos['nombreCancion'] ?? '';
        $genero = $datos['genero'] ?? '';
        $nombreAlbum = $datos['nombreAlbum'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreCancion', 'genero', 'nombreAlbum', 'duracion', 'insertar', 'cancion', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Subir Canción</h1>
                        {$htmlErroresGlobales}
                        <br>

                        <label for= 'nombreCancion'>Nombre: </label>
                        <input type="text" placeholder="NombreCancion" id="nombreCancion" name="nombreCancion" value="{$nombreCancion}"><br>
                        {$erroresCampos['nombreCancion']}<br>

                        <label for='genero'>Género: </label>
                        <input type="text" placeholder="Genero" id="genero" name="genero" value='{$genero}'><br>
                        {$erroresCampos['genero']}<br>
        
                        <label for ='nombreAlbum'>Álbum: </label>
                        <input type ="text" placeholder =" NombreAlbum" id ="nombreAlbum" name="nombreAlbum" value= '{$nombreAlbum}'><br>
                        {$erroresCampos['nombreAlbum']}<br>

                        <label for="vistaPrevia">Canción:</label>
                        <audio id="vista-previa" controls style="display:none;">
                            <source src="#" type="audio/mp3">
                        </audio><br>
                        <input type="hidden" id=duracion name="duracion" value="0" />
                        <input type="file" id="cancion" accept="audio/mp3" name="cancion"><br>
                        {$erroresCampos['cancion']}<br>
                        
                        <label for ='imagenCancion'>Imagen Cancion:</label>
                        <img src='#' alt="Imagen" id='imagenCancion'>
                        <br>

                        <input type="file" id="imagen" name="imagen" accept="image/*"><br>
                        {$erroresCampos['imagen']}<br>

                        {$erroresCampos['insertar']}<br>
                        <input class="BotonForm" type ="submit" value ="Aplicar Cambios" name ="Aplicar"><br><br>
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

            var inputCancion = document.getElementById('cancion');
            var vistaPreviaC = document.getElementById('vista-previa');
            var duracion = document.getElementById('duracion');
            var audioPlayer = document.createElement('audio');

            // Escuchar el evento de cambio en la entrada de archivo
            inputCancion.addEventListener('change', function() {
                // Obtener el archivo seleccionado
                var archivo = inputCancion.files[0];

                // Crear un objeto URL para el archivo de audio seleccionado y asignar la URL a la vista previa
                var urlCancion = URL.createObjectURL(archivo);
                vistaPreviaC.src = urlCancion;

                // Mostrar la vista previa de la canción
                vistaPreviaC.style.display = 'block';

                // Cargar el archivo de audio en el elemento audioPlayer
                audioPlayer.addEventListener('loadedmetadata', function() {
                    // Establecer la duración del archivo de audio en el campo oculto duracion
                    duracion.value = audioPlayer.duration;
                });
                audioPlayer.src = urlCancion;
            });

            </script>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

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

        $imagen = $_FILES['imagen'] ?? '';
        $tmp_nameI = $imagen['tmp_name']?? '';
        $img_file = $imagen['name']?? '';

        if(empty($imagen) || empty($tmp_nameI) || empty($img_file)){
            $this->errores['imagen'] = 'Inserta una imagen.';
        }

        $cancion = $_FILES['cancion'] ?? '';
        $tmp_name = $cancion['tmp_name'] ?? '';
        $cancion_file = $cancion['name'] ?? '';
        $duracion = $datos['duracion'] ?? '';

        if(empty($cancion) || empty($tmp_name) || empty($cancion_file)){
            $this->errores['cancion'] = 'Inserta una cancion.';
        }
        
        if (count($this->errores) === 0) {
            $rutaImagen = "./img/music" . '/' . $img_file;
            $rutaCancion = "music/" . $cancion_file;
            $idCancion = Cancion::insertaCancion([$nombreCancion, $genero, $nombreAlbum, $duracion, $rutaCancion, $rutaImagen]);
            Usuario::asociarCancionArtista($idCancion, $_SESSION['email']);
            if(move_uploaded_file($tmp_nameI, $rutaImagen) && move_uploaded_file($tmp_name, $rutaCancion)){
                return true;
            }
            else{
                $this->errores['insertar'] = 'Error al insertar la imagen o cancion';
            }
        }
    }
}