<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<form method="post" action="generarcodigoscuentas.php">
  <?php
  
 echo $_GET['codclase']; 
 $codclase = $_GET['codclase'];
  echo "<script>alert($codclase)</script>";
                $ctu = mysql_connect("localhost", "root", "alberto2791") or die("Error en la conexion");
                $Btu = mysql_select_db("condata", $ctu) or die("Problema al seleccionar la base de datos");
                $stu = " SELECT count( * ) +1 AS Siguiente, concat( (t_clase_cod_clase), ('.'), (count( * ) +1 ))"
                        . " AS Codigo FROM `t_grupo` WHERE `t_clase_cod_clase` ='".$codclase."' ";
                $stu1 = "select * from t_clase";
                $query = mysql_query($stu);
                $queryclases = mysql_query($stu1);
                //if ($row = mysql_fetch_row($query)) {        $id = trim($row[0]);                    echo $id;                }
                echo "<table border='1' width=50 >"
                . "<tr><th>Siguiente Registro</th>"
                . "<th>Codigo</th>";
                while ($row = mysql_fetch_array($query)) {
                    echo "<tr>";
                    echo "<td>" . $row[0] . "</td>";
                    echo "<td>" . $row[1] . "</td>";
                    echo "</tr>";
                }echo "</table>";
            
              
                
                    
  
  ?>
</form> 




        $ctu = mysql_connect("localhost", "root", "alberto2791") or die("Error en la conexion");
        $Btu = mysql_select_db("condata", $ctu) or die("Problema al seleccionar la base de datos");
        $stu = " SELECT count( * ) +1 AS Siguiente, concat( (t_clase_cod_clase), ('.'), (count( * ) +1 ))"
                . " AS Codigo FROM `t_grupo` WHERE `t_clase_cod_clase` =" . $cod_clase . " ";
       // $stu1 = "select * from t_clase";$queryclases = mysql_query($stu1);
        $query = mysql_query($stu,$cto);        
       // $row = mysql_fetch_row($query);
      //  $idsig = $row['Siguiente'];
      //  $idcod = $row['Codigo'];        
      //  echo "<script>alert($idcod);</script>";
        echo "<table border='1' width=50 >"
                . "<tr><th>Siguiente Registro</th>"
                . "<th>Codigo</th>";
                while ($row = mysql_fetch_array($query)) {
                    echo "<tr>";
                    echo "<td>" . $row[0] . "</td>";
                    echo "<td>" . $row[1] . "</td>";
                    echo "</tr>";
                }echo "</table>";
                
                
                
                funciona bien
                
                
                
                $ctu = mysql_connect("localhost", "root", "alberto2791") or die("Error en la conexion");
                $Btu = mysql_select_db("condata", $ctu) or die("Problema al seleccionar la base de datos");
                $stu = " SELECT concat( (t_clase_cod_clase), ('.'), (count( * ) +1 )) AS Codigo FROM `t_grupo` WHERE `t_clase_cod_clase` =".$cod_clase." ";
                $stu1 = "select * from t_clase";
                $query = mysql_query($stu);
                $queryclases = mysql_query($stu1);
                //if ($row = mysql_fetch_row($query)) {        $id = trim($row[0]);                    echo $id;                }
                echo "<table border='1' width=50 >"
                . "<tr>"
                . "<th>Codigo</th>";
                while ($row = mysql_fetch_array($query)) {
                    echo "<tr>";
                    echo "<td>" . $row[0] . "</td>";
                    echo "</tr>";
                }echo "</table>";