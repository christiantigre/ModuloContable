<?php
if (!isset($_SESSION)) {
    session_start();
}
class ClaseAdmin {

    //constructor	
    var $con;
    private $db;
    private $conectar;

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['loginu'], $_SESSION['clave'], 'condata');
        return $this->objconec;
    }
    
    function insertarAdmin($campos) {
        $conn = $this->conec_base();
        $sql="INSERT INTO `condata`.`t_clase` (`nombre_clase`, `cod_clase`, `descrip_class`) VALUES ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "');";
        if (mysqli_query($conn, $sql)) {
            return $sql;
        }mysqli_close($conn);
    }

    function insertar_planAdmin($campos) {
        $conn = $this->conec_base();
        $query = "INSERT INTO `condata`.`t_plan_de_cuentas` (
`idt_plan_de_cuentas` ,
`cod_cuenta` ,
`nombre_cuenta_plan` ,
`descripcion_cuenta_plan` ,
`t_clase_cod_clase` ,
`t_grupo_cod_grupo` ,
`t_cuenta_cod_cuenta` ,
`t_subcuenta_cod_subcuenta` ,
`t_auxiliar_cod_cauxiliar`
)
VALUES (
NULL , '" . $campos[1] . "', '" . $campos[0] . "', '" . $campos[2] . "', '" . $campos[1] . "', NULL , NULL , NULL , NULL
);";
         if (mysqli_query($conn, $query)) {
            return $query;
        }mysqli_close($conn);
    }

    

    function insertar($campos) {
        if ($this->con->conectar() == true) {
            //print_r($campos);
            //echo "INSERT INTO cliente (nombres, ciudad, sexo, telefono, fecha_nacimiento) VALUES ('".$campos[0]."', '".$campos[1]."','".$campos[2]."','".$campos[3]."','".$campos[4]."')";
            return mysql_query("INSERT INTO `condata`.`t_clase` (`nombre_clase`, `cod_clase`, `descrip_class`) VALUES ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "');");
        }mysql_close($this->con);
    }

    function actualizar($campos, $cod_clase) {
        if ($this->con->conectar() == true) {
            //print_r($campos);
            return mysql_query("UPDATE `condata`.`t_clase` SET `nombre_clase` = '" . $campos[0] . "',
`cod_clase` = '" . $campos[1] . "',
`descrip_class` = '" . $campos[2] . "' WHERE CONVERT( `t_clase`.`cod_clase` USING utf8 ) =" . $cod_clase);
        }
    }

    function mostrar_sses($cod_clase) {
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT *
FROM `t_clase`
WHERE `cod_clase` =" . $cod_clase);
        }
    }

    function mostrar_asientos() {
        $dates = date("Y-m-j");
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT bi.idt_bl_inicial AS asi, bi.fecha_balance AS fecha, ba.asiento AS asiento, ba.cod_cuenta AS cod, ba.cuenta AS cuen, ba.Ac_debe AS Deb, ba.Ac_haber AS hab
FROM blnini_activos ba
JOIN t_bl_inicial bi
WHERE ba.`t_bl_inicial_idt_bl_inicial` = bi.idt_bl_inicial
AND bi.fecha_balance = '" . $dates . "'
ORDER BY ba.asiento ASC");
        }
    }

    function eliminar($cod_clase) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `t_clase` WHERE `t_clase`.`cod_clase` = " . $cod_clase);
        }
    }

    public function mostrar_grupos_admin() {
        $query = $this->db->query("SELECT * FROM t_grupo");

        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }

        return $resultSet;
    }

}

?>