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
        $erroresCampos = self::generaErroresCampos(['nombre', 'apellidos', 'email', 'password'], $this->errores, 'span', array('class' => 'error'));




        $html = <<<EOS
        <main class= "panel_inicio">
            <fieldset class="fieldset_register">
                <form class="form_registro" action="procesarRegistro.php" method="post"> <!-- en vez de a procesarRegistro.php, que vaya al php de Victor para elegir el tipo de suscripcion (rol) -->
                    
                    <h1 id=titulo_panel>Login</h1>
                
                    <input type="text" placeholder=" Nombre" id="nombre" name="nombre"><br>
                    {$erroresCampos['nombre']}<br>
    
                    <input type="text" placeholder=" Apellidos" id="apellidos" name="apellidos"><br>
                    {$erroresCampos['apellidos']}<br>
    
                    <input type="email" placeholder=" Email" id="email" name="email"><br>
                    {$erroresCampos['email']}<br>
    
                    <input type="password" placeholder=" Contraseña" id="password" name="password"><br>
                    {$erroresCampos['password']}<br>
    
                    <input class="BotonForm" type="submit" value="Siguiente" name="siguiente"><br><br>
    
                    <a href="login.php"><button id="ya_registrado">¿Ya tienes una cuenta?</button></a><br>
                </form>
            </fieldset> 
        </main>
    EOS;

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
