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
        ?>
        <input type = 'hidden' value ="<?Php echo $maxbalancedato; ?>id = 'texto'/>";

               <div class = "mensaje"></div>
        <input type = "hidden" value = "<?php // echo $estado;    ?>"/>
        <input type = "hidden" value = "<?php echo $uno; ?>" id = "mes"/>
        <?Php
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
        echo '<table width="100%" class="table table-striped table-bordered table-hover">';
        echo "<br>";
        echo '<tr>';
        echo '<th colspan="5">';
        ?>
        <?Php
        $position_f = explode('-', $fechadesde);
        $diadesde = $position_f[0];
        $mesdesde = $position_f[1];
        $yeardesde = $position_f[2];
        
        
        $position_h = explode('-', $fechahasta);
        $diahasta = $position_h[0];
        $meshasta = $position_h[1];
        $yearhasta = $position_h[2];       
        
        ?>
        <h3>Del <?Php echo $diadesde ?> de <?Php echo MonthNumber($mesdesde)?> Al <?Php echo $diahasta ?> de <?php echo MonthNumber($meshasta) ?> del <?php echo $yeardesde ?></h3>
        
        <?Php
        echo '</th>';
//        echo '<th colspan="3">' . $cod_clasesq . ' ' . $nom_clase . '</th>';
        echo '<td style="display:none"></td>';
        echo '<td style="display:none"></td>';
        echo '<td style="display:none"></td>';
        echo '</tr>';

//                                           SQL INGRESOS and mes<='8'

        $conn = $dbi->conexion();
        $select_ct = "SELECT * FROM ingresos where fecha between '" . $fechadesde . "' and '" . $fechahasta . "' ORDER BY codigo ASC";
        $resulgrupos = mysqli_query($conn, $select_ct)or trigger_error("Query Failed! SQL: $select_ct - Error: " . mysqli_error($mysqli), E_USER_ERROR);

//                                           SQL COSTOS Y GASTOS
        $select_cg = "SELECT * FROM gastos where fecha between '" . $fechadesde. "' and '" . $fechahasta . "' ORDER BY codigo ASC";
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

        $utilidad = $datosIngreso[0] - $datosGastos[0];

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
