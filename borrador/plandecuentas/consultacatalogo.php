<?php
require('../../Clases/cliente.class.php');
$objClase = new Clase;
$consulta = $objClase->mostrar_catalgogo_cuentas();
?>

<script type="text/javascript">
    $(document).ready(function () {
        // mostrar formulario de actualizar datos
        $("table tr .modi a").click(function () {
            $('#tabla').hide();
            $("#formulario").show();
            $.ajax({
                url: this.href,
                type: "GET",
                success: function (datos) {
                    $("#formulario").html(datos);
                }
            });
            return false;
        });

        // llamar a formulario nuevo
        $("#nuevo a").click(function () {
            $("#formulario").show();
            $("#tabla").hide();
            $.ajax({
                type: "GET",
                url: 'nuevo.php',
                success: function (datos) {
                    $("#formulario").html(datos);
                }
            });
            return false;
        });
    });

</script>
<!--
<span id="nuevo"><a href="newcuenta_detalle.php"><img src="../../../images/add.png" alt="Agregar dato" title="Nuevo registro"/></a></span>
-->

<table>
    <tr>
        <td><span id="refrescar"><a href="catalogodecuentas.php"><img src="../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
        </td>
        <td><a target="_blank" href="ModuloContable/impresiones/impplan.php?idlogeo=<?Php echo $idlogeo; ?>" class="btn btn-danger">Exportar a PDF</a>
        </td>
    </tr>
</table>


<table style="font: bold 90% monospace;">
    <tr>
        <th>Codigo Cta.</th>
        <th align="right" colspan="10">Cuenta</th>
    </tr>
    <?php
    if ($consulta) {
        while ($clase = mysqli_fetch_array($consulta)) {
            ?>
            <tr id="fila-<?php echo $clase['idt_plan_de_cuentas'] ?>">
                <td style="background-color: #e2ebef;"><?php echo $clase['cod_cuenta'] ?></td>
                <!--<td>-->
                <?php
                $ruta = $clase['nombre_cuenta_plan'];
                $cont = $clase['cod_cuenta'];
                $dato = str_replace('.', '', $cont, $n);
                $carpeta = str_replace('.', '', $ruta, $reemplazos);
                if ($n == 0) {
                    echo '<td align=left style="background-color: #e2ebef; font: bold 90% monospace;">';
                    echo $carpeta;
                    echo '</td>';
                }
                if ($n == 1) {
                    echo '<td align=left style="padding-left: 5px;padding-right: 5px;background-color: #FF3333;" >';
                    echo $carpeta;
                    echo '</td>';
                }
                if ($n == 2) {
                    echo '<td align=left style="padding-left: 25px;padding-right: 5px;background-color:	#CD5C5C;">';
                    echo $carpeta;
                    echo '</td>';
                }
                if ($n == 3) {
                    echo '<td align=left style="padding-left: 45px;padding-right: 5px;background-color: #99CC33;">';
                    echo $carpeta;
                    echo '</td>';
                }
                if ($n == 4) {
                    echo '<td align=left style="padding-left: 85px;padding-right: 5px;background-color:#CCFFCC;">';
                    echo $carpeta;
                    echo '</td>';
                }
                if ($n == 5) {
//                    echo '<td align=left style="padding-left: 105px;padding-right: 5px;background-color:#FFCCCC;">'; echo $carpeta; echo '</td>';
                    $cap = 70;
                    $cc = strlen($carpeta);
                    if ($cc > $cap) {
                        echo '<td align=left style="padding-left: 105px;padding-right: 5px;background-color:#FFCCCC;">';
                        echo substr($carpeta, 0, $cap) . '...';
                        echo '<a href="#modalform" rel="abrir" title="' . $clase['nombre_cuenta_plan'] . '">[más]</a></td>';
                    } else {
                        echo '<td align=left style="padding-left: 105px;padding-right: 5px;background-color:#FFCCCC;">';
                        echo $carpeta;
                        echo '</td>';
                    }
                }
                if ($n == 6) {
                    echo '<td align=left style="padding-left: 125px;padding-right: 5px;background-color: #FFFF99;">';
                    echo $carpeta;
                    echo '</td>';
                }
                //echo $carpeta
                ?>
                <!--</td>-->
            </tr>
            <?php
        }
    }
    ?>
