<?php
session_start();
$user = $_SESSION['username'];
$idlogeobl = $_POST['idlogeobl'];
$concepto = $_POST['textarea_asnew'];
$idlogeobl = $_POST['idlogeobl'];
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$date = date("Y-m-j");
$mes = date('F');
$year = date("Y");
$saldodebe = 0.00;
$saldohaber = 0.00;
$asiento_num = 1;

$consultau = "SELECT l.username, u.tipo_user,l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.username = '" . $user . "'";
//$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$resultado = mysqli_query($c, $consultau);
$filau = mysqli_fetch_array($resultado);
$user = $filau['username'];
$type_user = $filau['tipo_user'];
$idlogeoblu = $filau['idlogeo'];

$consultaaux = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$resultaux = mysqli_query($c, $consultaaux) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
if ($resultaux) {
    while ($rowaux = mysqli_fetch_assoc($resultaux)) {
        $maxbalancedatoaux = $rowaux['id'];
    }
}
$sql_sumyear="SELECT year FROM `t_bl_inicial` where idt_bl_inicial='".$maxbalancedatoaux."'";
                                        $data = mysqli_query($c, $sql_sumyear);
                                        $resdata = mysqli_fetch_assoc($data);
                                        $yearactual = $resdata['year'];
                                        $yearactual = $yearactual+1;

$contarbalances = "SELECT count(`idt_bl_inicial`)+1 as contador FROM `t_bl_inicial`";
$rescontador = mysqli_query($c, $contarbalances);
$fila = mysqli_fetch_array($rescontador);
$contadorbalances = $fila['contador'];




$creanuevoperiodo = "INSERT INTO `condata`.`t_bl_inicial`"
        . " (`idt_bl_inicial`, `fecha_balance`, `logeo_idlogeo`, `year`, `estado`) "
        . "VALUES ('" . $contadorbalances . "', '".$date."', '" . $idlogeoblu . "', '" . $yearactual . "', '1');";
mysqli_query($c, $creanuevoperiodo);

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
    }
}
$insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , "
        . "`t_bl_inicial_idt_bl_inicial`, `t_ejercicio_idt_corrientes`, mes,year,saldodebe,saldohaber)VALUES "
        . "(NULL , '" . $date . "', '" . trim($concepto) . "', '" . $maxbalancedato . "','" . $asiento_num . "','" . $mes . "','" . $yearactual . "','" . (float) $saldodebe . "','" . (float) $saldohaber . "');";
mysqli_query($c, $insertasientoconcepto);

$a = 1;
for ($i = 0; $i < count($campo6); $i++) {
    mysqli_query($c, "INSERT INTO `condata`.`t_ejercicio` 
        (`idt_corrientes` ,`ejercicio` ,`cod_cuenta` ,`cuenta` ,`fecha` ,`valor` ,`valorp` ,`t_bl_inicial_idt_bl_inicial` ,
`tipo` ,`logeo_idlogeo` ,`mes`,year 
)VALUES (NULL ,
'" . $asiento_num . "', 
'" . $campo2[$i] . "',
'" . $campo3[$i] . "', 
'" . $campo1[$i] . "',
'" . $campo4[$i] . "', 
'" . $campo5[$i] . "',
'" . $maxbalancedato . "',
'" . $campo6[$i] . "', 
'" . $idlogeobl . "',
'" . $mes . "',
'" . $yearactual . "'    
);");
    $a++;
}


if (mysqli_connect_errno()) {
    print_r("insert failed: %s\n<br />", mysqli_error($c));
} else {
    print_r("Balance guardado con exito....\n");
}

include '../../Clases/guardahistorial.php';
$accion = "Creo blce inicial periodo " . $yearactual;
generaLogs($user, $accion);


mysqli_close($c);
?>