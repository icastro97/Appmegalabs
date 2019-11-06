<?php
require_once '../../mcv5/clases/DB.class.php';
require_once("../../seguridad/config.php");

$user = $_SESSION['user_id'];
$id = $_POST['id'];
$descripcion = $_POST['des2'];

 
$sql = "UPDATE transferencia_val SET estado = 'CRUZ', observacionAc = '$descripcion' , ultimoCambioEstado = NOW() WHERE id_transferencia =  ".$id;
$query = mysqli_query($mysqli, $sql);

if($query == TRUE){
     $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`Observacion`) VALUES ('$id','$user','CRUZ',NOW(),'$descripcion')";
    $ejecutar = mysqli_query($mysqli, $consulta);
    if($ejecutar == TRUE){
     echo "exito";
}
else{
    echo "error";
}
}
else{
    echo "error";
}

?>