<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require '../../../templates/Clases/Conectar.php';
        $dbi = new Conectar();
        include './filtroestadoresultados.php';
        $objFiltro = new filtroestadoresultados();
        $fechadesde = "01-01-2016";
        $fechahasta = "22-03-2016";
        $objFiltro->filtroporperiodos($fechadesde, $fechahasta,$dbi);
        // put your code here
        ?>
    </body>
</html>
