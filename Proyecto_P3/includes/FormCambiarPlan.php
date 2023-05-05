<?php
namespace es\ucm\fdi\aw;
require_once __DIR__ . "/config.php";

class FormCambiarPlan extends Formulario
{

    public function __construct()
    {
        parent::__construct('formCambiarPlan', ['urlRedireccion' => 'cambiarPerfil.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $datos = json_decode($datos);
        $email = $datos[0] ?? '';
        $password = $datos[1] ?? '';
        $nombre = $datos[2] ?? '';
        $apellidos = $datos[3] ?? '';
        $rol = $datos[4] ?? '';
        $tipoPlan = $datos[5] ?? '';

        $planes = Admin::infoPlanes($tipoPlan);

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['numTarjeta', 'cvv', 'fechaCaducidad', 'planes'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar suscripción</h1>
                        {$htmlErroresGlobales}
                        
                        <input type="hidden" placeholder=" Email" id="email" name="email" value={$email}>
                        <input type="hidden" placeholder=" Contraseña" id="password" name="password" value={$password}>
                        <input type="hidden" placeholder=" Nombre" id="nombre" name="nombre" value={$nombre}>
                        <input type="hidden" placeholder=" Apellidos" id="apellidos" name="apellidos" value={$apellidos}>
                        <input type="hidden" placeholder=" Rol" id="rol" name="rol" value={$rol}>
                        <input type="hidden" placeholder=" Plan" id="plan" name="plan" value={$tipoPlan}>

                        <label for ='planes'>Selecciona un Plan: </label>
                        {$planes}
                        {$erroresCampos['planes']}<br>

                        <label for='numTarjeta'>Nombre: </label>
                        <input type="number" placeholder="NumTarjeta" id="numTarjeta" name="numTarjeta"><br>
                        {$erroresCampos['numTarjeta']}<br>

                        <label for='cvv'>Cvv: </label>
                        <input type="number" placeholder="Cvv" id="cvv" name="cvv"><br>
                        {$erroresCampos['cvv']}<br>

                        <label for='fechaCaducidad'>Fecha de caducidad (MM/AAAA): </label>
                        <input type="text" placeholder="FechaCaducidad" id="fechaCaducidad" name="fechaCaducidad"><br>
                        {$erroresCampos['fechaCaducidad']}<br>
                        

                        <input class="BotonForm" type="submit" value="Finalizar" name="finalizar"><br><br>
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
        $apellidos = trim($datos['apellidos'] ?? '');
        $apellidos = filter_var($apellidos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $rol = trim($datos['rol'] ?? '');
        $plan = trim($datos['plan'] ?? '');
        $planNuevo = trim($datos['tipoPlan'] ?? '');

        if ($plan == $planNuevo) {
            $this->errores['planes'] = 'Selecciona un plan distinto de tu actual plan.';
        }

        $numTarjeta = trim($datos['numTarjeta'] ?? '');
        $numTarjeta = filter_var($numTarjeta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!preg_match('/^\d{16}$/', $numTarjeta)) {
            $this->errores['numTarjeta'] = 'El número de tarjeta no es válido.';
        }

        $cvv = trim($datos['cvv'] ?? '');
        $cvv = filter_var($cvv, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (strlen($cvv) !== 3 && strlen($cvv) !== 4) {
            $this->errores['cvv'] = 'El CVV debe tener 3 o 4 dígitos';
        }

        $fechaCaducidad = trim($datos['fechaCaducidad'] ?? '');
        $fechaCaducidad = filter_var($fechaCaducidad, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $fechaValida = false;
        // Comprobar que la fecha tiene el formato MM/AAAA
        if (preg_match('/^\d{2}\/\d{4}$/', $fechaCaducidad)) {
            // Dividir la fecha en mes y año
            list($mes, $ano) = explode('/', $fechaCaducidad);

            // Comprobar que el mes y el año son números enteros válidos
            if (is_numeric($mes) && is_numeric($ano)) {
                $mes = (int) $mes;
                $ano = (int) $ano;

                // Comprobar que el año es mayor o igual al año actual
                if ($ano >= intval(date('Y'))) {
                    // La fecha es válida
                    $fechaValida = true;
                }
            }
        }
        if (!$fechaValida) {
            // La fecha no es válida, mostrar un mensaje de error
            $this->errores['fechaCaducidad'] = "La fecha de caducidad tiene que ser posterior a este mes y año.";
        }
    

        if (count($this->errores) === 0) {
            $fecha_actual = date('Y-m-d');
            $nueva_fecha = date('Y-m-d', strtotime('+30 days', strtotime($fecha_actual)));

            if ($plan != $planNuevo) {
                $_SESSION['tipoPlan'] = $planNuevo;
            }

            Admin::modificarDatosUsuario([$email, $password, $nombre, $apellidos, $rol, $planNuevo, $nueva_fecha]);
        }
    }
}
