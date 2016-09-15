<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Inicio</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="css/plugins/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--        <meta name="description" content="Modulo de Contabilidad" />
                <link rel="stylesheet" type="text/css" href="css/stylelog.css" />
                <script src="js/modernizr.custom11.63321.js"></script>-->
        <style>
            body {
                /*background: #563c55 url(images/blurred.jpg) no-repeat center top;*/
                background: #DDD url(images/blurred.jpg) no-repeat center top;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                background-size: cover;
            }
            .container > header h1,
            .container > header h2 {
                color: #fff;
                text-shadow: 0 1px 1px rgba(0,0,0,0.7);
            }
        </style>
    </head>
    <body>
        <div class="container" >
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <table style="float: right">
                            <tr>
                                <td align="right">
                                    <img src="images/uploads/logo.png" class="img-responsive img-rounded" style="width:419px;height: 80px; margin-top: 2px;"/>
                                </td>
                            </tr>
                        </table>
                        <table style="float: left">
                            <tr>                            
                                <td align="left">
                            <center><h1 id="grid-column-ordering"><strong>  Acceso al Modulo Contable  </strong></1></center> 
                            </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <!--<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-lock" onclick="up_log()" ></button>-->
                        <?Php
                        require_once './templates/logeo/frm_log.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>


    </form>
</section>

</div>
<!-- jQuery Version 1.11.0 -->
<script src="js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/plugins/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<!-- Custom Theme JavaScript -->
<script src="js/sb-admin-2.js"></script>

<script src="js/js.js"></script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><center> LOGIN </center> </h4>
            </div>
            <div class="modal-body" id="caja">

            </div>
        </div>
    </div>
</div>
</body>
</html>

