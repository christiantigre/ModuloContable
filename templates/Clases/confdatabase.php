<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

class Confdatabase {

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['loginu'], $_SESSION['clave'], 'condata');
        return $this->objconec;
    }    

    function ver_tabs(){
        $conn = $this->conec_base();
        $vertabs='SHOW FULL TABLES FROM condata';
        $cont_tabs='SELECT Count(*) FROM information_schema.tables where table_schema = "condata";';
        $result_cont = mysqli_query($conn, $cont_tabs) or trigger_error("Query Failed! SQL: $cont_tabs - Error: " . mysqli_error($conn), E_USER_ERROR);
        $result = mysqli_query($conn, $vertabs) or trigger_error("Query Failed! SQL: $vertabs - Error: " . mysqli_error($conn), E_USER_ERROR);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                $row_cont = mysqli_fetch_assoc($result_cont);
                ?>
                <input type="submit" class="btn btn-success" onclick="jsShowWindowLoad('Cargando...');" name="btnedit" value="EDITAR"/>
                <?php
                echo "</br>";
                echo "<label>".$row_cont['Count(*)']." tablas encontradas</label>";
                echo "<table class='table table-striped table-bordered table-hover'><tr><td>#</td><td>TABLA</td><td>TIPO</td>";
                $i=1;
        while ($dato = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $dato['Tables_in_condata'] . "</td>";
            echo "<td>" . $dato['Table_type'] . "</td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
                } else {
                    ?>
                <p style="font-size:13px; text-align: center; color: #CC0000;">
                    <label>No tiene registro contable</label>&nbsp;&nbsp;
                    </br>
                </p>
                <?Php
            }
            mysqli_close($conn);
    }

    function edit_dbase(){
        $conn = $this->conec_base();
        //Elimina vistas
        $d_hj='DROP VIEW IF EXISTS hoja_de_trabajo';
        $r_dhj = mysqli_query($conn, $d_hj) or trigger_error("Query Failed! SQL: $d_hj - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_ag='DROP VIEW IF EXISTS agrupacion';
        $r_ag = mysqli_query($conn, $d_ag) or trigger_error("Query Failed! SQL: $d_ag - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_sa='DROP VIEW IF EXISTS sumatoriadeagrupacion';
        $r_sa = mysqli_query($conn, $d_sa) or trigger_error("Query Failed! SQL: $d_sa - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_er='DROP VIEW IF EXISTS estadoresultados';
        $r_der = mysqli_query($conn, $d_er) or trigger_error("Query Failed! SQL: $d_er - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_sf='DROP VIEW IF EXISTS situacionfinal';
        $r_dsf = mysqli_query($conn, $d_sf) or trigger_error("Query Failed! SQL: $d_sf - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_in='DROP VIEW IF EXISTS ingresos';
        $r_in = mysqli_query($conn, $d_in) or trigger_error("Query Failed! SQL: $d_in - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_gs='DROP VIEW IF EXISTS gastos';
        $r_gs = mysqli_query($conn, $d_gs) or trigger_error("Query Failed! SQL: $d_gs - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_tin='DROP TABLE IF EXISTS tempingresos';
        $r_tin = mysqli_query($conn, $d_tin) or trigger_error("Query Failed! SQL: $d_tin - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_tgs='DROP TABLE IF EXISTS tempgastos';
        $r_tgs = mysqli_query($conn, $d_tgs) or trigger_error("Query Failed! SQL: $d_tgs - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_ter='DROP TABLE IF EXISTS tempestadoresultados';
        $r_ter = mysqli_query($conn, $d_ter) or trigger_error("Query Failed! SQL: $d_ter - Error: ".mysqli_error($conn),E_USER_ERROR);
        $d_tsf='DROP TABLE IF EXISTS tempsituacionfinal';
        $r_tsf = mysqli_query($conn, $d_tsf) or trigger_error("Query Failed! SQL: $d_tsf - Error: ".mysqli_error($conn),E_USER_ERROR);
        //Crea vistas
        $c_ht="create view hoja_de_trabajo as
SELECT `fecha_aj` , `cod_cuenta_aj` , `cuenta_aj` , `debe_aj` , `haber_aj` , `slddeudor_aj` , `sldacreedor_aj` , `grupo_aj` , `year_aj` , `mes_aj` , 
`balance_aj` , `fecha` , `cod_cuenta` , `cuenta` , `debe` , `haber` , `t_bl_inicial_idt_bl_inicial` , `tipo` , `sld_deudor` , `sld_acreedor` , `year` , `mes` 
, (coalesce( `slddeudor_aj` , 0 )) + ( coalesce( `sld_deudor` , 0 ) - coalesce( `sldacreedor_aj` , 0 )) + ( coalesce( `sld_acreedor` , 0 ) ) AS sum_deudor,
 concat('0.00') as sum_acreedor FROM `vistabalanceresultadosajustados` GROUP BY cod_cuenta HAVING 
(coalesce( `slddeudor_aj` , 0 )) + ( coalesce( `sld_deudor` , 0 )) > (coalesce( `sldacreedor_aj` , 0 )) + ( coalesce( `sld_acreedor` , 0 ))
UNION
SELECT `fecha_aj` , `cod_cuenta_aj` , `cuenta_aj` , `debe_aj` , `haber_aj` , `slddeudor_aj` , `sldacreedor_aj` , `grupo_aj` , `year_aj` , `mes_aj` , 
`balance_aj` , `fecha` , `cod_cuenta` , `cuenta` , `debe` , `haber` , `t_bl_inicial_idt_bl_inicial` , `tipo` , `sld_deudor` , `sld_acreedor` , `year` , `mes` ,
concat('0.00') as sum_deudor, 
(coalesce( `sldacreedor_aj` , 0 )) + ( coalesce( `sld_acreedor` , 0 )) - (coalesce( `slddeudor_aj` , 0 )) + ( coalesce( `sld_deudor` , 0 ) ) AS sum_acreedor 
FROM `vistabalanceresultadosajustados` GROUP BY cod_cuenta HAVING
(coalesce( `sldacreedor_aj` , 0 )) + ( coalesce( `sld_acreedor` , 0 )) > (coalesce( `slddeudor_aj` , 0 )) + ( coalesce( `sld_deudor` , 0 ))
UNION
SELECT `fecha_aj` , `cod_cuenta_aj` , `cuenta_aj` , `debe_aj` , `haber_aj` , `slddeudor_aj` , `sldacreedor_aj` , `grupo_aj` , `year_aj` , `mes_aj` , 
`balance_aj` , `fecha` , `cod_cuenta` , `cuenta` , `debe` , `haber` , `t_bl_inicial_idt_bl_inicial` , `tipo` , `sld_deudor` , `sld_acreedor` , `year` ,
 `mes` , concat('0.00') AS sum_deudor, concat('0.00') AS sum_acreedor FROM `vistabalanceresultadosajustados` GROUP BY cod_cuenta HAVING (coalesce( `sldacreedor_aj` , 0 )) + ( coalesce( `sld_acreedor` , 0 )) = (coalesce( `slddeudor_aj` , 0 )) + ( coalesce( `sld_deudor` , 0 ))";
 $r_hj = mysqli_query($conn, $c_ht) or trigger_error("Query Failed! SQL: $c_ht - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);
        
        $c_ag="CREATE VIEW agrupacion AS SELECT hj.cod_cuenta as referencia,c.cod_clase as clase,pl.t_grupo_cod_grupo as grupo,
 pl.t_cuenta_cod_cuenta as cuenta,pl.t_subcuenta_cod_subcuenta as subcuenta,pl.t_auxiliar_cod_cauxiliar as auxiliar,
 pl.t_subauxiliar_cod_subauxiliar as subauxiliar, sum(hj.sum_deudor) as deudor, sum(hj.sum_acreedor) as acreedor,hj.t_bl_inicial_idt_bl_inicial as contabilidad,hj.year,hj.fecha,CASE mes
            WHEN 'ENERO'        THEN 1
            WHEN 'FEBRERO'        THEN 2
            WHEN 'MARZO'        THEN 3
            WHEN 'ABRIL'        THEN 4
            WHEN 'MAYO'            THEN 5
            WHEN 'JUNIO'        THEN 6
            WHEN 'JULIO'        THEN 7
            WHEN 'AGOSTO'        THEN 8
            WHEN 'SEPTIEMBRE'    THEN 9
            WHEN 'OCTUBRE'        THEN 10
            WHEN 'NOVIEMBRE'        THEN 11 
            WHEN 'DICIEMBRE'        THEN 12 
        END as mes  FROM
 `hoja_de_trabajo` hj join t_plan_de_cuentas pl JOIN t_clase c JOIN t_grupo g
 where hj.cod_cuenta = pl.cod_cuenta AND pl.t_grupo_cod_grupo = g.cod_grupo and g.t_clase_cod_clase = c.cod_clase group by hj.cod_cuenta
";
 $r_ag = mysqli_query($conn, $c_ag) or trigger_error("Query Failed! SQL: $c_ag - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_sa="CREATE VIEW sumatoriadeagrupacion AS 
SELECT c.cod_clase as codigo, c.nombre_clase as cuenta, SUM(deudor) as s_deudor, SUM(acreedor) as s_acreedor, ag.contabilidad,ag.year,ag.mes,ag.fecha FROM `agrupacion` ag JOIN t_grupo g JOIN t_clase c WHERE ag.grupo = g.cod_grupo and g.t_clase_cod_clase = c.cod_clase GROUP by c.cod_clase
UNION
SELECT g.cod_grupo as codigo, g.nombre_grupo as cuenta, SUM(deudor) as s_deudor, SUM(acreedor) as s_acreedor, ag.contabilidad,ag.year,ag.mes,ag.fecha FROM `agrupacion` ag JOIN t_grupo g JOIN t_clase c WHERE ag.grupo = g.cod_grupo and g.t_clase_cod_clase = c.cod_clase GROUP by g.cod_grupo
UNION
SELECT ct.cod_cuenta as codigo, ct.nombre_cuenta as cuenta, SUM(deudor) as s_deudor, SUM(acreedor) as s_acreedor, ag.contabilidad,ag.year,ag.mes,ag.fecha FROM `agrupacion` ag JOIN t_grupo g JOIN t_clase c JOIN t_cuenta ct WHERE ag.grupo = g.cod_grupo and g.t_clase_cod_clase = c.cod_clase and ag.cuenta = ct.cod_cuenta GROUP by ct.cod_cuenta
UNION
SELECT sb.cod_subcuenta as codigo, sb.nombre_subcuenta as cuenta, SUM(deudor) as s_deudor, SUM(acreedor) as s_acreedor, ag.contabilidad,ag.year,ag.mes,ag.fecha FROM `agrupacion` ag JOIN t_grupo g JOIN t_clase c JOIN t_cuenta ct JOIN t_subcuenta sb WHERE ag.grupo = g.cod_grupo and g.t_clase_cod_clase = c.cod_clase and ag.cuenta = ct.cod_cuenta AND ag.subcuenta = sb.cod_subcuenta GROUP by sb.cod_subcuenta";
 $r_sa = mysqli_query($conn, $c_sa) or trigger_error("Query Failed! SQL: $c_sa - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_er="CREATE VIEW estadoresultados AS 
SELECT codigo,cuenta,`s_deudor`,`s_acreedor`,(coalesce( `s_deudor` , 0 )) - ( coalesce( `s_acreedor` , 0 ))  AS total,contabilidad,year,mes, fecha  FROM `sumatoriadeagrupacion` WHERE codigo>'3.99.99.99' GROUP by codigo HAVING `s_deudor` > `s_acreedor`
UNION
SELECT codigo,cuenta,`s_deudor`,`s_acreedor`,(coalesce( `s_acreedor` , 0 )) - ( coalesce( `s_deudor` , 0 ))  AS total,contabilidad,year,mes,fecha  FROM `sumatoriadeagrupacion` where codigo>'3.99.99.99' GROUP by codigo HAVING `s_acreedor` > `s_deudor`
UNION
SELECT codigo,cuenta,`s_deudor`,`s_acreedor`,concat('0,00')  AS total,contabilidad,year,mes,fecha  FROM `sumatoriadeagrupacion` where codigo>'3.99.99.99' GROUP by codigo HAVING `s_acreedor` = `s_deudor`
";
 $r_er = mysqli_query($conn, $c_er) or trigger_error("Query Failed! SQL: $c_er - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_sf="CREATE VIEW situacionfinal AS 
SELECT codigo,cuenta,`s_deudor`,`s_acreedor`,(coalesce( `s_deudor` , 0 )) - ( coalesce( `s_acreedor` , 0 ))  AS total,contabilidad,year,mes, fecha  FROM `sumatoriadeagrupacion` WHERE codigo<='3.99.99.99' GROUP by codigo HAVING `s_deudor` > `s_acreedor`
UNION
SELECT codigo,cuenta,`s_deudor`,`s_acreedor`,(coalesce( `s_acreedor` , 0 )) - ( coalesce( `s_deudor` , 0 ))  AS total,contabilidad,year,mes,fecha  FROM `sumatoriadeagrupacion` where codigo<='3.99.99.99' GROUP by codigo HAVING `s_acreedor` > `s_deudor`
UNION
SELECT codigo,cuenta,`s_deudor`,`s_acreedor`,concat('0,00')  AS total,contabilidad,year,mes,fecha  FROM `sumatoriadeagrupacion` where codigo<='3.99.99.99' GROUP by codigo HAVING `s_acreedor` = `s_deudor`
";
 $r_sf = mysqli_query($conn, $c_sf) or trigger_error("Query Failed! SQL: $c_sf - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_in="CREATE VIEW ingresos AS
SELECT `codigo`,`cuenta`,`s_deudor`,`s_acreedor`,`total`,`contabilidad`,`year`,`mes`,REPLACE(fecha,'/','-') as fecha FROM
 estadoresultados where codigo between '4.' and '4.99.99.99.' ORDER BY codigo ASC
";
 $r_in = mysqli_query($conn, $c_in) or trigger_error("Query Failed! SQL: $c_in - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_gs="CREATE VIEW gastos AS
SELECT `codigo`,`cuenta`,`s_deudor`,`s_acreedor`,`total`,`contabilidad`,`year`,`mes`,REPLACE(fecha,'/','-') as fecha FROM
 estadoresultados where codigo between '5.' and '5.99.99.99.' ORDER BY codigo ASC
";
 $r_gs = mysqli_query($conn, $c_gs) or trigger_error("Query Failed! SQL: $c_gs - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_tin="CREATE TABLE tempingresos (
  `codigo` varchar(45) DEFAULT NULL,
  `cuenta` char(255) DEFAULT NULL,
  `s_deudor` char(255) DEFAULT NULL,
  `s_acreedor` char(255) DEFAULT NULL,
  `total` char(255) DEFAULT NULL,
  `contabilidad` char(3) DEFAULT NULL,
  `year` char(4) DEFAULT NULL,
  `mes` char(2) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
 $r_tin = mysqli_query($conn, $c_tin) or trigger_error("Query Failed! SQL: $c_tin - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_tgs="CREATE TABLE tempgastos (
  `codigo` varchar(45) DEFAULT NULL,
  `cuenta` char(255) DEFAULT NULL,
  `s_deudor` char(255) DEFAULT NULL,
  `s_acreedor` char(255) DEFAULT NULL,
  `total` char(255) DEFAULT NULL,
  `contabilidad` char(3) DEFAULT NULL,
  `year` char(4) DEFAULT NULL,
  `mes` char(2) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
 $r_tgs = mysqli_query($conn, $c_tgs) or trigger_error("Query Failed! SQL: $c_tgs - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_tes="create table tempestadoresultados (
codigo char(20),
    cuenta char(100),
    s_deudor double(11,2),
    s_acreedor double(11,2),
    total double(11,2),
    contabilidad char(2),
    year char(4),
    mes char(2),
    fecha date
);";
 $r_tes = mysqli_query($conn, $c_tes) or trigger_error("Query Failed! SQL: $c_tes - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

$c_tsf="create table  tempsituacionfinal (
codigo char(20),
    cuenta char(100),
    s_deudor double(11,2),
    s_acreedor double(11,2),
    total double(11,2),
    contabilidad char(2),
    year char(4),
    mes char(2),
    fecha date
);"; 
$r_tsf = mysqli_query($conn, $c_tsf) or trigger_error("Query Failed! SQL: $c_tsf - Error: ".mysqli_error($conn),E_USER_ERROR);
 sleep(1);

        $this->ver_tabs();        
    }
    
}

            