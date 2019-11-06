<?php
//reporteUbicaciones
function insertarDatos($almacen,$ubicacion,$pasillo,$estanteria,$balda,$hueco,$ubicacion_de_destino,$tipo_de_ubicacion,$numero_max_de_pallets,$entrada_bloqueada,$salida_bloqueada,$espacio_disponible)
{
        global $bd;
        $sql = "INSERT INTO reporteUbicaciones(almacen,ubicacion, pasillo, estanteria, balda, hueco, ubicacion_de_destino, tipo_de_ubicacion, numero_max_de_pallets, entrada_bloqueada, salida_bloqueada, espacio_disponible ) VALUES ('$almacen','$ubicacion','$pasillo','$estanteria','$balda','$hueco','$ubicacion_de_destino','$tipo_de_ubicacion','$numero_max_de_pallets','$entrada_bloqueada','$salida_bloqueada','$espacio_disponible')";
        $ejecutar = mysqli_query($bd,$sql);
        return $ejecutar;
    
    
}

function limpiarDatos()
{
    global $bd;
    $sql = "truncate table reporteUbicaciones";
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