<?php
require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['identificador'];
$user = $_POST['user'];

$sql = "UPDATE transferencia_val set estado = '1', tipoApr = null,   ultimoCambioEstado = NOW() WHERE id_transferencia = '$id'";
$ejecutar = mysqli_query($mysqli, $sql);

if ($ejecutar == TRUE) {
    $consulta = "INSERT INTO Historico_facturas (id_factura, usuario, nuevo_estado, fecha_cambio, observacion) VALUES ('$id', '$user', '1', NOW(), 'Devolucion de estado')";
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