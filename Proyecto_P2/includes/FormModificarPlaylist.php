<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormModificarPlaylist extends Formulario {

    public function __construct() {
        parent::__construct('formModificarPlaylist', ['urlRedireccion' => 'gestionPlaylist.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $idPlaylist = $datos[0] ?? '';
        $nombrePlaylist = $datos[1] ?? '';
        $duracionPlaylist = $datos[3] ?? '';
        $canciones = Playlist::mostrarCanciones($idPlaylist);

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombrePlaylist'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar datos playlist</h1>
                        {$htmlErroresGlobales}

                        <label for= 'idPlaylist'>ID: $idPlaylist</label>
                        <input type="hidden" name="idPlaylist" value="{$idPlaylist}">
                        <br><br>

                        <label for= 'nombrePlaylist'>Nombre: </label>
                        <input type="text" placeholder="NombrePlaylist" id="nombreCancion" name="nombrePlaylist" value="{$nombrePlaylist}"><br>
                        {$erroresCampos['nombrePlaylist']}

                        <input type="hidden" name="duracionPlaylist" value="{$duracionPlaylist}">

                        $canciones

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
        $idPlaylist = $datos['idPlaylist'] ?? '';

        $nombrePlaylist = trim($datos['nombrePlaylist'] ?? '');
        $nombrePlaylist = filter_var($nombrePlaylist, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombrePlaylist || empty($nombrePlaylist)) {
            $this->errores['nombrePlaylist'] = 'El nombre de la playlist no es válido.';
        }

        $email= $datos['email'] ?? '';
        $duracionPlaylist = $datos['duracionPlaylist'] ?? '';
        
        if (count($this->errores) === 0) {
            Playlist::modificarPlaylist([$idPlaylist, $nombrePlaylist, $email, $duracionPlaylist]);
        }
    }
}