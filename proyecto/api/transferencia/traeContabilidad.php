<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
 
require '../../../scandinavia/seguridad/config.php';
require 'database.php';
session_start();
$usuarioContabilidad = $_SESSION['user_id'];
$usr = $_GET['user'];
if(empty($usuarioContabilidad))
{
    $user = 354;
    $sql = "SELECT id_transferencia, tipoFactura, radicado, factura, fecfact, establecimiento, descripcion, estado, tipoApr FROM distribucionContabilidadDos where usuario ='$user' and ESTADO = 'APR'";
    $result = mysqli_query($con,$sql);
    
}
else
{

$sql = "SELECT id_transferencia, tipoFactura, radicado, factura, fecfact, establecimiento, descripcion, estado, tipoApr FROM distribucionContabilidadDos where usuario ='$usuarioContabilidad' and ESTADO = 'APR'";
$result = mysqli_query($con,$sql);
}
$products = [];
if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id']    = $row['id_transferencia'];  
    $products[$i]['tipo']    = $row['tipoFactura'];  
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