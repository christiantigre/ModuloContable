<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    if ($btntu == "BUSCAR") {
        $opciones = htmlspecialchars(trim($_POST['opciones']));
//                                                    echo '<script>alert('.$opciones.')</script>';
        $uno = strstr($opciones, '-', true);
        $dos = substr(strstr($opciones, '-'), 1);
//                                                    echo '<script>alert("' . $dos . '")</script>';
        ?>
        <h3>Por el mes de <?php echo translateMonth($dos) ?> del <?php echo $year ?></h3>

        <input type="hidden" value="<?php echo $maxbalancedato; ?>" id="texto"/>
        <input type="hidden" value="<?php echo $uno; ?>" id="mes"/>

        <div class="mensaje"></div>
        <input type="hidden" value="<?php echo $estado; ?>"/>
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
        echo '<th colspan="3">' . $cod_clasesq . ' ' . $nom_clase . '</th>';
        echo '<td style="display:none"></td>';
        echo '<td style="display:none"></td>';
        echo '<td style="display:none"></td>';
        echo '</tr>';

//                                           SQL INGRESOS and mes<='8'
        $select_ct = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '4.' and '4.99.99.99.' and mes='" . $uno . "' ORDER BY codigo ASC";
        $resulgrupos = mysqli_query($conn, $select_ct)or trigger_error("Query Failed! SQL: $select_ct - Error: " . mysqli_error($mysqli), E_USER_ERROR);

//                                           SQL COSTOS Y GASTOS
        $select_cg = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '5.' and '5.99.99.99.' and mes='" . $uno . "' ORDER BY codigo ASC";
        $resulgruposcg = mysqli_query($conn, $select_cg)or trigger_error("Query Failed! SQL: $select_cg - Error: " . mysqli_error($mysqli), E_USER_ERROR);

        $datosIngreso = array();
        while ($row2 = mysqli_fetch_array($resulgrupos)) {
            $numIng = mysqli_num_rows($resulgrupos);
            if (!empty($numIng)) {
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
            } else {
                echo '<script>alert("NO HAY INGRESOS")</script>';
            }



            //echo "<script>alert('".$numIng."')</script>";
        }
        $datosGastos = array();
        while ($row3 = mysqli_fetch_array($resulgruposcg)) {
            $numGas = mysqli_num_rows($resulgruposcg);
            if (!empty($numGas)) {
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
            } else {
                echo '<script>alert("NO HAY GASTOS")</script>';
            }
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
    if ($btntu == "todo") {
        include_once './tab_my/statusresultall.php';
    }
    if ($btntu == "periodos") {
        $datetimepickermin = $_POST['datetimepicker1min'];
        $datetimepickermax = $_POST['datetimepicker1max'];
        require '../../Clases/filtroestadoresultados.php';
        $objFilEstRes = new filtroestadoresultados();
        $objFilEstRes->filtroporperiodos($datetimepickermin, $datetimepickermax, $dbi);
    }
} else {
    require('./tab_my/statusresultall.php');
}
?>