<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$conex = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
mysql_select_db("condata", $conex) or die("ERROR con la base de datos");
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../login.php"
</script>';
}
$id_usuario = $_SESSION['username'];
$consulta = "SELECT l.username, u.tipo_user,l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.username = '" . $id_usuario . "'";
$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$fila = mysql_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
$idlogeobl = $fila['idlogeo'];
mysql_close($conex);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Balance Inicial</title>
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../../css/style.csss" rel='stylesheet' type='text/css' />
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/jquery-1.3.1.min.js"></script>
        <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../js/jquery.functions.js" type="text/javascript"></script>
        <style type="text/css"> #tabla{	border: solid 1px #333;	width: 300px; }#tabla tbody tr{ background: #999; }.fila-base{ display: none; } /* fila base oculta */.eliminar{ cursor: pointer; color: #000; }input[type="text"]{ width: 80px; } /* ancho a los elementos input="text" */</style>
            <SCRIPT language="javascript">

          function addRow(tableID) {

               var table = document.getElementById(tableID);

 

               var rowCount = table.rows.length;

               var row = table.insertRow(rowCount);

 

               var cell1 = row.insertCell(0);

               var element1 = document.createElement("input");

               element1.type = "checkbox";

               cell1.appendChild(element1);

 

               var cell2 = row.insertCell(1);

               var element2 = document.createElement("input");

               element2.type = "text";

               cell2.appendChild(element2);

          }

 

          function deleteRow(tableID) {

               try {

               var table = document.getElementById(tableID);

               var rowCount = table.rows.length;

 

               for(var i=0; i<rowCount; i++) {

                    var row = table.rows[i];

                    var chkbox = row.cells[0].childNodes[0];

                    if(null != chkbox && true == chkbox.checked) {

                         table.deleteRow(i);

                         rowCount--;

                         i--;

                    }

               }

               }catch(e) {

                    alert(e);

               }

          }

 

     </SCRIPT>
    </head>
    <body>
        <div id="header"> 
            <div id="menu_contable">
                <div class="menu">
                    <ul class="nav" id="nav">
                        <li><a href="../../index.php">Panel</a></li>
                        <li class="current"><a href="../PaneldeAdministrador/funcionesdeadministrador/catalogodecuentas.php">Plan de Ctas</a></li>
                        <li><a href="services.html">Usuarios</a></li>
                        <li><a href="contact.html">Documentos</a></li>								
                        <div class="clearfix"></div>
                    </ul>
                </div>
                <div>
                    <center><h1>Modulo de Contabilidad</h1></center>
                </div>
            </div>
            <div id="menu_general">
                <div id="caja_us">
                    <center>
                        <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>&nbsp;</tr>
                            <tr>
                                <td colspan="2"><div align="right">Usuario: <span class="Estilo6">
                                            <strong><?php echo $_SESSION['username']; ?> </strong>
                                        </span>
                                        <input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeobl ?>"
                                    </div></td>            
                                <td colspan="2"><div align="right">Acceso de: <span class="Estilo6"><strong><?php echo $type_user; ?> </strong></span></div></td>
                                <td></td>
                                <td colspan="2"><div align="right">
                                        <a href="../../templates/logeo/desconectar_usuario.php">
                                            <img src="../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </center>

                </div>
                <div class="menu">
                    <ul class="nav" id="nav">
                        <li class="current"><a href="../../templates/ModuloContable/Bl_inicial.php">B Inicial</a></li>
                        <li><a href="../funcionesdeadministrador/plancuentas.php">Asientos</a></li>
                        <li><a href="services.html">Diario</a></li>
                        <li><a href="contact.html">B. Resultados</a></li>								
                        <li><a href="contact.html">Perdidas y Ganancias</a></li>								
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </div>
        </div>
    <center>        <h2>BALANCE INICIAL</h2>    </center>
        <center>
            <form>
<INPUT type="button" value="Add Row" onclick="addRow('dataTable');" />

 

     <INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable');" />

 

     <TABLE id="dataTable" width="350px" border="1">

          <TR>

               <TD><INPUT type="checkbox" NAME="chk"/></TD>

               <TD> <INPUT type="text" /> </TD>

          </TR>

     </TABLE>

</form>
<button>Add</button>
        </center>
        <?php
        // put your code here
        ?>
    </body>
</html>
