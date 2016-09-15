<?php

               // echo "<script>alert('.$year.')</script>";
if (isset($_POST["texto"])) {
    if ($_POST["texto"]) 
        $datey = date("Y-m-j");
        $mes = date('F');
        $year = date("Y");
    $conb = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
    mysql_select_db("condata", $conb) or die("ERROR con la base de datos");
    $B_BUSCAR = "SELECT n.`idnum_asientos`
FROM `num_asientos` n
JOIN t_ejercicio e
WHERE n.`t_ejercicio_idt_corrientes` = e.ejercicio
AND n.`t_ejercicio_idt_corrientes` = '".$_POST['texto']."'
AND n.fecha = '".$datey."'
AND n.mes = '".$mes."'
AND n.year = '".$year."'
GROUP BY `idnum_asientos`";
    $rnom = mysql_query($B_BUSCAR, $conb) or die(mysql_error());
    $f = mysql_fetch_array($rnom);
    if ($f == 0) {
        echo 'Error';
    } else {
        $idasiento = $f['idasiento'];
        //echo $idasiento;
    }
}