<?php

$dbhost = "localhost";
$dbname = "condata";
$dbuser = "root";
$dbpass = "alberto2791";
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if (isset($_POST) && count($_POST) > 0) {
    if ($db->connect_errno) {
        die("<span class='ko'>Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error . "</span>");
    } else {
        $query = $db->query("update t_ejercicio set " . $_POST["campo"] . "='" . $_POST["valor"] . "'"
                . " where idt_corrientes='" . intval($_POST["id"]) . "' limit 1");
        if ($query)
            echo "<span class='ok'>Valores modificados correctamente.</span>";
        else
            echo "<span class='ko'>" . $db->error . "</span>";
    }
}

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: ". mysqli_error($mysqli), E_USER_ERROR);
if($result) {
	while($row = mysqli_fetch_assoc($result)) {
		//echo $row['id'] . '<br>';	
            $maxbalancedato = $row['id'];
	}
} 

if (isset($_GET) && count($_GET) > 0) {
    if ($db->connect_errno) {
        die("<span class='ko'>Fallo al conectar a MySQL: (" . $db->connect_errno . ") "
                . $db->connect_error . "</span>");
    } else {
        $date = date("Y-m-j");
        $year = date("Y");
        $mes = date('F');
        $query = $db->query("select `idt_corrientes`,`fecha`,`ejercicio`,`cod_cuenta`,`cuenta`,`valor`,`valorp`"
                . " from t_ejercicio where t_bl_inicial_idt_bl_inicial='".$maxbalancedato."' and year='".$year."' and mes='".$mes."' ");
        $datos = array();
        while ($usuarios = $query->fetch_array()) {
            $datos[] = array("ids" => $usuarios["idt_corrientes"],
                "fecha" => $usuarios["fecha"],
                "ejercicio" => $usuarios["ejercicio"],
                "cod_cuenta" => $usuarios["cod_cuenta"],
                "cuenta" => $usuarios["cuenta"],
                "valor" => $usuarios["valor"],
                "valorp" => $usuarios["valorp"]
            );
        }
        echo json_encode($datos);
    }
}
?>