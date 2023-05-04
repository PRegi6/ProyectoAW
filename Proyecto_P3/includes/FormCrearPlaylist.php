<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormCrearPlaylist extends Formulario {

    public function __construct() {
        parent::__construct('formCrearPlaylist', ['urlRedireccion' => 'playlistUsuario.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombrePlaylist = $datos[0] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombrePlaylist'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Crear playlist nueva</h1>
                        {$htmlErroresGlobales}

                        <label for= 'nombrePlaylist'>Nombre: </label>
                        <input type="text" placeholder="NombrePlaylist" id="nombreCancion" name="nombrePlaylist" value="{$nombrePlaylist}"><br>
                        {$erroresCampos['nombrePlaylist']}<br>

                        <input class="BotonForm" type ="submit" value ="Crear playlist" name ="Aplicar"><br><br>
                </fieldset> 
            </main>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombrePlaylist = trim($datos['nombrePlaylist'] ?? '');
        $nombrePlaylist = filter_var($nombrePlaylist, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombrePlaylist || empty($nombrePlaylist)) {
            $this->errores['nombrePlaylist'] = 'El nombre de la playlist no es válido.';
        }
        
        if (count($this->errores) === 0) {
            Playlist::insertaPlaylist([$nombrePlaylist, $_SESSION['email'], 0]);
        }
    }
}