<?php
require_once '../../mcv5/clases/DB.class.php';
require_once("../../seguridad/config.php");


$id = $_POST['id'];
$descripcion = $_POST['obs'];
$user = $_SESSION['user_id'];

$sql = "UPDATE transferencia_val SET estado = 'CRUCE', observacionCartera = '$descripcion', ultimoCambioEstado = NOW(), observacionCartera = '$descripcion', fechaCartera= NOW() WHERE id_transferencia =  ".$id;
$query = mysqli_query($mysqli, $sql);

if($query == TRUE){
      $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`Observacion`) VALUES ('$id','$user','CRUCE',NOW(),'$descripcion')";
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