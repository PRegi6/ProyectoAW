<?php
namespace es\ucm\fdi\aw;
class Plan
{

    private $tipoPlan;
    private $precio;
    private $duracion;


    public static function cargarPlanes()
    {
        $conexion = Aplicacion::getInstance()->getConexionBd();
        $consulta = sprintf("SELECT tipoPlan, precio, duracionPlan FROM plandepago");
        $resultado = mysqli_query($conexion, $consulta);

        $planes = array();
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $plan = new Plan($fila['tipoPlan'], $fila['precio'], $fila['duracionPlan']);
            array_push($planes, $plan);
        }
        $resultado->free();

        return $planes;
    }

    public static function mostrarPlanes($planes, $valores)
    {
        $mostrarPlanes = <<<EOS
                <form method="POST" action="asignarPlan.php">
                <input type="hidden" name="valores" value="$valores[0], $valores[1], $valores[2], $valores[3]" />
                <div class="planes">
                EOS;

        $x = '0';
        foreach ($planes as $plan) {
            $mostrarPlanes .= "<div class='plan{$x}'>";
            $mostrarPlanes .= "<h1> Tipo Plan: {$plan->getTipoPlan()}<h1><br>";
            $mostrarPlanes .= "<h1> Precio: {$plan->getPrecio()}<h1><br>";
            $mostrarPlanes .= "<h1 name= 'duracionPlan'> Duración (días): {$plan->getDuracion()}<h1><br>";
            $mostrarPlanes .= "<input class='boton'type='submit' value='{$plan->getTipoPlan()}' name='tipoPlan'>";
            $mostrarPlanes .= "</div>";
            $x += '1';
        }
        $mostrarPlanes .= "</div>";
        $mostrarPlanes .= "</form>";
        return $mostrarPlanes;
    }

    public static function getInfoPlan($tipoPlan) {
        $conexion = Aplicacion::getInstance()->getConexionBd();
        $consulta = sprintf("SELECT tipoPlan, precio, duracionPlan FROM plandepago WHERE tipoPlan = '%s'", $tipoPlan);
        $resultado = mysqli_query($conexion, $consulta);

        while ($fila = mysqli_fetch_assoc($resultado)) {
            $plan = new Plan($fila['tipoPlan'], $fila['precio'], $fila['duracionPlan']);
        }
        $resultado->free();

        return $plan;
    }

    public static function actualizarPlan($email, $nuevoRol)
    {
        // $_SESSION['rol'] = $plan;
    }

    // Constructor de la clase Plan
    public function __construct($tipoPlan, $precio, $duracion)
    {
        $this->tipoPlan = $tipoPlan;
        $this->precio = $precio;
        $this->duracion = $duracion;
    }

    // Funciones set para los atributos de la clase Plan
    public function setTipoPlan($tipoPlan)
    {
        $this->tipoPlan = $tipoPlan;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
    }

    // Funciones get para los atributos de la clase Plan
    public function getTipoPlan()
    {
        return $this->tipoPlan;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getDuracion()
    {
        return $this->duracion;
    }
}
