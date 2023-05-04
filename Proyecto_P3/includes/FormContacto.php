<?php
namespace es\ucm\fdi\aw;
class FormContacto extends Formulario
{

    public function __construct()
    {
        parent::__construct('formContacto', ['action' => 'mailto:alonsr01@ucm.es', 'enctype' => 'mailto:alonsr01@ucm.es', 'urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'apellidos', 'email', 'password'], $this->errores, 'span', array('class' => 'error'));
        $html = <<<EOS
            <fieldset>
            <legend>
            <h1>Formulario de Contacto</h1>
            </legend>
            {$htmlErroresGlobales}
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre"><br><br>

            <label for="email">Dirección de Email de Contacto: </label>
            <input type="email" id="email" name="email"><br><br>
            {$erroresCampos['email']}

            <p>Motivo de la Consulta:</p>
            <input type="radio" id="evaluacion" name="motivo" value="Evaluación">
            <label for="evaluacion">Evaluación</label><br>
            <input type="radio" id="sugerencias" name="motivo" value="Sugerencias">
            <label for="sugerencias">Sugerencias</label><br>
            <input type="radio" id="criticas" name="motivo" value="Críticas">
            <label for="criticas">Críticas</label><br><br>

            <input type="checkbox" id="terminos" name="terminos">
            <label for="terminos">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del
                servicio</label><br><br>

            <label for="consulta">Consulta:</label><br>
            <textarea id="consulta" name="consulta"></textarea><br><br>

            <input type="submit" value="Enviar">
            </fieldset>
            EOS;

        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$email || empty($email)) {
            $this->errores['email'] = 'El email de contacto no puede estar vacío';
        }
    }
}