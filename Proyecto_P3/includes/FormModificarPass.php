<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormModificarPass extends Formulario {

    public function __construct() {
        parent::__construct('formModificarPass', ['urlRedireccion' => 'cambiarPerfil.php']);    
    }

    protected function generaCamposFormulario(&$datos)
    {
        $email = $datos[0] ?? '';
        $contraseña = $datos[1] ?? '';
        $nombre = $datos[2] ?? '';
        $apellidos =  $datos[3] ?? '';
        $rol = $datos[4] ?? '';
        $plan =  $datos[5] ?? '';
        $fechaExpiracion =  $datos[6] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['oldPass', 'newPass'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar contraseña</h1>
                        {$htmlErroresGlobales}

                        <input type="hidden" name="email" value="{$email}" />
                        <input type="hidden" name="nombre" value="{$nombre}" />
                        <input type="hidden" name="apellidos" value="{$apellidos}" />
                        <input type="hidden" name="rol" value="{$rol}" />
                        <input type="hidden" name="tipoPlan" value="{$plan}" />
                        <input type="hidden" name="fecha" value="{$fechaExpiracion}" />

                        <label for= 'oldPass'>Contraseña actual: </label>
                        <input type="password" placeholder="OldPass" id="oldPass" name="oldPass"><br>
                        {$erroresCampos['oldPass']}<br>

                        <label for='newPass'>Contraseña nueva: </label>
                        <input type="password" placeholder="NewPass" id="newPass" name="newPass"><br>
                        {$erroresCampos['newPass']}<br>
        
                        <input class="BotonForm" type ="submit" value ="Aplicar Cambios" name ="Aplicar"><br><br>
                </fieldset> 
            </main>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $email = $datos['email'];
        $nombre = trim($datos['nombre'] ?? '');
        $apellidos = trim($datos['apellidos'] ?? '');
        $rol = trim($datos['rol'] ?? '');
        $tipoPlan = trim($datos['tipoPlan'] ?? '');
        $fechaExpiracion = trim($datos['fecha'] ?? '');
        
        $oldPass = $datos['oldPass'];
        $usuario = Usuario::login($email, $oldPass);
        if (!$usuario) {
            $this->errores['oldPass'] = 'La contraseña no coincide.';
        }

        $newPass = trim($datos['newPass'] ?? '');
        $newPass = filter_var($newPass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$newPass || empty($newPass)) {
            $this->errores['newPass'] = 'La contraseña no es válida.';
        }

        if (count($this->errores) === 0) {
            Admin::modificarDatosPerfil([$email, $newPass, $nombre, $apellidos, $rol]);
            Admin::modificarDatosUsuario([$email, $newPass, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracion]);
        }
    }
}