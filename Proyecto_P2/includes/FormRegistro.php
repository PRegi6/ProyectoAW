<?php
require_once __DIR__."/config.php";
require_once __DIR__.'/Formulario.php';
require_once __DIR__ . "/Usuario.php";

class FormRegistro extends Formulario {

    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'apellidos', 'email', 'password'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Registro</h1>
                        {$htmlErroresGlobales}
                        <input type="text" placeholder=" Nombre" id="nombre" name="nombre"><br>
                        {$erroresCampos['nombre']}<br>
        
                        <input type="text" placeholder=" Apellidos" id="apellidos" name="apellidos"><br>
                        {$erroresCampos['apellidos']}<br>
        
                        <input type="email" placeholder=" Email" id="email" name="email"><br>
                        {$erroresCampos['email']}<br>
        
                        <input type="password" placeholder=" Contraseña" id="password" name="password"><br>
                        {$erroresCampos['password']}<br>
        
                        <input class="BotonForm" type="submit" value="Siguiente" name="siguiente"><br><br>
        
                        <a href="login.php"<button id="ya_registrado">¿Ya tienes una cuenta?</button></a><br>
                </fieldset> 
            </main>
        EOS;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombre || empty($nombre)) {
            $this->errores['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
        }

        $apellidos = trim($datos['apellidos'] ?? '');
        $apellidos = filter_var($apellidos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $apellidos || empty($apellidos)) {
            $this->errores['apellidos'] = 'El apellido tiene que tener una longitud de al menos 5 caracteres.';
        }

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $email || empty($email)) {
            $this->errores['email'] = 'El correo tiene que tener una longitud de al menos 10 caracteres.';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$password || mb_strlen($password) < 5 || empty($password)) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

        if (count($this->errores) === 0) {
            $usuario = Usuario::buscaPerfil($email);
        
            if ($usuario) {
                $this->errores[] = "El usuario ya existe";
            } 
            else {
                $info = [$email, $password, $nombre, $apellidos, Usuario::USER_ROLE, "", ""];
                $info_encoded = urlencode(json_encode($info));
                header("Location: asignarPlan.php?datos=$info_encoded");
                exit();
            }
        }
    }
}