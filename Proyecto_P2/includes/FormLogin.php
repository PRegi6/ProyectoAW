<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/Usuario.php';

class FormLogin extends Formulario {

    public function __construct() {
        parent::__construct('fromLogin', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['email', 'password'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <legend>Usuario y contraseña</legend>
                <div>
                    <label for="emailUsuario">Email del usuario:</label>
                    <input type="email" id= "email" name="email" value="$email" />
                    {$erroresCampos['email']}
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" />
                    {$erroresCampos['password']}
                </div>
                <div>
                    <button type="submit" name="login">Entrar</button>
                </div>
            </fieldset>
            EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$email || empty($email) ) {
            $this->errores['email'] = 'El email de usuario no puede estar vacío';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }

        if (count($this->errores) === 0) {

            $usuario = Usuario::login($email, $password);
            
            if (!$usuario) {
                $this->errores[] = "El email o el password no coinciden";
            } 
            else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombre();
                $_SESSION['esAdmin'] = $usuario->getRol();
            }
        }
    }

}
?>