<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates Christian Tigre
 * and open the template in the editor.
 */

$con = mysqli_connect("localhost","root","alberto2791","condata"); 
$mes=  date('F');$year= date("Y");
// verificar la connection
if (mysqli_connect_errno()) {
    echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
    exit();
}
unset($success, $fail);
for($i=0; $i<count($campo7); $i++) 
{  
mysqli_query($con,"INSERT INTO condata.t_mayor (fecha,cod_cuenta,cuenta,deb,hab,saldodeudor,saldoacreedor,tipo,t_bl_inicial_idt_bl_inicial,year,mes) VALUES (
'$campo2[$i]',
'$campo3[$i]',
'$campo4[$i]',
'$campo5[$i]',
'$campo6[$i]',
'$campo7[$i]',
'$campo8[$i]',
'$campo9[$i]',
'$campo1[$i]',
    '$year',
    '$mes'
)");  
} 

 if(mysqli_connect_errno()){
    print_r("insert failed: %s\n<br />", mysqli_error($con));    
 }else{
    print_r("Mayorizacion Guardada con exito....\n");
    }

mysqli_close($con);
?>