<?php
//reporteUbicaciones

function insertarDatos($Codigo, $Producto, $Principio, $Contenido, $CodigoCUM, $REGULADO, $act, $p1, $p2, $p3, $obs, $reg, $obs2)
{
        global $bd;
        $sql =  "INSERT INTO `precios_Regulacion`(`codigo`, `producto`, `principioActivo`, `contenido`, `codigoCum`, `regulado`, `atcInvima`, `precioMarzo2018`, `Precio_Regulado_Circular_7_de_2018_tableta`, `Precio_Regulado_Circular_7_de_2018_presentacion`, `Observaciones`, `ULTIMA_REGULACION`, `observaciones_vaidacion`) VALUES ('$Codigo', '$Producto', '$Principio', '$Contenido', '$CodigoCUM', '$REGULADO', '$act', '$p1', '$p2', '$p3', '$obs', '$reg', '$obs2')";
        $ejecutar = mysqli_query($bd,$sql);
        return $ejecutar;
    
    
}

function limpiarDatos()
{
    global $bd;
    $sql = "truncate table precios_Regulacion";
    $ejecutar = mysqli_query($bd,$sql);
    return $ejecutar;
    
}






?>