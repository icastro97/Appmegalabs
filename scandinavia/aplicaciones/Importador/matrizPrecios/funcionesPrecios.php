<?php
//reporteUbicaciones

function insertarDatos($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n)
{
        global $bd;
        $sql =  "INSERT INTO `matrizPrecios`(`codigo_axapta`, `nombre_comercial`, `principio`, `contenido`, `precio_aprobado_x_umc`, `precio_aprobado_x_presentac`, `Precio_Regulado_TAB`, `Precio_Regulado_X_Pres`, `codigoCliente`, `nombreCliente`, `vigenciaDesde`, `vigenciaHasta`, `convenio`, `tipo`,`comentarios`)  
        VALUES ('$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$k','$l','$m','importador Institucionales', '$n')";
        $ejecutar = mysqli_query($bd,$sql);
        //var_dump(mysqli_error($bd));
    
    
}

function limpiarDatos()
{
    global $bd;
  //$sql = "DELETE FROM `matrizPrecios` WHERE tipo = 'importador'";
//    $ejecutar = mysqli_query($bd,$sql);
  //  return $ejecutar;
    
}






?>