<?php
//reporteUbicaciones

function insertarDatos($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s, $t, $u, $v, $w)
{
        global $bd;
        $sql =  "INSERT INTO `precioProd`(`codigoArticulo`, `nombreArticulo`, `almacen`, `numeroLote`, `codigoDisposicion`, `ubicacion`, `subloteCalidad`, `totalDisponible`, `estadoDisposicion`, `fechaCaducidad`, `inventarioFisico`, `fisicaReservada`, `fisicaDisponible`, `pedidoTotal`, `precioCoste`, `diasCaducidad`, `franjas`, `familia`, `tipoArticulo`, `almacen2`, `fecha`, `Linea`, `tipoUbicaciones`)   
        VALUES ('$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h', '$i', '$j', '$k', '$l', '$m', '$n', '$o', '$p', '$q', '$r', '$s', '$t', '$u', '$v', '$w')";
        $ejecutar = mysqli_query($bd,$sql);
        //var_dump(mysqli_error($bd));
    
    
}

function limpiarDatos()
{
    global $bd;
  $sql = "truncate table precioProd";
    $ejecutar = mysqli_query($bd,$sql);
    return $ejecutar;
    
}






?>