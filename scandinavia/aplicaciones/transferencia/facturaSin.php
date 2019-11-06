<?php
require_once '../../mcv5/clases/DB.class.php';
require_once("../../seguridad/config.php");

$id = $_POST['id'];
$descripcion = $_POST['des4'];

 $user = $_SESSION['user_id'];

$sql = "UPDATE transferencia_val SET estado = 'FSC', tipoApr = 'FSC', observacionAc = '$descripcion' WHERE id_transferencia =  ".$id;
$query = mysqli_query($mysqli, $sql);
    $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`Observacion`) VALUES ('$id','$user','FSC',NOW(),'$descripcion')";
    $ejecutar = mysqli_query($mysqli, $consulta);
if($query == TRUE){
     echo "exito";
}
else{
    echo "error";
}

?>