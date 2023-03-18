<?php
require_once __DIR__."/config.php";
require_once __DIR__.'/Formulario.php';
require_once __DIR__ . "/Usuario.php";

class FormModificarUsu extends Formulario {

    public function __construct() {
        parent::__construct('formModificarUsu', ['urlRedireccion' => 'gestionUsuarios.php']);
        $this->info = ['','','','','','',''];
    }

    protected function generaCamposFormulario(&$datos)
    {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['email', 'password', 'nombre', 'apellidos', 'rol', 'tipoPlan', 'fechaE'], $this->errores, 'span', array('class' => 'error'));
        $valores = ['','','','','','',''];
        if(!empty($datos)){
            $valores = $datos;
        }
        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar Datos</h1>
                        {$htmlErroresGlobales}

                        <label for= 'email'>Email: </label>
                        <input type="email" placeholder=" Email" id="email" name="email" value= '{$valores[0]}'><br>
                        {$erroresCampos['email']}<br>

                        <label for= 'password'>Contraseña: </label>
                        <input type="password" placeholder=" Contraseña" id="password" name="password"><br>
                        {$erroresCampos['password']}<br>

                        <label for= 'nombre'>Nombre: </label>
                        <input type="text" placeholder=" Nombre" id="nombre" name="nombre" value= '{$valores[2]}'><br>
                        {$erroresCampos['nombre']}<br>
        
                        <label for= 'apellidos'>Apellidos: </label>
                        <input type="text" placeholder=" Apellidos" id="apellidos" name="apellidos" value= '{$valores[3]}'><br>
                        {$erroresCampos['apellidos']}<br>

                        <label for= 'rol'>Rol: </label>
                        <input type='text' placeholder='Rol' id='rol' name='rol' value= '{$valores[4]}'><br>
                        {$erroresCampos['rol']}<br>

                        <label for= 'tipoPlan'>Tipo Plan: </label>
                        <input type='text' placeholder='TipoPlan' id='tipoPlan' name='tipoPlan' value= '{$valores[5]}'><br>
                        {$erroresCampos['tipoPlan']}<br>

                        <label for= 'fechaE'>Fecha Expiración: </label>
                        <input type='text' placeholder='fechaExpiracion' id='fechaE' name='fechaE' value= '{$valores[6]}'><br>
                        {$erroresCampos['tipoPlan']}<br>
        
                        <input class="BotonForm" type="submit" value="Aplicar Cambios" name="Aplicar"><br><br>
                </fieldset> 
            </main>
        EOS;
        return $html;
    }
    // <input type='text' placeholder='fechaExpiracion' id='fechaExpiracion name='fechaExpiracion'><br>
    //                     {$erroresCampos['fechaExpiracion']}<br>

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $email || empty($email)) {
            $this->errores['email'] = 'El correo no puede estar vacio';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$password || mb_strlen($password) < 5 || empty($password)) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

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
        $rol = filter_var($rol, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $rol || empty($rol)) {
            $this->errores['rol'] = 'El apellido no puede ser vacio.';
        }

        $tipoPlan = trim($datos['tipoPlan'] ?? '');
        $tipoPlan = filter_var($tipoPlan, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $tipoPlan || empty($tipoPlan)) {
            $this->errores['tipoPlan'] = 'El apellido no puede ser vacio.';
        }

        $fechaExpiracion = trim($datos['fechaE'] ?? '');
        $fechaExpiracion = filter_var($fechaExpiracion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $fechaExpiracion || empty($fechaExpiracion)) {
            $this->errores['fechaE'] = 'El apellido no puede ser vacio.';
        }

        if (count($this->errores) === 0) {
            $usuario = Usuario::buscaPerfil($email);
        
            if ($usuario) {
                $this->errores[] = "El usuario ya existe";
            } 
            else {
                
            }
        }
    }
}