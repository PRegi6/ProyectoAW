<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormModificarCancion extends Formulario {

    public function __construct() {
        parent::__construct('formModificarCancion', ['urlRedireccion' => 'gestionCanciones.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $idCancion = $datos[0] ?? '';
        $nombreCancion = $datos[1] ?? '';
        $genero = $datos[2] ?? '';
        $nombreAlbum = $datos[3] ?? '';
        $duracion = $datos[4] ?? '';
        $rutaCancion = $datos[5] ?? '';
        $rutaImagen = $datos[6] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreCancion', 'genero', 'nombreAlbum'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar Datos Canción</h1>
                        {$htmlErroresGlobales}

                        <label for= 'idCancion'>ID: $idCancion</label>
                        <input type="hidden" name="idCancion" value="{$idCancion}">
                        <br><br>

                        <label for= 'nombreCancion'>Nombre: </label>
                        <input type="text" placeholder="NombreCancion" id="nombreCancion" name="nombreCancion" value="{$nombreCancion}"><br>
                        {$erroresCampos['nombreCancion']}<br>

                        <label for='genero'>Género: </label>
                        <input type="text" placeholder="Genero" id="genero" name="genero" value='{$genero}'><br>
                        {$erroresCampos['genero']}<br>
        
                        <label for ='nombreAlbum'>Álbum: </label>
                        <input type ="text" placeholder =" NombreAlbum" id ="nombreAlbum" name="nombreAlbum" value= '{$nombreAlbum}'><br>
                        {$erroresCampos['nombreAlbum']}<br>

                        <label for= 'duracion'>Duración: $duracion</label>
                        <input type ='hidden' name ='duracion' value ='{$duracion}'>
                        <br><br>

                        <label for ='rutaCancion'>Ruta de la canción: $rutaCancion</label>
                        <input type ="hidden" placeholder ="rutaCancion" id ="rutaCancion" name="rutaCancion" value= '{$rutaCancion}'>
                        <br><br>

                        <label for ='rutaImagen'>Ruta de la miniatura: $rutaImagen </label>
                        <input type ="hidden" placeholder ="rutaImagen" id ="rutaImagen" name="rutaImagen" value= '{$rutaImagen}'>
                        <br><br>

                        <input class="BotonForm" type ="submit" value ="Aplicar Cambios" name ="Aplicar"><br><br>
                </fieldset> 
            </main>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $idCancion =$datos['idCancion'];

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
        if ( ! $rutaCancion || empty($rutaCancion) || ! file_exists(realpath($rutaCancion))) {
            $this->errores['rutaCancion'] = 'La ruta de la canción no es válida.';
        }

        $rutaImagen = trim($datos['rutaImagen'] ?? '');
        if ( ! $rutaImagen || empty($rutaImagen) || ! file_exists(realpath($rutaImagen))) {
            $this->errores['rutaImagen'] = 'La ruta de la minatura no es válida.';
        }
        
        if (count($this->errores) === 0) {
            Admin::modificarCancion([$idCancion, $nombreCancion, $genero, $nombreAlbum, $duracion, $rutaCancion, $rutaImagen]);
        }
    }
}