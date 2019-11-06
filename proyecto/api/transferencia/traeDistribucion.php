<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$usr = $_GET['user'];

$products = [];
$sql = "SELECT id_transferencia, radicado, factura, fecfact, establecimiento, descripcion, estado, tipoFactura FROM transferencia_val where estado IN (2, 'NO ACEPTO')";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id']    = $row['id_transferencia'];  
    $products[$i]['tipo'] = $row['tipoFactura'];
    $products[$i]['radicado']    = $row['radicado'];  
    $products[$i]['factura']    = $row['factura'];  
    $products[$i]['fecha']    = $row['fecfact'];
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