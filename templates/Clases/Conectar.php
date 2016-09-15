<?php

if (!isset($_SESSION)) {
    session_start();
}

class Conectar {

    private $driver;
    private $host, $user, $pass, $database, $charset;
    public $con;
    var $q_id = "";
    var $ExeBit = "";
    var $db_connect_id = "";
    var $query_count = 0;

    public function __construct() {
        $db_cfg = require_once 'database.php';
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

    
    private function connect() {
        $this->db_connect_id = mysqli_connect($this->host, $this->user, $this->pass, $this->database);
        if (!$this->db_connect_id) {
//            echo (" Error no se puede conectar al servidor:" . mysqli_connect_error());
            echo (" Error no se puede conectar al servidor");
        }
    }
    
    public function close_db(){
        return mysqli_close($this->db_connect_id);
    }

    function execute($query) {
        $this->q_id = mysqli_query($this->db_connect_id, $query);
        if (!$this->q_id) {
            $error1 = mysqli_error($this->db_connect_id);
            die("ERROR: error DB.<br> No Se Puede Ejecutar La Consulta:<br> $query <br>MySql Tipo De Error: $error1");
            exit;
        }
        $this->query_count++;
        return $this->q_id;
    }

    public function fetch_row($q_id = "") {
        if ($q_id == "") {
            $q_id = $this->q_id;
        }
        $result = mysqli_fetch_array($q_id);
        return $result;
    }

    public function startFluent() {
        require_once "FluentPDO/FluentPDO.php";

        if ($this->driver == "mysql" || $this->driver == null) {
            $pdo = new PDO($this->driver . ":dbname=" . $this->database, $this->user, $this->pass);
            $fpdo = new FluentPDO($pdo);
        }

        return $fpdo;
    }

}

?>
