<?php
/*
 * Clase para visualizacion por filtros en estado de resultados
 */

/**
 * Description of filtroestadoresultados
 *
 * @author Administrador
 */
include '../../Clases/acentos.php';

class filtroestadoresultados {

    function filtroporperiodos($fechadesde, $fechahasta, $dbi) {
//        echo '<script>alert("' . $fechadesde . '")</script>';
        $c = $dbi->conexion();
        $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
        $resul_param = $c->query($sqlparametro);
        if ($resul_param->num_rows > 0) {
            while ($clase_param = $resul_param->fetch_assoc()) {
                $parametro_contador = $clase_param['cont'];
            }
        } else {
            echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
        }
        ?>
        <input type = 'hidden' value ="<?Php echo $parametro_contador; ?>" id = 'texto'/>
        <div class = "mensaje"></div>
        <input type = "hidden" value = "<?php echo $fechadesde; ?>" id="fechadesde"/>
        <input type = "hidden" value = "<?php echo $fechahasta; ?>" id= "fechahasta"/>
        <?Php
        echo '<table width="100%" class="table table-striped table-bordered table-hover">';
        echo "<br>";
        echo '<tr>';
        echo '<th colspan="5">';
        ?>
        <?Php
        $position_f = explode('-', $fechadesde);
        $diadesde = $position_f[2];
        $mesdesde = $position_f[1];
        $yeardesde = $position_f[0];


        $position_h = explode('-', $fechahasta);
        $diahasta = $position_h[2];
        $meshasta = $position_h[1];
        $yearhasta = $position_h[0];
        ?>
        <h3>Del <?Php echo $diadesde ?> de <?Php echo MonthNumber($mesdesde) ?> Al <?Php echo $diahasta ?> de <?php echo MonthNumber($meshasta) ?> del <?php echo $yeardesde ?></h3>
        <td>
            <button type="button" title="IMPRIMIR" id="imp" name="imp" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_blresfechas(<?Php echo $idlogeobl; ?>)"></button>
        </td>                                                                        
        <?Php
        echo '</th>';
//        echo '<th colspan="3">' . $cod_clasesq . ' ' . $nom_clase . '</th>';
        echo '<td style="display:none"></td>';
        echo '<td style="display:none"></td>';
        echo '<td style="display:none"></td>';
        echo '</tr>';

//                                           SQL INGRESOS and mes<='8'

        $conn = $dbi->conexion();
//        elimina tabla temporal
//        DROP TABLE tempingresos
        $delete_temp_ing = "DELETE FROM tempingresos";
        $resuldelet = mysqli_query($conn, $delete_temp_ing)or trigger_error("Query Failed! SQL: $delete_temp_ing - Error: " . mysqli_error($conn), E_USER_ERROR);

//        DROP TABLE tempgastos
        $delete_temp_gst = "DELETE FROM tempgastos";
        $resuldelet = mysqli_query($conn, $delete_temp_gst)or trigger_error("Query Failed! SQL: $delete_temp_gst - Error: " . mysqli_error($conn), E_USER_ERROR);

//        crea tabla temporal ingresos con fecha formateada
        $select_fecha = "SELECT * FROM ingresos";
        $resulfecha = mysqli_query($conn, $select_fecha)or trigger_error("Query Failed! SQL: $select_fecha - Error: " . mysqli_error($conn), E_USER_ERROR);
        while ($rowfch = mysqli_fetch_array($resulfecha)) {
            $originalDate = $rowfch['fecha'];
            $newDate = date("Y-m-d", strtotime($originalDate));
            $insert = mysqli_query($conn, "INSERT INTO `tempingresos` ("
                    . "`codigo`, `cuenta`, `s_deudor`, `s_acreedor`, `total`, `contabilidad`, `year`, `mes`, `fecha`) VALUES ("
                    . "'" . $rowfch['codigo'] . "', '" . $rowfch['cuenta'] . "', '" . $rowfch['s_deudor'] . "', '" . $rowfch['s_acreedor'] . "', '" . $rowfch['total'] . "', '" . $rowfch['contabilidad'] . "', '" . $rowfch['year'] . "', '" . $rowfch['mes'] . "', '" . $newDate . "');");
        }

        //        crea tabla temporal gastos con fecha formateada
        $select_fechags = "SELECT * FROM gastos where fecha";
        $resulfechags = mysqli_query($conn, $select_fechags)or trigger_error("Query Failed! SQL: $select_fechags - Error: " . mysqli_error($conn), E_USER_ERROR);
        while ($rowfchgs = mysqli_fetch_array($resulfechags)) {
            $originalDategs = $rowfchgs['fecha']; //echo $originalDategs;echo "<br>";
            $newDategs = date("Y-m-d", strtotime($originalDategs));
            $insertgs = mysqli_query($conn, "INSERT INTO `tempgastos` ("
                    . "`codigo`, `cuenta`, `s_deudor`, `s_acreedor`, `total`, `contabilidad`, `year`, `mes`, `fecha`) VALUES ("
                    . "'" . $rowfchgs['codigo'] . "', '" . $rowfchgs['cuenta'] . "', '" . $rowfchgs['s_deudor'] . "', '" . $rowfchgs['s_acreedor'] . "', '" . $rowfchgs['total'] . "', '" . $rowfchgs['contabilidad'] . "', '" . $rowfchgs['year'] . "', '" . $rowfchgs['mes'] . "', '" . $newDategs . "');");
        }

//        visualiza los datos de la consulta
        $desde = date("Y-m-d", strtotime($fechadesde));
        $hasta = date("Y-m-d", strtotime($fechahasta));

        $select_ct = "SELECT * FROM tempingresos where fecha between '" . $desde . "' and '" . $hasta . "' ORDER BY codigo ASC";
        $resulgrupos = mysqli_query($conn, $select_ct)or trigger_error("Query Failed! SQL: $select_ct - Error: " . mysqli_error($mysqli), E_USER_ERROR);

//                                           SQL COSTOS Y GASTOS
        $select_cg = "SELECT * FROM tempgastos where fecha between '" . $desde . "' and '" . $hasta . "' ORDER BY codigo ASC";
        $resulgruposcg = mysqli_query($conn, $select_cg)or trigger_error("Query Failed! SQL: $select_cg - Error: " . mysqli_error($mysqli), E_USER_ERROR);

        $datosIngreso = array();
        while ($row2 = mysqli_fetch_array($resulgrupos)) {
            $numIng = mysqli_num_rows($resulgrupos);
            $str = strlen($row2['codigo']);
            echo '<tr>
                                                        <td>' . $row2['codigo'] . '</td>
                                                        <td>' . $row2['cuenta'] . '</td>';
            if ($str == 2) {
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';

                for ($i = 0; $i <= count($numIng); $i++) {
                    $datosIngreso[] = $row2['total'];
                }
            } elseif ($str == 4) {
                echo '<td></td>';
                echo '<td></td>';
                echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                echo '<td></td>';
            } elseif ($str == 6) {
                echo '<td></td>';
                echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                echo '<td></td>';
                echo '<td></td>';
            } elseif ($str == 8) {
                echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
            }
            echo '</tr>';
        }
        $datosGastos = array();
        while ($row3 = mysqli_fetch_array($resulgruposcg)) {
            $numGas = mysqli_num_rows($resulgruposcg);
            $str = strlen($row3['codigo']);
            echo '<tr>
                                                        <td>' . $row3['codigo'] . '</td>
                                                        <td>' . $row3['cuenta'] . '</td>';
            if ($str == 2) {
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                for ($j = 0; $j <= count($numGas); $j++) {
                    $datosGastos[] = $row3['total'];
                }
            } elseif ($str == 4) {
                echo '<td></td>';
                echo '<td></td>';
                echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                echo '<td></td>';
            } elseif ($str == 6) {
                echo '<td></td>';
                echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                echo '<td></td>';
                echo '<td></td>';
            } elseif ($str == 8) {
                echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
            }
            echo '</tr>';
        }
        $utilidad = 0;
        if ($datosIngreso[0] > 0) {
            $utilidad = $datosIngreso[0] - $datosGastos[0];
        } else {
            $utilidad = $datosGastos[0] - $datosIngreso[0];
        }


        if (isset($utilidad)) {
            $utilidad = $utilidad;
        } else {
            $utilidad = '0.00';
        }
        echo '<tr>'
        . '<td></td>'
        . '<td>UTILIDAD</td>'
        . '<td></td>'
        . '<td></td>'
        . '<td></td>'
        . '<td>' .
        number_format($utilidad, 2, '.', '') . '</td>'
        . '</tr>';
        echo '</table>';
    }

}
