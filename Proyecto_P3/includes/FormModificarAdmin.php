<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormModificarAdmin extends Formulario {

    public function __construct() {
        parent::__construct('formModificarAdmin', ['urlRedireccion' => 'gestionAdmin.php']);    }

    protected function generaCamposFormulario(&$datos)
    {
        $email = $datos[0] ?? '';
        $password = $datos[1] ?? '';
        $nombre = $datos[2] ?? '';
        $apellidos =  $datos[3] ?? '';
        $rol = $datos[4] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'apellidos'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar Datos</h1>
                        {$htmlErroresGlobales}

                        <label for= 'email'>Email: $email</label>
                        <input type="hidden" name="email" value="{$email}" />
                        <br><br>

                        <input type="hidden" name="password" value="{$password}" />

                        <label for='nombre'>Nombre: </label>
                        <input type="text" placeholder="Nombre" id="nombre" name="nombre" value='{$nombre}'><br>
                        {$erroresCampos['nombre']}<br>
        
                        <label for ='apellidos'>Apellidos: </label>
                        <input type ="text" placeholder =" Apellidos" id ="apellidos" name="apellidos" value= '{$apellidos}'><br>
                        {$erroresCampos['apellidos']}<br>

                        <input type="hidden" name="rol" value="{$rol}" />
        
                        <input class="BotonForm" type ="submit" value ="Aplicar Cambios" name ="Aplicar"><br><br>
                </fieldset> 
            </main>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $email =$datos['email'];

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombre || empty($nombre)) {
            $this->errores['nombre'] = 'El nombre no puede estar vacio.';
        }

        $apellidos = trim($datos['apellidos'] ?? '');
        $apellidos = filter_var($apellidos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $apellidos || empty($apellidos)) {
            $this->errores['apellidos'] = 'El apellido no puede ser vacio.';
        }

        $rol = trim($datos['rol'] ?? '');

        if (count($this->errores) === 0) {
            Admin::modificarDatosPerfil([$email, $password, $nombre, $apellidos, $rol]);
            Admin::modificarDatosAdmin([$email, $password, $nombre, $apellidos, $rol]);
        }
    }
}