<?php
//reporteUbicaciones

function insertarDatos($cedula, $nombres, $cargo, $linea, $areaterapeutica, $centrocosto, $regional)
{
        global $bd;
        $sql =  "INSERT INTO empleadolg (cedula, nombres, cargo, lineaE, areaterapeutica, centrocosto, regional) VALUES ('$cedula', '$nombres', '$cargo', '$linea', '$areaterapeutica', '$centrocosto', '$regional')";
        $ejecutar = mysqli_query($bd,$sql);
        return $ejecutar;
    
    
}

function limpiarDatos()
{
    global $bd;
    $sql = "truncate table empleadolg";
    $ejecutar = mysqli_query($bd,$sql);
    return $ejecutar;
    
}


function datosArchivo($ArchivoGuardado, $fechaActual, $userid )
{
    global $bd;
    $sql="INSERT INTO tbl_archivos(nombre_Archivo,fechaActual, usuario) VALUES('$ArchivoGuardado', '$fechaActual', $userid )";
    mysqli_query($bd, $sql);
    
    
}




?>