<?php
namespace es\ucm\fdi\aw;
    class Aplicacion {
        
        public static function getInstance() {
            if (!self::$instancia instanceof self) {
                return self::$instancia = new static();
            }

            return self::$instancia;
        }

        private static $instancia;
        private $inicializada;
        private $bdDatosConexion;
        private $conex;

        private function __construct(){}

        public function init($bdDatosConexion) {
            if (!$this->inicializada) {
                $this->inicializada = true;
                $this->bdDatosConexion = $bdDatosConexion;
                session_start();
            }
        }

        public function compruebaInstanciaInicializada() {
            if (!$this->inicializada) {
                echo "Aplicación no inicializada";
                exit();
            } 
        }

        public function getConexionBd() {
            $this->compruebaInstanciaInicializada();
            if (!$this->conex) {
                $host = $this->bdDatosConexion['host'];
                $bd = $this->bdDatosConexion['bd'];
                $user = $this->bdDatosConexion['user'];
                $userpass = $this->bdDatosConexion['pass'];

                $conexionbd = new \mysqli($host, $user, $userpass, $bd);

                if ($conexionbd->connect_errno) {
                    echo "Error de conexión a la BD ({$conexionbd->connect_errno}):  {$conexionbd->connect_error}";
                    exit();
                }
                if (!$conexionbd->set_charset("utf8mb4")) {
                    echo "Error al configurar la BD ({$conexionbd->errno}):  {$conexionbd->error}";
                    exit();
                }
                $this->conex = $conexionbd;
            }

            return $this->conex;
        }

        public function shutdown() {
            $this->compruebaInstanciaInicializada();
            if ($this->conex !== null && ! $this->conex->connect_errno) {
                $this->conex->close();
            }
        }
    }
