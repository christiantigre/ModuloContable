<?php
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../login.php"
</script>';
}
$idlogeobl = $_SESSION['id_user'];
$ass = $_GET['ass'];
$y = $_GET['y'];
$m = $_GET['m'];
$d = $_GET['d'];
$bl = $_GET['bl'];
$f = $_GET['f'];
if ($m == '1') {
    $ms = '01';
}
if ($m == '2') {
    $ms = '02';
}
if ($m == '3') {
    $ms = '03';
}
if ($m == '4') {
    $ms = '04';
}
if ($m == '5') {
    $ms = '05';
}
if ($m == '6') {
    $ms = '06';
}
if ($m == '7') {
    $ms = '07';
}
if ($m == '8') {
    $ms = '08';
}
if ($m == '9') {
    $ms = '09';
}
if ($m == '10') {
    $ms = '10';
}
if ($m == '11') {
    $ms = '11';
}
if ($m == '12') {
    $ms = '12';
}
$fecha = $y . '-' . $ms . '-' . $d;
require '../../../templates/Clases/Conectar.php';
$c = new Conectar();
$dbi = $c->conexion();


?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Asiento # <?Php
                echo $ass;
                echo '  - / -  ';
                ?> Fecha : <?Php echo $f; ?></div>
            <datalist id="cuenta">
                <?php
                $query = "SELECT * FROM `t_plan_de_cuentas` order by `t_clase_cod_clase`,`t_grupo_cod_grupo`,`t_cuenta_cod_cuenta`,`t_subcuenta_cod_subcuenta`,`t_auxiliar_cod_cauxiliar`,`t_subauxiliar_cod_subauxiliar` DESC";
                $resul1 = mysqli_query($dbi, $query);
                while ($dato1 = mysqli_fetch_array($resul1)) {
                    $cod1 = $dato1['cod_cuenta'];
                    echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                    echo $dato1['cod_cuenta'] . '      ' . utf8_decode($dato1['nombre_cuenta_plan']);
                    echo '</option>';
                }
                ?>
            </datalist>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <form role="form" class="form-control" id="form" name="form" method="POST" action="new_trs.php">
                            <!--<button type="button" class="btn btn-default" onclick="agregar_trs();">INSERTAR</button>-->
                            <button type="submit" class="btn btn-default" onclick="rr_agregar_new();">INSERTAR</button>
                            <input type="hidden" name="datetimepickert" id="datetimepickert" value="<?Php echo $f; ?>" />                   
                            <input type="hidden" name="mest" id="mest" value="<?Php echo $ms; ?>" />                   
                            <input type="hidden" name="asiento_numt" id="asiento_numt" value="<?Php echo $ass; ?>" /> 
                            <input type="hidden" name="idlogt" id="idlogt" readonly="readonly" value="<?php echo $idlogeobl ?>"/>
                            <input type="hidden" class="texto" name="balances_realizadost" id="balances_realizadost" value="<?Php echo $bl; ?>"/>
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <td>
                                        <label class="control-label">Cod. Cuenta</label>
                                        <div class="input-group">
                                            <input type="text" onblur="rr_compr_t()" list="cuenta" name="cod_cuentat" id="cod_cuentat" class="form-control" value="" placeholder="Ingrese Cod Cuenta..."/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" onclick="" type="button" id="btnver">Ver!</button>
                                            </span>
                                        </div>
                                    </td>
                                </tr> 
                                <tr> 
                                    <td>
                                        <div class="form-group">
                                            <label>Cuenta</label>
                                            <input class="form-control" readonly="readonly" type="text" id="nom_cuentat" name="nom_cuentat" value="">
                                        </div>
                                    </td>
                                </tr> 
                                <tr> 
                                    <td>
                                        <div class="col-xs-8">
                                            <label>Grupo</label>
                                            <input class="form-control" readonly="readonly" type="text" id="nom_grupot" name="nom_grupot" value="">
                                        </div>
                                        <div class="col-xs-4">
                                            <label>Cod.</label>
                                            <input class="form-control" readonly="readonly" type="text" id="cod_grupot" name="cod_grupot" value="">
                                        </div>
                                    </td>
                                </tr> 
                                <tr> 
                                    <td>
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <?php
//                                            $db = $dbi->conexion();
                                            $SQLtipobaldh = "SELECT * FROM tip_cuenta";
                                            $query_tipo_bldh = mysqli_query($dbi, $SQLtipobaldh);
                                            ?>
                                            <select class="form-control" name="tip_cuentadht" id="tip_cuentadht">
                                                <?php while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) { ?>
                                                    <option class="text" value="<?php echo $arreglot_cuendh['idtip_cuenta']; ?>">
                                                        <?php echo $arreglot_cuendh['tipo']; ?></option>     
                                                    <?php
                                                }
                                                mysqli_close($db);
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>  
                                <tr>
                                    <td>
                                        <label>Valor</label>
                                        <div class="form-group input-group">
                                            <input type="text" class="form-control" onkeyup="validar(this.id);
                                                    Calcular();" id="valort" name="valort" value="">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
