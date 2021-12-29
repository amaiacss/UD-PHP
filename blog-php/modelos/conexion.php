<?php

class Conexion {

    static public function conectar() {

        $link = new PDO("mysql:host=localhost;dbname=blog-php-udemy",
                        "root",
                        "");
        // ejecutar esta configuración para no tener problemas con los caracteres latinos
        $link ->exec("set names utf8");

        return $link;
    }
}