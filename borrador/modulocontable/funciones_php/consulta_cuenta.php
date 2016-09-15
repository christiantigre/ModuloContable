<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

        
        $cuenta = htmlspecialchars(trim($_POST['busqueda']));
        $con1 = mysql_connect("localhost", "root", "alberto2791");
        mysql_select_db("condata", $con1);
        echo "<script language = javascript>alert('$cuenta')</script>";
        $consulta = "SELECT cod_cuenta,nombre_cuenta_plan FROM `t_plan_de_cuentas`"
                . " WHERE nombre_cuenta_plan ='" . $cuenta . "' or `cod_cuenta`='" . $cuenta . "'";
        $resultado = mysql_query($consulta, $con1) or die(mysql_error());
        $fila = mysql_fetch_array($resultado);
        $cod_cuenta = $fila['cod_cuenta'];
        $nom_cuenta = $fila['nombre_cuenta_plan']; 
        echo "<script language = javascript>alert('$nom_cuenta')</script>";