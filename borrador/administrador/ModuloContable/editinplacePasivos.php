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

if (isset($_GET) && count($_GET) > 0) {
    if ($db->connect_errno) {
        die("<span class='ko'>Fallo al conectar a MySQL: (" . $db->connect_errno . ") "
                . $db->connect_error . "</span>");
    } else {
        $date = date("Y-m-j");
        $query = $db->query("select `idt_corrientes`,`fecha`,`ejercicio`,`cod_cuenta`,`cuenta`,`valorp`"
                . " from t_ejercicio where fecha= '".$date."' and tipo='3'");
        $datos = array();
        while ($usuarios = $query->fetch_array()) {
            $datos[] = array("ids" => $usuarios["idt_corrientes"],
                "ejercicio" => $usuarios["ejercicio"],
                "cod_cuenta" => $usuarios["cod_cuenta"],
                "cuenta" => $usuarios["cuenta"],
                "fecha" => $usuarios["fecha"],
                "valorp" => $usuarios["valorp"]
            );
        }
        echo json_encode($datos);
    }
}
?>