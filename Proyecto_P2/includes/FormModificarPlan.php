<?php
namespace es\ucm\fdi\aw;
require_once __DIR__."/config.php";

class FormModificarPlan extends Formulario {

    public function __construct() {
        parent::__construct('formModificarPlan', ['urlRedireccion' => 'gestionPlan.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $tipoPlan = $datos[0] ?? '';
        $precio = $datos[1] ?? '';
        $duracion =  $datos[2] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['tipoPlan', 'precio', 'duracion'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
            <main class= "panel_inicio">
                <fieldset class="fieldset_register">
 
                        <h1 id=titulo_panel>Cambiar Datos Planes</h1>
                        {$htmlErroresGlobales}

                        <label for= 'tipoPlan'>Tipo: $tipoPlan</label>
                        <input type="hidden" placeholder=" TipoPlan" id="tipoPlan" name="tipoPlan" value='{$tipoPlan}'><br><br>

                        <label for='precio'>Precio: </label>
                        <input type="number" placeholder="Precio" id="precio" name="precio" step="0.01" value='{$precio}'><br>
                        {$erroresCampos['precio']}<br>
        
                        <label for ='duracion'>Duración: </label>
                        <input type ="number" placeholder =" Duracion" id ="duracion" name="duracion" value= '{$duracion}'><br>
                        {$erroresCampos['duracion']}<br>
        
                        <input class="BotonForm" type ="submit" value ="Aplicar Cambios" name ="Aplicar"><br><br>
                </fieldset> 
            </main>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $tipoPlan = trim($datos['tipoPlan'] ?? '');

        $precio = trim($datos['precio'] ?? '');
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$precio || empty($precio) || !is_numeric($precio)) {
            $this->errores['precio'] = 'El precio no es válido.';
        }

        $duracion = trim($datos['duracion'] ?? '');
        $duracion = filter_var($duracion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $duracion || empty($duracion) || $duracion < 30) {
            $this->errores['duracion'] = 'La duración del plan no es válida.';
        }
        
        if (count($this->errores) === 0) {
            Admin::modificarPlanPago([$tipoPlan, $precio, $duracion]);
        }
    }
}