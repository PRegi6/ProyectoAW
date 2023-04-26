<?php
namespace es\ucm\fdi\aw;
require_once __DIR__ . "/config.php";

class FormCrearUsuario extends Formulario
{

    public function __construct()
    {
        parent::__construct('formCrearUsuario', ['urlRedireccion' => 'gestionUsuarios.php']);
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

        $selectorPlanes = Admin::selectorPlanes('basico');

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Registro</h1>
                        {$htmlErroresGlobales}
                        <input type="text" placeholder=" Nombre" id="nombre" name="nombre" value={$nombre}><br>
                        {$erroresCampos['nombre']}<br>
        
                        <input type="text" placeholder=" Apellidos" id="apellidos" name="apellidos" value={$apellidos}><br>
                        {$erroresCampos['apellidos']}<br>
        
                        <input type="email" placeholder=" Email" id="email" name="email" value={$email}><br>
                        {$erroresCampos['email']}<br>
        
                        <input type="password" placeholder=" Contraseña" id="password" name="password" value={$password}><br>
                        {$erroresCampos['password']}<br>

                        <label for ='tipoPlan'>Tipo Plan: </label>
                        {$selectorPlanes}<br><br>
        
                        <input class="BotonForm" type="submit" value="Crear" name="crear"><br><br>
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

        $plan = trim($datos['tipoPlan'] ?? '');

        if (count($this->errores) === 0) {
            $usuario = Usuario::buscaPerfil($email);
            
            if ($usuario) {
                $this->errores[] = "El usuario ya existe";
            } else {
                $fecha_actual = date('Y-m-d');
                $nueva_fecha = date('Y-m-d', strtotime('+30 days', strtotime($fecha_actual)));
                //Como se crea 
                //$email, $password, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracionPlan
                $usuario = Usuario::crea([$email, $password, $nombre, $apellidos, Usuario::USER_ROLE, $plan, $nueva_fecha]);
            }
        }
    }
}
