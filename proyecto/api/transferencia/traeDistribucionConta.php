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

$products = [];

if($usuarioContabilidad == "376")
{
    $sql = "SELECT `id_transferencia`, `tipoFactura`, `radicado`, `fecfact`, `factura`, `establecimiento`,`tipoApr`, `descripcion`, `estado` FROM `distribucionContabilidad` WHERE usuario = '$usuarioContabilidad' and tipoApr IS NULL UNION ALL  SELECT `id_transferencia`, `tipoFactura`, `radicado`, `fecfact`, `factura`, `establecimiento`,`tipoApr`, `descripcion`, `estado` FROM `distribucionContabilidad` WHERE  aprobador = '$usuarioContabilidad' and tipoApr IS NULL";
    

    $result = mysqli_query($con,$sql);    
}
else
{

    $sql = "SELECT `id_transferencia`, `tipoFactura`, `radicado`, `fecfact`, `factura`, `establecimiento`,`tipoApr`, `descripcion`, `estado` FROM `distribucionContabilidad` WHERE usuario = '$usuarioContabilidad' AND  tipoApr IS NULL and Aprobador <> 376";
    $result = mysqli_query($con,$sql);
}

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
    $products[$i]['tipoApr'] = $row['tipoApr'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}

?>