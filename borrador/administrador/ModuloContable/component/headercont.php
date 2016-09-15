<!DOCTYPE html>
<?Php
session_start();
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div id="contenedor_bl">
            <center>
                <div id="menus">
                    <div id="menu_contable">
                        <div class="menu">
                            <ul class="nav" id="nav">
                                <li><a href="../../index.php">Panel</a></li>
                                <li><a href="../PaneldeAdministrador/funcionesdeadministrador/plangrupos.php">Plan de Ctas</a></li>
                                <li><a href="../PaneldeAdministrador/documentos/documentos.php">Documentos</a></li>
                                <!--class="current">-->								
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
                                        <td colspan="2">
                                            <div align="right">Usuario: <span class="Estilo6">
                                                    <strong><?php echo $_SESSION['username']; ?> </strong>
                                                </span>
                                                <input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeobl ?>" />
                                            </div></td>            
                                        <td></td>
                                        <td colspan="2"><div align="right">
                                                <a href="../../templates/logeo/desconectar_usuario.php">
                                                    <img src="../../images/logout.png" title="Salir" alt="Salir" />
                                                </a> 
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </table>
                            </center>
                        </div>
                        <div class="menu">
                            <ul class="nav" id="nav">
                                <li><a href="../../templates/ModuloContable/star_balance.php">B Inicial</a></li>
                                <li><a href="../../templates/ModuloContable/Bl_inicial.php">Asientos</a></li>
                                <li><a href="../../templates/ModuloContable/automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="../../templates/ModuloContable/index_modulo_contable.php">Diario</a></li>
                                <li><a href="../../templates/ModuloContable/balancederesultados.php">B. Resultados</a></li>								
                                <li><a href="../../templates/ModuloContable/situacionfinal.php">Perdidas y Ganancias</a></li>								
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </div>
            </center>
        </div>

        <?php
        // put your code here
        ?>
    </body>
</html>
