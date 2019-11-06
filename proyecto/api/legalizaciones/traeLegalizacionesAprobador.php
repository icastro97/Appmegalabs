<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$sesion = $_GET['id'];
$identifi = $_GET['cc'];

$products = [];
$sql = "SELECT T1.id_cabeza, T1.tipolegalizacion, T1.fecha, T1.nombre, T1.linea, T1.area, T2.regional, T1.estado, T4.descripcion, T1.identificacion, T1.observaciones FROM lg_cabeza T1 INNER JOIN lg_det_cabeza T4  ON T1.id_cabeza = T4.id  LEFT JOIN empleadolg T2 ON T2.cedula = T1.identificacion WHERE if(T1.estado = '0', '' ,T1.aprobador = $sesion OR T1.identificacion = $identifi)GROUP BY T1.id_cabeza ORDER BY T1.estado ASC";

$result = mysqli_query($con,$sql);


if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['numero']    = $row['id_cabeza'];  
    $products[$i]['tipoLegalizacion']    = $row['tipolegalizacion'];
    $products[$i]['identificacion']    = $row['identificacion'];
    $products[$i]['fecha'] = $row['fecha'];
    $products[$i]['nombre'] = $row['nombre'];
    $products[$i]['linea'] = $row['linea'];
    $products[$i]['areaTerapeutica'] = $row['area'];
    $products[$i]['regional'] = $row['regional'];
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