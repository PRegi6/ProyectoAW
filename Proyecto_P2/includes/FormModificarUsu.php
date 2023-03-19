<?php
require_once __DIR__."/config.php";
require_once __DIR__.'/Formulario.php';
require_once __DIR__ . "/Usuario.php";
require_once __DIR__ . "/Admin.php";

class FormModificarUsu extends Formulario {

    public function __construct() {
        parent::__construct('formModificarUsu', ['urlRedireccion' => 'gestionUsuarios.php']);
        $this->info = ['','','','','','',''];
    }

    protected function generaCamposFormulario(&$datos)
    {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['email', 'password', 'nombre', 'apellidos', 'fecha'], $this->errores, 'span', array('class' => 'error'));
        $valores = ['','','','','','',''];
        if(!empty($datos)){
            $valores = $datos;
        }
        $selectorPlanes = Admin::selectorPlanes($valores[5]);
        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar Datos</h1>
                        {$htmlErroresGlobales}

                        <label for= 'email'>Email: </label>
                        <input type="email" placeholder=" Email" id="email" name="email" value='{$valores[0]}'><br>
                        {$erroresCampos['email']}<br>

                        <label for= 'password'>Contraseña: </label>
                        <input type="password" placeholder=" Contraseña" id="password" name="password"><br>
                        {$erroresCampos['password']}<br>

                        <label for='nombre'>Nombre: </label>
                        <input type="text" placeholder="Nombre" id="nombre" name="nombre" value='{$valores[2]}'><br>
                        {$erroresCampos['nombre']}<br>
        
                        <label for ='apellidos'>Apellidos: </label>
                        <input type ="text" placeholder =" Apellidos" id ="apellidos" name="apellidos" value= '{$valores[3]}'><br>
                        {$erroresCampos['apellidos']}<br>

                        <label for ='rol'>Rol: </label>
                        <select name= 'rol'>
                            <option value ='usuario' selected> usuario </option>
                            <option value ='admin'> admin </option>
                        </select><br><br>

                        <label for ='tipoPlan'>Tipo Plan: </label>
                        {$selectorPlanes}<br><br>

                        <label for= 'fecha'>Fecha Expiración: </label>
                        <input type ='date' placeholder ='fechaExpiracion' id ='fecha' name ='fecha' value ='{$valores[6]}'><br>
                        {$erroresCampos['fecha']}<br>
        
                        <input class="BotonForm" type ="submit" value ="Aplicar Cambios" name ="Aplicar"><br><br>
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
        if ( ! $email || empty($email)) {
            $this->errores['email'] = 'El email no puede estar vacio';
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
        $tipoPlan = trim($datos['tipoPlan'] ?? '');

        $fechaExpiracion = trim($datos['fecha'] ?? '');
        $fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato "YYYY-MM-DD"
        if (($fechaExpiracion <= $fecha_actual)) {
            $this->errores['fecha'] = 'El fecha tiene que ser superior a la de hoy';
        }

        if (count($this->errores) === 0) {

            if($datos['rol'] == "admin"){
                Usuario::cambiaraAdmin([$email, $password, $nombre, $apellidos, $rol]);
            }
            else{
                Usuario::modificarDatosUsuario([$email, $password, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracion]);
            }
            // $usuario = Usuario::buscarCorreo($email);

            // if ($usuario) {
            //     $this->errores[] = "El correo ya esta en uso ";
            // } 
            // else {
            //     if($datos['rol'] == "admin"){
            //         Usuario::cambiaraAdmin([$email, $password, $nombre, $apellidos, $rol]);
            //     }
            //     else{
            //         Usuario::modificarDatosUsuario([$email, $password, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracion]);
            //     }
            // }
        }
    }
}