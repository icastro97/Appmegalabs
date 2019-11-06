<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$usr = $_GET['user'];

$products = [];
$sql = "SELECT T1.id_transferencia, T1.tipoFactura, T1.radicado, T1.fecfact, T1.factura, T1.establecimiento, T1.estado, T1.user_id, T1.descripcion FROM `transferencia_val` T1  where estado IN ('1','ACEPTADO') and aprobador = $usr group by T1.id_transferencia ORDER BY T1.estado = 1";

$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id']    = $row['id_transferencia'];  
    $products[$i]['radicado']    = $row['radicado'];
    $products[$i]['tipo']    = $row['tipoFactura'];
    $products[$i]['factura']    = $row['factura'];
    $products[$i]['fecha']    = $row['fecfact'];
    $products[$i]['establecimiento'] = $row['establecimiento'];
    $products[$i]['estado'] = $row['estado'];
    $products[$i]['descripcion'] = $row['descripcion'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}

?>