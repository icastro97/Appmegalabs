<?php
//reporteUbicaciones

function insertarDatos($u_username, $u_password, $full_name, $u_rolecode, $created, $modified, $status, $remember_key, $forgot_pass_identity, $email, $cedula, $ubicacionFirma)
{
        global $bd;
        $sql =  "INSERT INTO system_users (  `u_username`, `u_password`, `full_name`, `u_rolecode`, `created`, `modified`, `status`, `remember_key`, `forgot_pass_identity`, `email`, `cedula`) VALUES ('$u_username', '$u_password', '$full_name', '$u_rolecode', '', '', 1, '','', '$email', '$cedula')";
        var_dump($sql);
        $ejecutar = mysqli_query($bd,$sql);
       
        if($ejecutar)
        {
            echo "si";
        }
        else
        {
            var_dump(mysqli_error($bd));
        }
    
    
}



function datosArchivo($ruta,$ArchivoGuardado, $fechaActual, $userid )
{
    global $bd;
    $sql="INSERT INTO tbl_archivos(ruta, nombre_Archivo,fechaActual, usuario) VALUES('$ruta','$ArchivoGuardado', '$fechaActual', $userid )";
    mysqli_query($bd, $sql);
    
    
}




?>