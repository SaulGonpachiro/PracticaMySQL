<?php

require_once "./consts.php";

class Conexion
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=" . HOST . ";port=" . PUERTO . ";dbname=" . BD . ";charset=utf8",
            USUARIO,
            CLAVE
        );
        // para que si falla una consulta salte una excepcion y la pille el catch
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
