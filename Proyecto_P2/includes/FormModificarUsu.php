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
        $email = $datos[0] ?? '';
        $nombre = $datos[2] ?? '';
        $apellidos =  $datos[3] ?? '';
        $plan =  $datos[5] ?? '';
        $fechaExpiracion =  $datos[6] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['password', 'nombre', 'apellidos', 'fecha'], $this->errores, 'span', array('class' => 'error'));

        $selectorPlanes = Admin::selectorPlanes($plan);
        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar Datos</h1>
                        {$htmlErroresGlobales}

                        <label for= 'email'>Email: $email</label>
                        <input type="hidden" name="email" value="{$email}" />
                        <br><br>

                        <label for= 'password'>Contraseña: </label>
                        <input type="password" placeholder=" Contraseña" id="password" name="password"><br>
                        {$erroresCampos['password']}<br>

                        <label for='nombre'>Nombre: </label>
                        <input type="text" placeholder="Nombre" id="nombre" name="nombre" value='{$nombre}'><br>
                        {$erroresCampos['nombre']}<br>
        
                        <label for ='apellidos'>Apellidos: </label>
                        <input type ="text" placeholder =" Apellidos" id ="apellidos" name="apellidos" value= '{$apellidos}'><br>
                        {$erroresCampos['apellidos']}<br>

                        <label for ='rol'>Rol: </label>
                        <select name= 'rol'>
                            <option value ='usuario' selected> usuario </option>
                            <option value ='admin'> admin </option>
                        </select><br><br>

                        <label for ='tipoPlan'>Tipo Plan: </label>
                        {$selectorPlanes}<br><br>

                        <label for= 'fecha'>Fecha Expiración: </label>
                        <input type ='date' placeholder ='fechaExpiracion' id ='fecha' name ='fecha' value ='{$fechaExpiracion}'><br>
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
        $email =$datos['email'];

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
                Admin::cambiaraAdmin([$email, $password, $nombre, $apellidos, $rol]);
            }
            else{
                Admin::modificarDatosPerfil([$email, $password, $nombre, $apellidos, $rol]);
                Admin::modificarDatosUsuario([$email, $password, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracion]);
            }
        }
    }
}