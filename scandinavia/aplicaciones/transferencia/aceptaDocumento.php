<?php
require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['id'];
$user = $_POST['user'];
$obser = $_POST['obser'];

$sql = "UPDATE transferencia_val set estado = 'ACEPTADO', observacionG = '$obser', ultimoCambioEstado = NOW() WHERE id_transferencia = '$id'";

$ejecutar = mysqli_query($mysqli, $sql);

if ($ejecutar == TRUE) {
    $consulta = "INSERT INTO Historico_facturas (id_factura, usuario, nuevo_estado, fecha_cambio) VALUES ('$id', '$user', 'ACEPTADO', NOW())";
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
else{
    $response = mysqli_error($sql);
    echo $response;
}


?>