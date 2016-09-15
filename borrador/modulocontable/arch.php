<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    if ($btntu == "btn") {
        echo '<script>alert("btn")</script>';
    }

}
if (isset($_GET['formmod'])) {
    require('../../../../templates/Clases/Conectar.php');
    $dbi = new Conectar();
    $c = $dbi->conexion();
    $cons = "SELECT * FROM `t_ejercicio` WHERE `idt_corrientes`=  '" . $_GET['formmod'] . "'  ";
    $data = mysqli_query($c, $cons) or trigger_error("Query Failed! SQL: $cons - Error: " . mysqli_error($c), E_USER_ERROR);
    while ($row = mysqli_fetch_assoc($data)) {
        ?>

        <form name="form_ejercicio" id="form_ejercicio" method="post" action="arch.php">
        <input class="texto" readonly="readonly" name="dat1" id="dat1" value="<?Php echo $row['idt_corrientes']; ?>" />
        <input class="texto" readonly="readonly" name="dat2" id="dat2" value="<?Php echo $row['ejercicio']; ?>" />
        <input class="texto" readonly="readonly" name="dat3" id="dat3" value="<?Php echo $row['cod_cuenta']; ?>" />
        <input class="texto" readonly="readonly" name="dat4" id="dat4" value="<?Php echo $row['cuenta']; ?>" />
        <input class="texto" readonly="readonly" name="dat5" id="dat5" value="<?Php echo $row['fecha']; ?>" />
        <input class="texto" readonly="readonly" name="dat6" id="dat6" value="<?Php echo $row['valor']; ?>" />
        <input class="texto" readonly="readonly" name="dat7" id="dat7" value="<?Php echo $row['valorp']; ?>" />
        <input class="texto" readonly="readonly" name="dat8" id="dat8" value="<?Php echo $row['t_bl_inicial_idt_bl_inicial']; ?>" />
        <input class="texto" readonly="readonly" name="dat9" id="dat9" value="<?Php echo $row['tipo']; ?>" />
        <input class="texto" readonly="readonly" name="dat10" id="dat10" value="<?Php echo $row['logeo_idlogeo']; ?>" />
        <input class="texto" readonly="readonly" name="dat11" id="dat11" value="<?Php echo $row['mes']; ?>" />
        <input class="texto" readonly="readonly" name="dat12" id="dat12" value="<?Php echo $row['year']; ?>" />
            <fieldset>
                <br>
                <legend>
                    <center>  <strong>  MODIFICAR ASIENTO  # <?Php echo $_GET['formmod'] ?></strong> </center>
                            <center><div id="cargando"></div></center>  
                </legend>
                <datalist id="cuent" >
                    <?php
                    $query = "select * from t_plan_de_cuentas";
                    $resul1 = mysqli_query($c, $query);
                    while ($dato1 = mysqli_fetch_array($resul1)) {
                        $cod1 = $dato1['cod_cuenta'];
                        echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                        echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                        echo '</option>';
                    }
                    ?>
                </datalist>
                    <center><div id="cargando"></div></center>    
                    <table border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                        <p>
                        <td align="center">
                            <label class="form">Cod Cuenta :   </label>
                            <input list="cuent" class="text" name="cod_cuenta" id="cod_cuenta" value="<?Php echo $row['cod_cuenta']; ?>"/>
                            <input type="submit" id="btn" value="btn" />
                            <input type="button" id="boton" value="" style=" background:url('../../../../images/sig.png') no-repeat;
                                   border: #000; width:120px; heigh:50px;"/>
                        </td>
                        <td align="center">
                            <label class="form">Nombre Cuenta :</label>
                            <input class="texto" readonly="readonly" name="nom_cuenta" id="nom_cuenta" value="<?Php echo $row['cuenta']; ?>"/>
                        </td>
                        </p>         
                        </tr>
                        <tr>    
                        <p>
                        <td align="center">
                            <label class="form">Valor :</label>
                            <input type="text" id="valor" name="valor" value="<?Php echo $row['valor']; ?>" onkeypress="Calcular()" onkeyup="validar(this.id);
                                            Calcular();" style="text-align: right" value="0.00" placeholder="Format 0.00"/></td>
                        </p>
                        <p>
                        <td align="center"> <label class="form">Grupo    : </label> 
                            <?Php
                            $B_BUSCAR = "SELECT g.cod_grupo as grupo, g.nombre_grupo as nom FROM `t_plan_de_cuentas` p JOIN t_grupo g WHERE p.`t_grupo_cod_grupo` = g.cod_grupo AND `cod_cuenta` = '" . $row['tipo'] . "'";
                            $rnom = mysqli_query($c, $B_BUSCAR);
                            $f = mysqli_fetch_array($rnom);
                            if ($f == 0) {//        echo 'Error de codigo';
                                ?>                           
                                <input type="text" name="cod_grupo" id="cod_grupo" readonly="readonly" value="Error de codigo"/> 
                                <?Php
                            } else {
                                $dato = $f['grupo'];
                                $dato1 = $f['nom'];
                                $codcuenta = $dato;
                                $nomcuenta = $dato1;
                                ?>                           
                                <input type="text" name="cod_grupo" id="cod_grupo" readonly="readonly" value="<?Php echo $nomcuenta; ?>"/> 
                                <?Php
                            }
                            ?>
                            <input type="text" name="nom_grupo" id="nom_grupo" style="width: 40px;" readonly="readonly" value="<?Php echo $row['tipo']; ?>"/>
                        </td>
                        </p>
                        </tr>
                        <tr>
                        <p>
                        <td align="center">
                            <label class="form">Cuenta de   : </label> 
                            <?php
                            ?>
                            <?php
                            if ($row['valor'] == '0.00') {
//                                echo 'haber';
                                $valaux = 2;
                            } elseif ($row['valorp'] == '0.00') {
//                                echo 'debe';
                                $valaux = 1;
                            }
                            ?>
                            <?php
                            $SQLtipobaldh = "SELECT * FROM tip_cuenta";
                            $query_tipo_bldh = mysqli_query($c, $SQLtipobaldh);
                            ?>
                            <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                <?php
                                while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) {
                                    if ($valaux == $arreglot_cuendh['idtip_cuenta']) {
                                        echo '<option value="' . $arreglot_cuendh['idtip_cuenta'] . '" selected="selected">' . $arreglot_cuendh['tipo'] . '</option>';
                                    } else {
                                        ?>
                                        <option class="text" value="<?php echo $arreglot_cuendh['idtip_cuenta']; ?>">
                                            <?php echo $arreglot_cuendh['tipo']; ?></option>     
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </td>
                    </p>
                    </tr>                              
                    <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="tablaDatos" id="tblDatos">
                        <tbody>   
                            <tr>
                        <thead>
                        <td style="display:none">Asiento</td>
                        <td>Cod_Cuenta</td>
                        <td>Cuenta</td>
                        <td>Fecha</td>
                        <td>Debe</td>
                        <td>Haber</td>
                        <td style="display:none">bl</td>
                        <td style="display:none">Grupo</td>
                        <td style="display:none">log</td> 
                        <td>    </td> 
                        </thead>
                        </tr>
                        <tr id="datos">

                        </tr> 

                        <tr>
                        <tfoot>
                        <td></td>
                        <td></td>
                        <td> <strong>Total :</strong> </td>
                        <td>
                            <input type="text"  readonly="readonly" class="compa3" name="camposumadebe" id="camposumadebe" value=""/> 
                        </td>
                        <td>
                            <input type="text"  readonly="readonly" class="compa3" name="camposumahaber" id="camposumahaber" value=""/>
                        </td>
                        </tfoot>            
                        </tr>
                        </tbody>
                    </table>
                    <!--final tabla asientos-->
                </table>
            </fieldset>
        </fieldset>
    </form>
    <?php
}
$c->close();
?>