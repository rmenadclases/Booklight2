<?php
    class Modelo extends PDO {
        private static $instance = null;

        private function __construct() {
            parent::__construct('mysql:host=' . Config::$hostname . ';dbname=' . Config::$nombre . '', Config::$usuario, Config::$clave);
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            parent::exec("set names utf8");
        }

        public static function GetInstance()
        {
            if (self::$instance == null) {
                self::$instance = new self();
            }

            return self::$instance;
        }
    }
?>