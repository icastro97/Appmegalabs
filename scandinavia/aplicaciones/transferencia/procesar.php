<?php
require_once '../../mcv5/clases/DB.class.php';

$estado = $_POST['estado'];
$observacion = $_POST['observacion'];
$id = $_POST['docs']; 
$user = $_POST['sesionn'];
$observacionN = $_POST['ObservacionN'];
$check = $_POST['isChecked1'];
$aprContabilidad = $_POST['aprContabilidad'];

if($estado == "APR")
{
    $sql = "UPDATE transferencia_val set estado = '$estado',  novedad = '$observacionN', observacion = '$observacion', ultimoCambioEstado = NOW() WHERE id_transferencia = '$id'";
    
    $ejecutar = mysqli_query($mysqli, $sql);
    
    if ($ejecutar == TRUE)
    { 
        
         $consulta = "INSERT INTO Historico_facturas (id_factura, usuario, nuevo_estado, fecha_cambio,Observacion) VALUES ('$id', '$user', 'APROBADO', NOW(),'$observacion')";
    $query = mysqli_query($mysqli, $consulta);
    if ($query == TRUE) {
        $response = "Exito";
        echo $response;
    }
    else {
        $response = mysqli_error($consulta);
        echo $response;
    }

    }
    else
    {
      echo "Fallo";
      var_dump(mysqli_error($mysqli));
    }
}
else if($estado == "REC")
{
    $sql = "UPDATE transferencia_val set estado = '$estado',  novedad = '$observacionN', observacion = '$observacion', ultimoCambioEstado = NOW() WHERE id_transferencia = '$id'";
    $ejecutar = mysqli_query($mysqli, $sql);
    
    if ($ejecutar == TRUE)
    { 
        
         $consulta = "INSERT INTO Historico_facturas (id_factura, usuario, nuevo_estado, fecha_cambio, Observacion) VALUES ('$id', '$user', 'RECHAZADO', NOW(),'$observacion')";
    $query = mysqli_query($mysqli, $consulta);
    if ($query == TRUE) {
        $response = "Exito";
        echo $response;
    }
    else {
        $response = mysqli_error($consulta);
        echo $response;
    }

    }
    else
    {
      echo "Fallo";
      
    }
    
}



?>