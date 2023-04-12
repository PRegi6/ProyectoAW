<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormModificarUsu extends Formulario {

    public function __construct() {
        parent::__construct('formModificarUsu', ['urlRedireccion' => 'gestionUsuarios.php']);    }

    protected function generaCamposFormulario(&$datos)
    {
        $email = $datos[0] ?? '';
        $nombre = $datos[2] ?? '';
        $apellidos =  $datos[3] ?? '';
        $plan =  $datos[5] ?? '';
        $fechaExpiracion =  $datos[6] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'apellidos', 'fecha'], $this->errores, 'span', array('class' => 'error'));

        $selectorPlanes = Admin::selectorPlanes($plan);
        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar Datos</h1>
                        {$htmlErroresGlobales}

                        <label for= 'email'>Email: $email</label>
                        <input type="hidden" name="email" value="{$email}" />
                        <br><br>

                        <label for='nombre'>Nombre: </label>
                        <input type="text" placeholder="Nombre" id="nombre" name="nombre" value='{$nombre}'><br>
                        {$erroresCampos['nombre']}<br>
        
                        <label for ='apellidos'>Apellidos: </label>
                        <input type ="text" placeholder =" Apellidos" id ="apellidos" name="apellidos" value= '{$apellidos}'><br>
                        {$erroresCampos['apellidos']}<br>

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
            Admin::modificarDatosPerfil([$email, $password, $nombre, $apellidos, $rol]);
            Admin::modificarDatosUsuario([$email, $password, $nombre, $apellidos, $rol, $tipoPlan, $fechaExpiracion]);
        }
    }
}