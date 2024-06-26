<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormCrearAdmin extends Formulario {

    public function __construct() {
        parent::__construct('formCrearAdmin', ['urlRedireccion' => 'gestionUsuarios.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $apellidos = $datos['apellidos'] ?? '';
        $email = $datos['email'] ?? '';
        $password = $datos['password'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'apellidos', 'email', 'password'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Registro de administrador</h1>
                        {$htmlErroresGlobales}
                        <input type="text" placeholder=" Nombre" id="nombre" name="nombre" value={$nombre}><br>
                        {$erroresCampos['nombre']}<br>
        
                        <input type="text" placeholder=" Apellidos" id="apellidos" name="apellidos" value={$apellidos}><br>
                        {$erroresCampos['apellidos']}<br>
        
                        <input type="email" placeholder=" Email" id="email" name="email" value={$email}><br>
                        {$erroresCampos['email']}<br>
        
                        <input type="password" placeholder=" Contraseña" id="password" name="password" value={$password}><br>
                        {$erroresCampos['password']}<br>
        
                        <input class="btn" type="submit" value="Crear" name="Continuar"><br><br>
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
        if (!$apellidos || empty($apellidos)) {
            $this->errores['apellidos'] = 'El apellido tiene que tener una longitud de al menos 5 caracteres.';
        }

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$email || empty($email)) {
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
            } else {
                Admin::crearAdmin([$email, $password, $nombre, $apellidos, Usuario::ADMIN_ROLE]);
            }
        }
    }
}