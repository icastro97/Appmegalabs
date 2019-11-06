<?php

require_once '../../mcv5/clases/DB.class.php';
$id_cabeza = $_REQUEST['dato'];


$sql = "update anticipo set estado = 'BAJA', fechaaprobador = NOW() where consecutivo =  " . $id_cabeza;
$resultado = mysqli_query($mysqli, $sql);

if($resultado)
{
    
    header('Location:https://appmegalabs.com/scandinavia/aplicaciones/Anticipos/Proveedor2.php?tp=Proveedor');
    
}
else
{
    echo "<script>alert('No paso');</script>";
   
}

?>