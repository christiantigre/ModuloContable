<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$result = mysqli_query($c, "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'");
                                                        $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'";
                                                        $resulaj = mysqli_query($c, $sqlaj);
                                                        $result_d_m_mayor = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "' and cod_cuenta='" . $tip_cuentadh . "'");
                                                        $dato_fila = mysqli_fetch_array($result_d_m_mayor);
                                                        $mayor_debe = $dato_fila['debe'];
                                                        $mayor_haber = $dato_fila['haber'];
                                                        $mayor_sldue = $dato_fila['sldeu'];
                                                        $mayor_sldacr = $dato_fila['slacr'];
//                                                        class='table table-hover' 
                                                        echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
                                                        echo "<thead>";
                                                        echo "<tr> <center>T</center> </tr>";
                                                        echo "<tr class='success'>";
                                                        echo "<th style='display:none'>Ejercicio</th>";
                                                        echo "<th style='display:none'>balance</th>";
                                                        echo "<th>Fecha</th>";
                                                        echo "<th>Cod.</th>";
                                                        echo "<th>Cuenta</th>";
                                                        echo "<th>Debe</th>";
                                                        echo "<th>Haber</th>";
                                                        echo "<th>Concepto</th>";
                                                        echo "<th># Ass</th>";
                                                        echo "<th>ACCION</th>";
                                                        echo "</tr>";
                                                        echo "</thead>";
                                                        echo "<tbody>";
                                                        $a = 1;
                                                        while ($row = mysqli_fetch_row($result)) {
                                                            $concepto = utf8_decode($row[7]);
//                                                            class='warning'
                                                            echo "<tr class='gradeA warning' >";
                                                            echo "<td style='display:none'><input type='hidden' id='fechain_" . $a . "' value='$row[0]'>$row[6]</td>";
                                                            echo "<td style='display:none'><input type='hidden' id='assin_" . $a . "' value='$row[6]'>$row[5]</td>";
                                                            echo "<td>$row[0]</td>";
                                                            echo "<td>$row[1]</td>";
                                                            echo "<td>$row[2]</td>";
                                                            echo "<td>$row[3]</td>";
                                                            echo "<td>$row[4]</td>";
                                                            echo "<td>$concepto</td>";
                                                            echo "<td>$row[6]</td>";
                                                            echo "<td>";
                                                            if ($row[6] == '1') {
                                                                ?>
                                                <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_as_my(<?Php echo $a; ?>);'></button>
                                                                
                                                                <?Php
                                                            } else {
                                                                ?>
                                            <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_asiento_my(<?Php echo $a; ?>);'></button>
                                                                
                                                                <?Php
                                                            }
                                                                echo "</td>";
                                                                echo "</tr>";
                                                                echo "</tbody>";
                                                            }
                                                            $a++;
                                                            echo "</table>";