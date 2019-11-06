<?php
//reporteUbicaciones

function insertarDatos($nit, $cuenta, $razon, $grupo, $condicion, $zona, $region, $vendedor, $direccion, $institucional)
{
        global $bd;
        $sql =  "INSERT INTO `clientes`(`NIT`, `cuentacliente`, `razonsocial`, `grupoventas`, `condicionpago`, `zona`, `region`, `vendedor`, `direccionEntrega`, `institucional`) VALUES ('$nit', '$cuenta', '$razon', '$grupo', '$condicion', '$zona', '$region', '$vendedor','$direccion','$institucional')";
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

?>