<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$products = [];
$sql = "SELECT T1.observacion, T1.ordenCompra, T1.FechaOrden, T1.nombreArchivo, T1.FechaEntrega,sum(T2.precio) as subtotal, T2.cantidad, T1.observacionRechazo, T2.bonificadas, T2.precio FROM ped_cabeza T1 INNER JOIN ped_productos T2 on T1.id_c = T2.consecutivo WHERE consecutivo = '$_GET[consec]' GROUP BY  consecutivo";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['consec'] = $row['consecutivo'];
    $products[$i]['FechaOrden'] = $row['FechaOrden'];
    $products[$i]['observacion'] = $row['observacion'];
    $products[$i]['ordenCompra'] = $row['ordenCompra'];
    $products[$i]['nombreArchivo'] = $row['nombreArchivo'];
    $products[$i]['subtotal'] = $row['subtotal'];
    $products[$i]['cantidad'] = $row['cantidad'];
    $products[$i]['bonificadas'] = $row['bonificadas'];
    $products[$i]['observacionRechazo'] = $row['observacionRechazo'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}

?>