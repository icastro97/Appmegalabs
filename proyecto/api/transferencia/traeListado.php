<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$usr = $_GET['user'];

$products = [];
$sql = "SELECT id_transferencia, radicado, factura, fecha_registro, establecimiento, descripcion, estado FROM transferencia_val ";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id_transferencia']    = $row['id_transferencia'];  
    $products[$i]['radicado']    = $row['radicado'];  
    $products[$i]['factura']    = $row['factura'];  
    $products[$i]['fecha_registro']    = $row['fecha_registro'];
    $products[$i]['establecimiento'] = $row['establecimiento'];
    $products[$i]['descripcion'] = $row['descripcion'];
    $products[$i]['estado'] = $row['estado'];
    
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}

?>