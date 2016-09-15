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
    <script src="../js/jquery-1.11.0.js"></script>
    <script>
        $(document).ready(function () {
            $("#texto1").keyup(function () {
                var value = $(this).val();
                $("#texto2").val(value);
            });
        });
    </script>
    <body>
        <form>
            <input type="text" name="caja" id="texto1" value="" />
            <input type="text" name="caja" id="texto2" value="" />
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>
