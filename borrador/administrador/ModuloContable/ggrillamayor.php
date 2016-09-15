<?php
$data = array_filter($_POST);
echo '<pre>';
$cone_tpdh = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
mysql_select_db("condata", $cone_tpdh) or die("ERROR con la base de datos");  
print_r($data);
$serdat=serialize($data);
foreach ($data as $row) {
$sql_insertmayor = "INSERT INTO condata.t_mayor (fecha,cod_cuenta,cuenta,deb,hab,saldodeudor,saldoacreedor,t_bl_inicial_idt_bl_inicial)
        VALUES (
           '".$row[0]."',
            '".$row[1]."',
            '".$row[2]."',
            '".$row[3]."',
            '".$row[4]."',
            '".$row[5]."',
            '".$row[6]."',
            '".$row[7]."'
        )";
mysql_query($sql_insertmayor,$cone_tpdh);
}
echo '</pre>';
?>