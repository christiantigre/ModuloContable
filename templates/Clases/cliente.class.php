<?php

if (!isset($_SESSION)) {
    session_start();
}

class Clase {

    //constructor	
    var $con;
    var $dbi;

    function Clase() {
//        $this->con = new DBManager;
//        $this->dbi = new Conectar;
    }

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['loginu'], $_SESSION['clave'], 'condata');
        return $this->objconec;
    }

    function insertar($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_clase` (`nombre_clase`, `cod_clase`, `descrip_class`) VALUES ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "');");
        }mysqli_close($conn);
    }

    function insertarreslibro($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`res_librodiario` (`idres_librodiario` ,`tot_debe` ,`tot_haber` ,`t_bl_inicial_idt_bl_inicial`)VALUES ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "');");
        }mysql_close($this->con);
    }

    function insertcomprobacion($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`resbalanecomprobacion` (
`idresbalanecomprobacion` ,
`tdebe` ,
`thaber` ,
`tsdeudor` ,
`tsacreedor` ,
`t_bl_inicial_idt_bl_inicial`
)
VALUES (
null, '" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "'
);");
        }mysql_close($this->con);
    }

    function Updatoreslibro($campos, $ex_balan) {
        if ($this->con->conectar() == true) {
            return mysql_query("UPDATE `condata`.`res_librodiario` SET `idres_librodiario` = '" . $campos[0] . "',
`tot_debe` = '" . $campos[1] . "',
`tot_haber` = '" . $campos[2] . "' WHERE `res_librodiario`.`t_bl_inicial_idt_bl_inicial` ='" . $ex_balan . "'");
        }
    }

    function insertar_plan($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_plan_de_cuentas` (`idt_plan_de_cuentas` ,`cod_cuenta` ,`nombre_cuenta_plan` ,`descripcion_cuenta_plan` ,`t_clase_cod_clase` ,`t_grupo_cod_grupo` ,`t_cuenta_cod_cuenta` ,`t_subcuenta_cod_subcuenta` ,`t_auxiliar_cod_cauxiliar`)VALUES (NULL , '" . $campos[1] . "', '" . $campos[0] . "', '" . $campos[2] . "', '" . $campos[1] . "', NULL , NULL , NULL , NULL);");
        }mysqli_close($conn);
    }

    function insertargrupo($campos) {
        $conn = $this->conec_base();
        if ($conn == TRUE) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_grupo` (`nombre_grupo`, `cod_grupo`, `descrip_grupo`, `t_clase_cod_clase`) VALUES"
                    . " ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "');");
        }
    }

    function insertargrupo_plan($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_plan_de_cuentas` (`idt_plan_de_cuentas` , `cod_cuenta` , `nombre_cuenta_plan` ,`descripcion_cuenta_plan` ,`t_clase_cod_clase` ,`t_grupo_cod_grupo` ,`t_cuenta_cod_cuenta` ,`t_subcuenta_cod_subcuenta` ,`t_auxiliar_cod_cauxiliar`)VALUES (NULL , '" . $campos[1] . "', '" . $campos[0] . "', '" . $campos[2] . "', '" . $campos[3] . "' , '" . $campos[1] . "', NULL , NULL , NULL);");
        }
    }

    function insertar_new_usuario($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`usuario` (
`idusuario` ,
`nombre` ,
`apellido` ,
`email` ,
`nacionalidad` ,
`cargo` ,
`foto` ,
`fecha_nacimiento` ,
`cedula` ,
`telefono` ,
`celular` ,
`Descrip_user`
)
VALUES (
'" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "', '" . $campos[5] . "' , '" . $campos[6] . "', '" . $campos[7] . "',
    '" . $campos[8] . "', '" . $campos[9] . "', '" . $campos[10] . "', '" . $campos[11] . "'
);");
        }
    }

    function insertar_new_login($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`logeo` (
`idlogeo` ,
`password` ,
`username` ,
`user_tipo_iduser_tipo` ,
`usuario_idusuario`
)
VALUES (
'" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "'
);");
        }
    }

    function insertar_cat_user($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`user_tipo` (`iduser_tipo` , `tipo_user` ,`descrip_user` ,`cod_user`)VALUES ('" . $campos[2] . "', '" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "');");
        } mysqli_close($conn);
    }

    function insertarcuenta($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_cuenta` (`nombre_cuenta` ,`cod_cuenta` ,`descrip_cuenta` ,`t_grupo_cod_grupo`)VALUES ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "');");
        } mysqli_close($conn);
    }

    function insertarsubcuenta($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_subcuenta` (`nombre_subcuenta` ,`cod_subcuenta` ,`descrip_subcuenta` ,`t_cuenta_cod_cuenta`,`t_grupo_cod_grupo`)VALUES ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "','" . $campos[4] . "');");
        }mysqli_close($conn);
    }

    function insertarbalance_ini($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            $year = date("Y");
            return mysqli_query($conn, "INSERT INTO `condata`.`t_bl_inicial` (`idt_bl_inicial` ,`fecha_balance` ,`logeo_idlogeo`,year,estado)VALUES "
                    . "('" . $campos[0] . "', '" . date("Y-m-d") . "', '" . $campos[2] . "' , '" . $year . "',1);");
        }mysqli_close($conn);
    }

    function insertarcuentaauxiliar($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_auxiliar` "
                    . "(`nombre_cauxiliar` ,`cod_cauxiliar` ,`descrip_auxiliar` ,`t_subcuenta_cod_subcuenta` ,`t_cuenta_cod_cuenta` ,"
                    . "`t_grupo_cod_grupo` ,`t_clase_cod_clase`,placa_id,cli_id)VALUES ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', "
                    . "'" . $campos[3] . "', '" . $campos[4] . "', '" . $campos[5] . "', '" . $campos[6] . "','".$campos[7]."','".$campos[8]."');");
        }mysqli_close($conn);
    }

    function insertarcuentasubauxiliar($campos) {
        $conn = $this->conec_base();
        $sql = "INSERT INTO `t_subauxiliar` (`nom_cuenta`, `cod_subauxiliar`, `t_auxiliar_cod_cauxiliar`, `descrip`, "
                . "`t_subcuenta_cod_subcuenta`, `t_cuenta_cod_cuenta`, `t_grupo_cod_grupo`, `t_clase_cod_clase`) VALUES"
                . " ('" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "', '" . $campos[5] . "', '" . $campos[6] . "', '" . $campos[7] . "');";
        if (mysqli_query($conn, $sql)) {
            return $sql;
        }mysqli_close($conn);
    }

    function insertarcuenta_plansubaux($campos) {
        $conn = $this->conec_base();
        $sql = "INSERT INTO `condata`.`t_plan_de_cuentas` (
`cod_cuenta` ,
`nombre_cuenta_plan` ,
`descripcion_cuenta_plan` ,
`t_subauxiliar_cod_subauxiliar`,
`t_auxiliar_cod_cauxiliar` ,
`t_subcuenta_cod_subcuenta` ,
`t_cuenta_cod_cuenta` ,
`t_grupo_cod_grupo` ,
`t_clase_cod_clase` 
)
VALUES ('" . $campos[1] . "', '" . $campos[0] . "', '" . $campos[3] . "',"
                . " '" . $campos[1] . "','" . $campos[2] . "', '" . $campos[4] . "', '" . $campos[5] . "', '" . $campos[6] . "', '" . $campos[7] . "'
);";
        if (mysqli_query($conn, $sql)) {
            return $sql;
        }mysqli_close($conn);
    }

    function insertarbl_ac_pas($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`t_ejercicio` (
`idt_corrientes` ,
`ejercicio` ,
`cod_cuenta` ,
`cuenta` ,
`fecha` ,
`valor` ,
`t_bl_inicial_idt_bl_inicial` ,
`tipo`,
`logeo_idlogeo`
)
VALUES (
NULL , '" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "', '" . $campos[5] . "',"
                    . " '" . $campos[6] . "', '" . $campos[7] . "'
);");
        }
    }

    function insertarbl_ac_pasp($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`t_ejercicio` (
`idt_corrientes` ,
`ejercicio` ,
`cod_cuenta` ,
`cuenta` ,
`fecha` ,
`valorp` ,
`t_bl_inicial_idt_bl_inicial` ,
`tipo`,
`logeo_idlogeo`
)
VALUES (
NULL , '" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "', '" . $campos[5] . "',"
                    . " '" . $campos[6] . "','" . $campos[7] . "'
);");
        }
    }

    function insertarasientoaldiarioA($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`libro` (
`idlibro` ,
`fecha` ,
`asiento` ,
`ref` ,
`cuenta` ,
`debe` ,
`haber` ,
`t_bl_inicial_idt_bl_inicial` ,
`t_cuenta_idt_cuenta`,
`grupo`
)
VALUES (
'" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "', '" . $campos[5] . "','0.00',
    '" . $campos[6] . "', '" . $campos[7] . "','" . $campos[8] . "');");
        }
    }

    function insertarasientoaldiarioP($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`libro` (
`idlibro` ,
`fecha` ,
`asiento` ,
`ref` ,
`cuenta` ,
`debe` ,
`haber` ,
`t_bl_inicial_idt_bl_inicial`,
`t_cuenta_idt_cuenta`,
`grupo`
)
VALUES (
'" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "','0.00', '" . $campos[5] . "',
                    '" . $campos[6] . "','" . $campos[7] . "','" . $campos[8] . "');");
        }
    }

    function insertarresultadobalance($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`resultadosbalance` (
`idresultadosbalance` ,
`resdebe` ,
`reshaber` ,
`t_bl_inicial_idt_bl_inicial`
)
VALUES (
NULL , '" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "'
);");
        }
    }

    function insertarbl_pasivos($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`blnini_pasivos` (
`idBlnIni_Pasivos` ,
`asiento` ,
`cod_cuenta` ,
`cuenta` ,
`Pas_debe` ,
`pas_haber` ,
`t_bl_inicial_idt_bl_inicial` ,
`t_plan_de_cuentas_idt_plan_de_cuentas`
)
VALUES (
NULL, '" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "', '" . $campos[5] . "','" . $campos[6] . "'
);");
        }
    }

    function insertarcuenta_plan($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_plan_de_cuentas` ( `idt_plan_de_cuentas` , `cod_cuenta` , `nombre_cuenta_plan` , `descripcion_cuenta_plan` , `t_clase_cod_clase` , `t_grupo_cod_grupo` , `t_cuenta_cod_cuenta` , `t_subcuenta_cod_subcuenta` , `t_auxiliar_cod_cauxiliar`) VALUES ( NULL , '" . $campos[1] . "', '" . $campos[0] . "', '" . $campos[2] . "', NULL , '" . $campos[3] . "' , '" . $campos[1] . "', NULL , NULL);");
        } mysqli_close($conn);
    }

    function insertarcuenta_plansub($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_plan_de_cuentas`"
                    . " (`idt_plan_de_cuentas` ,`cod_cuenta` ,`nombre_cuenta_plan` ,`descripcion_cuenta_plan` ,`t_clase_cod_clase` ,`t_grupo_cod_grupo` ,"
                    . "`t_cuenta_cod_cuenta` ,`t_subcuenta_cod_subcuenta` ,`t_auxiliar_cod_cauxiliar`)VALUES (null, '" . $campos[1] . "', '" . $campos[0] . "', '" . $campos[2] . "' , NULL , '" . $campos[4] . "' , '" . $campos[3] . "' , '" . $campos[1] . "', NULL);");
        } mysqli_close($conn);
    }

    function insertarcuenta_planaux($campos) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "INSERT INTO `condata`.`t_plan_de_cuentas` (`idt_plan_de_cuentas` ,`cod_cuenta` ,`nombre_cuenta_plan` ,`descripcion_cuenta_plan` ,`t_clase_cod_clase` ,`t_grupo_cod_grupo` ,`t_cuenta_cod_cuenta` ,`t_subcuenta_cod_subcuenta` ,`t_auxiliar_cod_cauxiliar` ,`t_subauxiliar_cod_subauxiliar`)VALUES (null, '" . $campos[1] . "', '" . $campos[0] . "', '" . $campos[2] . "', '" . $campos[3] . "', '" . $campos[4] . "', '" . $campos[5] . "', '" . $campos[6] . "', '" . $campos[1] . "', 'NULL');");
        } mysqli_close($conn);
    }

    function insertarcuentaaux($campos) {
        if ($this->con->conectar() == true) {
            return mysql_query("INSERT INTO `condata`.`t_auxiliar` (
`idt_auxiliar` ,
`nombre_cauxiliar` ,
`cod_cauxiliar` ,
`descrip_auxiliar`
)
VALUES (
NULL , '" . $campos[0] . "', '" . $campos[1] . "', '" . $campos[2] . "'
);");
        }
    }

    function actualizar($campos, $cod_clase) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "UPDATE `condata`.`t_clase` SET `nombre_clase` = '" . $campos[0] . "',`cod_clase` = '" . $campos[1] . "',`descrip_class` = '" . $campos[2] . "' WHERE CONVERT( `t_clase`.`cod_clase` USING utf8 ) =" . $cod_clase);
        } mysqli_close($conn);
    }

    function actualizargrupo($campos, $idt_grupo) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "UPDATE `condata`.`t_grupo` SET `nombre_grupo` = '" . $campos[0] . "',`descrip_grupo` = '" . $campos[1] . "' WHERE CONVERT( `t_grupo`.`cod_grupo` USING utf8 ) = '" . $idt_grupo . "' LIMIT 1 ;");
        } mysqli_close($conn);
    }

    function actualizargrupoplan($campos, $idt_grupo) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "UPDATE `condata`.`t_plan_de_cuentas` SET `nombre_cuenta_plan` = '" . $campos[0] . "',`descripcion_cuenta_plan` = '" . $campos[1] . "' WHERE CONVERT( `t_plan_de_cuentas`.`cod_cuenta` USING utf8 ) = '" . $idt_grupo . "' LIMIT 1 ;");
        } mysqli_close($conn);
    }

    function actualizar_categoria($campos, $cod_user) {
        if ($this->con->conectar() == true) {
            return mysql_query("UPDATE `condata`.`user_tipo` SET `tipo_user` = '" . $campos[0] . "', `descrip_user` = '" . $campos[1] . "' WHERE `user_tipo`.`iduser_tipo` ='" . $cod_user . "' LIMIT 1 ;");
        }
    }

    function actualizar_usuario($campos, $idusuario) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "UPDATE `condata`.`usuario` SET `nombre` = '" . $campos[0] . "',`apellido` = '" . $campos[1] . "',`email` = '" . $campos[2] . "',`nacionalidad` = '" . $campos[3] . "',`cargo` = '" . $campos[4] . "',`foto` = '" . $campos[5] . "',`fecha_nacimiento` = '" . $campos[6] . "',`cedula` = '" . $campos[7] . "',`telefono` = '" . $campos[8] . "',`celular` = '" . $campos[9] . "',`Descrip_user` = '" . $campos[10] . "' WHERE `usuario`.`idusuario` ='" . $idusuario . "' LIMIT 1 ;");
        } mysqli_close($conn);
    }

    function actualizar_cuenta_log($campos, $idlogeo) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "UPDATE `condata`.`logeo` SET `password` = '" . $campos[0] . "', `username` = '" . $campos[1] . "' WHERE `logeo`.`idlogeo` ='" . $idlogeo . "' LIMIT 1 ;");
        }mysqli_close($conn);
    }

    function actualizarcuenta($campos, $idt_cuenta) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "UPDATE `condata`.`t_cuenta` SET `nombre_cuenta` = '" . $campos[0] . "',`descrip_cuenta` = '" . $campos[1] . "' WHERE CONVERT( `t_cuenta`.`cod_cuenta` USING utf8 ) = '" . $idt_cuenta . "' LIMIT 1 ;");
        } mysqli_close($conn);
    }

    function actualizarcuentaaux($campos, $idt_auxiliar) {
        if ($this->con->conectar() == true) {
            return mysql_query("UPDATE `condata`.`t_auxiliar` SET `nombre_cauxiliar` = '" . $campos[0] . "',
`cod_cauxiliar` = '" . $campos[1] . "',
`descrip_auxiliar` = '" . $campos[2] . "' WHERE `t_auxiliar`.`idt_auxiliar` =" . $idt_auxiliar);
        }
    }

    function actualizarsubcuenta($campos, $idt_subcuenta) {
        if ($this->con->conectar() == true) {
            return mysql_query("UPDATE `condata`.`t_subcuenta` SET `nombre_subcuenta` = '" . $campos[0] . "',
`cod_subcuenta` = '" . $campos[1] . "',
`descrip_subcuenta` = '" . $campos[2] . "' WHERE `t_subcuenta`.`idt_subcuenta` =" . $idt_subcuenta);
        }
    }

    function mostrar_clase($cod_clase) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM `t_clase` WHERE `cod_clase` =" . $cod_clase);
        }mysqli_close($conn);
    }

    function mostrar_categoria($cod_user) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM `user_tipo` WHERE `cod_user` =" . $cod_user);
        } mysqli_close($conn);
    }

    function mostrar_cuentaaux($idt_auxiliar) {
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT *
FROM `t_auxiliar`
WHERE `idt_auxiliar` =" . $idt_auxiliar);
        }
    }

    function mostrar_grupo($idt_grupo) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM `t_grupo` WHERE `cod_grupo`='" . $idt_grupo . "'");
        }
    }

    function mostrar_cuenta($cod_cuenta) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM `t_cuenta` WHERE `cod_cuenta`='" . $cod_cuenta . "'");
        } mysqli_close($conn);
    }

    function mostrar_subcuenta($idt_subcuenta) {
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT *
FROM `t_subcuenta`
WHERE `idt_subcuenta` =" . $idt_subcuenta);
        }
    }

    function mostrar_usuario($idusuario) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM `usuario` u, logeo l where u.idusuario = l.usuario_idusuario  and u.`idusuario` =" . $idusuario);
        } mysqli_close($conn);
    }

    function mostrar_asientos() {
        $dates = date("Y-m-j");
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT bi.idt_bl_inicial AS asi, bi.fecha_balance AS fecha, ba.asiento AS asiento, ba.cod_cuenta AS cod, ba.cuenta AS cuen, ba.Ac_debe AS Deb, ba.Ac_haber AS hab
FROM blnini_activos ba
JOIN t_bl_inicial bi
WHERE ba.`t_bl_inicial_idt_bl_inicial` = bi.idt_bl_inicial
AND bi.fecha_balance = '" . $dates . "'
ORDER BY ba.asiento ASC");
        }
    }

    function mostrar_asientos_pasivos() {
        $dates = date("Y-m-j");
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT bi.idt_bl_inicial AS asi, bi.fecha_balance AS fecha,
                ba.asiento AS asiento, ba.cod_cuenta AS cod, ba.cuenta AS cuen, ba.Pas_debe AS Deb, ba.pas_haber AS hab
FROM blnini_pasivos ba
JOIN t_bl_inicial bi
WHERE ba.`t_bl_inicial_idt_bl_inicial` = bi.idt_bl_inicial
AND bi.fecha_balance = '" . $dates . "'
ORDER BY ba.asiento ASC");
        }
    }

    function mostrar_cuenta_log($idlogeo) {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT u.idusuario as idus,l.idlogeo AS idlogeo, l.username AS Username, l.password AS Contrasena, t.tipo_user AS Clase, concat( u.nombre, ' ', u.apellido ) AS Nombre, u.cedula AS CI, u.foto AS Foto FROM logeo l JOIN user_tipo t JOIN usuario u WHERE l.user_tipo_iduser_tipo = t.iduser_tipo AND l.usuario_idusuario = u.idusuario AND l.idlogeo='" . $idlogeo . "'");
        } mysqli_close($conn);
    }

    function mostrar_clases() {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM t_clase");
        }
    }

    function mostrar_catalgogo_cuentas() {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT idt_plan_de_cuentas, cod_cuenta, nombre_cuenta_plan, `descripcion_cuenta_plan` FROM `t_plan_de_cuentas` ORDER BY cod_cuenta");
        } mysqli_close($conn);
    }

    function mostrar_usuarios() {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT idusuario,concat(nombre,' ',apellido) as Usuario, cedula,email,cargo,foto,celular,telefono,Descrip_user FROM usuario where idusuario!='1'");
        } mysqli_close($conn);
    }

    function mostrar_logeos() {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT l.idlogeo AS idlogeo, l.username AS Username, l.password AS Contrasena, t.tipo_user AS Clase, concat( u.nombre, ' ', u.apellido ) AS Nombre, u.cedula AS CI, u.foto AS Foto FROM logeo l JOIN user_tipo t JOIN usuario u WHERE l.user_tipo_iduser_tipo = t.iduser_tipo AND l.usuario_idusuario = u.idusuario");
        } mysqli_close($conn);
    }

    function mostrar_grupos() {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM t_grupo");
        }mysqli_close($conn);
    }

    function mostrar_cuentas() {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM t_cuenta");
        } mysqli_close($conn);
    }

    function mostrar_plan_de_cuentas() {
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT * FROM `t_plan_cuentas`");
        }
    }

    function mostrar_cuentasaux() {
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT * FROM t_auxiliar");
        }
    }

    function mostrar_subcuentas() {
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT * FROM t_subcuenta");
        }
    }

    function mostrar_categorias() {
        $conn = $this->conec_base();
        if ($conn == true) {
            return mysqli_query($conn, "SELECT * FROM `user_tipo` WHERE cod_user != '1'");
        } mysqli_close($conn);
    }

    function eliminar($cod_clase) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `t_clase` WHERE `t_clase`.`cod_clase` = " . $cod_clase);
        }
    }

    function eliminarcategoria($cod_user) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `user_tipo` WHERE `user_tipo`.`iduser_tipo` = '" . $cod_user . "' LIMIT 1");
        }
    }

    function eliminarusuario($idusuario) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `usuario` WHERE `usuario`.`idusuario` = '" . $idusuario . "' LIMIT 1");
        }
    }

    function eliminar_c_login($idlogin) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `logeo` WHERE `logeo`.`idlogeo` = '" . $idlogin . "' LIMIT 1");
        }
    }

    function eliminargrupo($idt_grupo) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `t_grupo` WHERE CONVERT(`t_grupo`.`cod_grupo` USING utf8)"
                    . " = '$idt_grupo' LIMIT 1");
        }
    }

    function eliminarcuenta($idt_cuenta) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `t_cuenta` WHERE "
                    . "CONVERT(`t_cuenta`.`cod_cuenta` USING utf8) = '" . $idt_cuenta . "' LIMIT 1");
        }
    }

    function eliminarclase($idt_cuenta) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `t_clase` WHERE `t_clase`.`cod_clase`= " . $idt_cuenta);
        }
    }

    function eliminarsubcuenta($idt_subcuenta) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `t_subcuenta` WHERE `t_subcuenta`.`idt_subcuenta`= " . $idt_subcuenta);
        }
    }

    function eliminarcuentaaux($idt_auxiliar) {
        if ($this->con->conectar() == true) {
            return mysql_query("DELETE FROM `t_auxiliar` WHERE `t_auxiliar`.`idt_auxiliar`= " . $idt_auxiliar);
        }
    }

    function sumar_valor_clase($cod_clase) {
        if ($this->con->conectar() == true) {
            return mysql_query("SELECT MAX( `cod_clase` ) +1 AS id FROM t_clase");
        }
    }

}

?>