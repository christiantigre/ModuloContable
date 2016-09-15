<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of component_level
 *
 * @author ANDRES
 */
if (!isset($_SESSION)) {
    session_start();
}

//        $c = new mysqli('localhost', 'root', 'clave', 'condata');
class component_level {

    private $driver;
    private $host, $user, $pass, $database, $charset;
    public $con;

    public function __construct() {
        $db_cfg = require_once '../../../../Clases/database.php';
        $this->driver = $db_cfg["driver"];
        $this->host = $db_cfg["host"];
        $this->user = $db_cfg["user"];
        $this->pass = $db_cfg["pass"];
        $this->database = $db_cfg["database"];
        $this->charset = $db_cfg["charset"];
        $this->connect();
    }

    public function conexion() {

        if ($this->driver == "mysql" || $this->driver == null) {
            $con = new mysqli($this->host, $this->user, $this->pass, $this->database);
            $con->query("SET NAMES '" . $this->charset . "'");
        }

        return $con;
    }

    public function datalist_cuent($param) {
        $c = $dbi->conexion();
        $query = "SELECT * FROM `t_plan_de_cuentas` WHERE cod_cuenta='" . $param . "'";
        $resul1 = mysqli_query($c, $query);
        while ($dato1 = mysqli_fetch_array($resul1)) {
            $cod1 = $dato1['cod_cuenta'];
            echo "<option value='" . $dato1['cod_cuenta'] . "' >";
            echo $dato1['cod_cuenta'] . '      ' . utf8_decode($dato1['nombre_cuenta_plan']);
            echo '</option>';
        }mysqli_close($c);
    }

}
