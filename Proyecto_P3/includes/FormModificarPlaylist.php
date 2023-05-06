<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormModificarPlaylist extends Formulario {

    public function __construct() {
        parent::__construct('formModificarPlaylist');
    }

    protected function generaCamposFormulario(&$datos)
    {
        $idPlaylist = $datos[0] ?? '';
        $nombrePlaylist = $datos[1] ?? '';
        $duracionPlaylist = $datos[2] ?? '';
        $cambio = $datos[2] ?? '';
        // $canciones = Playlist::mostrarCanciones($idPlaylist);

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombrePlaylist'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Modificar Nombre</h1>
                        {$htmlErroresGlobales}

                        <input type="hidden" name="idPlaylist" value="{$idPlaylist}">

                        <label for= 'nombrePlaylist'>Nuevo Nombre: </label>
                        <input type="text" id="nombreCancion" name="nombrePlaylist" placeHolder='NombrePlaylist' value="{$nombrePlaylist}"><br>
                        {$erroresCampos['nombrePlaylist']}<br>

                        <input type="hidden" name="duracionPlaylist" value="{$duracionPlaylist}">

                        <input class="btn" type ="submit" value ="Aplicar Cambios" name ="Aplicar"><br><br>
                </fieldset> 
            </main>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $idPlaylist = $datos['idPlaylist'] ?? '';
        $nombrePlaylist = trim($datos['nombrePlaylist'] ?? '');
        $nombrePlaylist = filter_var($nombrePlaylist, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombrePlaylist || empty($nombrePlaylist) || strlen($nombrePlaylist) > 16) {
            $this->errores['nombrePlaylist'] = 'El nombre de la playlist no es válido.';
        }

        $email= $datos['email'] ?? '';
        $duracionPlaylist = $datos['duracionPlaylist'] ?? '';
        
        if (count($this->errores) === 0) {
            Playlist::modificarPlaylist([$idPlaylist, $nombrePlaylist, $email, $duracionPlaylist]);
        }
    }
}