<?php
//echo '<script language = javascript>alert("hola")</script>';
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
        $conb = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
    mysql_select_db("condata", $conb) or die("ERROR con la base de datos");
    $B_BUSCAR = "SELECT g.cod_grupo as grupo, g.nombre_grupo as nom
FROM `t_plan_de_cuentas` p
JOIN t_grupo g
WHERE p.`t_grupo_cod_grupo` = g.cod_grupo
AND `cod_cuenta` = '".$_POST['texto']."'";
    $rnom = mysql_query($B_BUSCAR, $conb);
    $f = mysql_fetch_array($rnom);
    if ($f==0) {
        echo '';
    }else{
    $dato = $f['grupo'];
    $dato1 = $f['nom'];
    $codcuenta = $dato;
    $nomcuenta = $dato1;
    //echo $codcuenta;
    echo $nomcuenta;
    }
    //echo "He recibido en el archivo.php: " . $_POST["texto"];
    //else
    //  echo "He recibido un campo vacio";
}
?>