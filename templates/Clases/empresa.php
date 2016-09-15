<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

class Empresa {

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['loginu'], $_SESSION['clave'], 'condata');
        return $this->objconec;
    }

    function ver_empress() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            ?>
            <p style="font-size:12px; text-align: left">
            <center><H2>INFORMACI&Oacute;N DE EMPRESA</H2></center>
            <input type="hidden" class="text" name="nomempress" value="<?Php echo $datomarca['idempresa'] ?>"/>
            <label>EMPRESA :</label>&nbsp;&nbsp;<label class="alert-success"><?Php echo $datomarca['nombre'] ?></label><br/><!--<input type="text" class="text" name="nomempress" value="//<?Php echo $datomarca['nombre'] ?>"/><br/>-->
            <label>DIRECCI&Oacute;N :</label>&nbsp;&nbsp;<label class="alert-success"><?Php echo utf8_decode($datomarca['direccion']) ?></label><br/><!--<input type="text" class="text" name="nomempress" value="<?Php echo $datomarca['direccion'] ?>"/><br/>-->
            <label>EMAIL :</label>&nbsp;&nbsp;<label class="alert-success"><?Php echo $datomarca['email'] ?></label><br/> <!--<input type="text" class="text" name="nomempress" value="<?Php echo $datomarca['email'] ?>"/><br/>-->
            <label>RUC :</label>&nbsp;&nbsp;<label class="alert-success"><?Php echo $datomarca['ruc'] ?></label><br/>            <!--<input type="text" class="text" name="nomempress" value="<?Php echo $datomarca['ruc'] ?>"/><br/>-->
            <label>TELEFONO :</label>&nbsp;&nbsp;<label class="alert-success"><?Php echo $datomarca['telefono'] ?></label><br/>            <!--<input type="text" class="text" name="nomempress" value="<?Php echo $datomarca['telefono'] ?>"/><br/>-->
            <label>FAX :</label>&nbsp;&nbsp;<label class="alert-success"><?Php echo $datomarca['fax'] ?></label><br/>            <!--<input type="text" class="text" name="nomempress" value="<?Php echo $datomarca['fax'] ?>"/><br/>-->
            <label>PROPIETARIO :</label>&nbsp;&nbsp;<label class="alert-success"><?Php echo $datomarca['propietario'] ?></label><br/>            <!--<input type="text" class="text" name="nomempress" value="<?Php echo $datomarca['propietario'] ?>"/><br/>-->
            <label>FUNCION :</label>&nbsp;&nbsp;<label class="alert-success"><?Php echo $datomarca['funcion'] ?></label><br/>            <!--<input type="text" class="text" name="nomempress" value="<?Php echo $datomarca['funcion'] ?>"/><br/>-->
            <label>LOGO :</label>&nbsp;&nbsp;
            <img src="<?Php echo $datomarca['logo'] ?>" style="width: 250px;height: 60px;"/>
            </p>
            <CENTER> <input type="submit" class="btn btn-success" name="btnedit" value="EDITAR"/></CENTER>
            <?Php
        }
    }

    function edit_empress() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            ?>
            <p style="font-size:12px; text-align: left">
            <center><H2>EDITAR INFORMACI&Oacute;N DE EMPRESA</H2></center>
            <input type="hidden" class="form-control" name="idemp" value="<?Php echo $datomarca['idempresa'] ?>"/>
            <label>EMPRESA :</label>&nbsp;&nbsp;
            <input type="text" class="form-control" name="nomemp" value="<?Php echo $datomarca['nombre'] ?>"/><br/>
            <label>DIRECCI&Oacute;N :</label>&nbsp;&nbsp;
            <input type="text" class="form-control" name="diremp" value="<?Php echo utf8_decode($datomarca['direccion']) ?>"/><br/>
            <label>EMAIL :</label>&nbsp;&nbsp;
            <input type="text" class="form-control" name="mailemp" value="<?Php echo $datomarca['email'] ?>"/><br/>
            <label>RUC :</label>&nbsp;&nbsp;
            <input type="text" class="form-control" name="rucemp" value="<?Php echo $datomarca['ruc'] ?>"/><br/>
            <label>TELEFONO :</label>&nbsp;&nbsp;
            <input type="text" class="form-control" name="telemp" value="<?Php echo $datomarca['telefono'] ?>"/><br/>
            <label>FAX :</label>&nbsp;&nbsp;
            <input type="text" class="form-control" name="faxemp" value="<?Php echo $datomarca['fax'] ?>"/><br/>
            <label>PROPIETARIO :</label>&nbsp;&nbsp;
            <input type="text" class="form-control" name="propemp" value="<?Php echo $datomarca['propietario'] ?>"/><br/>
            <label>FUNCION :</label>&nbsp;&nbsp;
            <input type="text" class="form-control" name="funemp" value="<?Php echo $datomarca['funcion'] ?>"/><br/>
            <label>LOGO :</label><br/>&nbsp;&nbsp;
            <?PHP
            if ($datomarca['logo'] == 0) {
                echo '<input name="imagen" id="imagen" type="file">';
            } else {
                echo '<img src="../../../images/information.png" style="width: 45px;height: 25px;"/>';
            }
            ?>
            </p>
            <CENTER> 
                <input type="submit" class="btn btn-success" name="btnsave" value="GUARDAR"/>
                <input type="submit" class="btn btn-primary" name="btncalcel" value="CANCELAR"/>
            </CENTER>
            <?Php
        }
    }

    function save_emp($campo, $id) {
        $conn = $this->conec_base();
        $campo1 = $campo[1];
        $query = "UPDATE `condata`.`empresa` SET `nombre` = '" . $campo[0] . "', `direccion` = '" . $campo1 . "',"
                . " `ruc` = '" . $campo[2] . "', `email` = '" . $campo[3] . "', "
                . "`telefono` = '" . $campo[4] . "', `fax` = '" . $campo[5] . "', "
                . "`propietario` = '" . $campo[6] . "', `funcion` = '" . $campo[7] . "'"  //, logo='".$data."'
                . "  WHERE `empresa`.`idempresa` = '" . $id . "';";
        mysqli_query($conn, $query);
        mysqli_close($conn);
    }

    function upload_img($id) {
        $conn = $this->conec_base();
        $dir_destino = '../../../images/uploads/';
        $imagen_subida = $dir_destino . basename($_FILES['imagen']['name']);
        $tipo = $_FILES['imagen']['type'];
        if (!is_writable($dir_destino)) {
            echo '<label class="alert-danger">No se puede guardar en esta ruta...</label>';
        } else {
            if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_subida)) {
                    $resultado = mysqli_query($conn, "UPDATE `condata`.`empresa` SET `logo` = '" . $imagen_subida . "', `tipo` = '" . $tipo . "',"
                            . "nomimg='" . $_FILES['imagen']['name'] . "' WHERE `empresa`.`idempresa` = '" . $id . "'");
                    if ($resultado) {
                        echo '<label class="alert-success">El archivo ha sido copiado exitosamente.<label>';
                    } else {
                        echo '<label class="alert-danger">Ocurrió algun error al copiar el archivo.<label>';
                    }
                } else {
                    echo '<label class="alert-danger">Esta imagen no se mueve subir\n Rununda ' . $dir_destino . '...</label>';
                }
            } else {
                echo '<label class="alert-danger">Revise la ruta de imagenes ' . $dir_destino . '...</label>';
            }
        } mysqli_close($conn);
    }

    function view_logroot() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $fotonom = $datomarca['nomimg'];
            echo '<img src="../../../images/uploads/' . $fotonom . '" style="width: 650px;height: 100px;"/>';
        } mysqli_close($conn);
    }

    function logo_cl() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $fotonom = $datomarca['nomimg'];
            echo $fotonom;
        } mysqli_close($conn);
    }

    function view_log() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $fotonom = $datomarca['nomimg'];
            echo '<img src="images/uploads/' . $fotonom . '" style="width: 650px;height: 100px;"/>';
        } mysqli_close($conn);
    }

    function view_logimp() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $fotonom = $datomarca['nomimg'];
            echo '<img src="../../../../../images/uploads/' . $fotonom . '" style="width: 650px;height: 100px;"/>';
        } mysqli_close($conn);
    }

    function view_logadmin() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $fotonom = $datomarca['nomimg'];
            echo '<img src="../../images/uploads/' . $fotonom . '" class="img-responsive img-rounded" style="width:329px;height: 50px; margin-top: -15px;"/>';
        } mysqli_close($conn);
    }

    function view_logcontabilidad() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $fotonom = $datomarca['nomimg'];
            echo '<img src="../../../../images/uploads/' . $fotonom . '" class="img-responsive img-rounded" style="width:329px;height: 50px; margin-top: -15px;"/>';
        } mysqli_close($conn);
    }

    function view_logcontabilidad_ctas() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $fotonom = $datomarca['nomimg'];
            echo '<img src="../../../../../images/uploads/' . $fotonom . '" class="img-responsive img-rounded" style="width:329px;height: 50px; margin-top: -15px;"/>';
        } mysqli_close($conn);
    }

    function view_logadminsub() {
        $conn = $this->conec_base();
        $query = "SELECT * FROM empresa";
        $restrs = mysqli_query($conn, $query);
        while ($datomarca = mysqli_fetch_array($restrs, MYSQLI_BOTH)) {
            $fotonom = $datomarca['nomimg'];
            echo '<img src="../../../images/uploads/' . $fotonom . '" style="width: 650px;height: 100px;"/>';
        } mysqli_close($conn);
    }

}

//carga imagen en binario
//function update_img($id) {
//        $conn = $this->conec_base();
//        if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0) {
//            echo '<label class="alert-danger">Ha ocurrido un error con la imagen.</label>';
//        } else {            //Permitidos.  //No exceda los 16MB
//            $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
//            $limite_kb = 16384;
//            if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024) {
//                $imagen_temporal = $_FILES['imagen']['tmp_name'];
//                $tipo = $_FILES['imagen']['type'];
//                $fp = fopen($imagen_temporal, 'r+b');
//                $data = fread($fp, filesize($imagen_temporal));
//                fclose($fp);
//                $data = mysqli_escape_string($conn, $data);
////                $resultado = mysqli_query($conn, "UPDATE `condata`.`imagenes` SET `imagen` = '" . $data . "', `tipo_imagen` = '" . $tipo . "' WHERE `imagenes`.`idimagenes` = '" . $id . "'");
//                $resultado = mysqli_query($conn, "UPDATE `condata`.`empresa` SET `logo` = '" . $data . "', `tipo` = '" . $tipo . "' WHERE `empresa`.`idempresa` = '" . $id . "'");
//                if ($resultado) {
//                    echo '<label class="alert-success">La imagen ha sido copiado exitosamente.<label>';
//                } else {
//                    echo '<label class="alert-success">Ocurrió algun error al copiar la imagen.<label>';
//                }
//            } else {
//                echo '<label class="alert-danger">Formato de imagen no permitido o excede el tamaño límite de $limite_kb Kbytes.</label>';
//            }
//        } mysqli_close($conn);
//    }
//    function upload_img() {
//        $conn = $this->conec_base();
//        if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0) {
//            echo '<label class="alert-danger">Ha ocurrido un error.</label>';
//        } else {            //Permitidos.  //No exceda los 16MB
//            $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
//            $limite_kb = 16384;
//            if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024) {
//                $imagen_temporal = $_FILES['imagen']['tmp_name'];
//                $tipo = $_FILES['imagen']['type'];
//                $fp = fopen($imagen_temporal, 'r+b');
//                $data = fread($fp, filesize($imagen_temporal));
//                fclose($fp);
//                $data = mysqli_escape_string($conn, $data);
//                $resultado = mysqli_query($conn, "INSERT INTO imagenes (imagen, tipo_imagen) VALUES ('$data', '$tipo')");
//                if ($resultado) {
//                    echo '<label class="alert-success">El archivo ha sido copiado exitosamente.<label>';
//                } else {
//                    echo '<label class="alert-success">Ocurrió algun error al copiar el archivo.<label>';
//                }
//            } else {
//                echo '<label class="alert-danger">Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.</label>';
//            }
//        } mysqli_close($conn);
//    }
            