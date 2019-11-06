<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$cedula = $_GET['id'];

$products = [];
$sql = "SELECT T1.id_cabeza, T1.tipolegalizacion, T1.fecha, T1.nombre, T1.linea, T1.area, T2.regional, T1.estado FROM `lg_cabeza` T1 INNER JOIN empleadolg T2 where T1.identificacion = '$cedula' and estado = '0' group by T1.id_cabeza";

$result = mysqli_query($con,$sql);


if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['numero']    = $row['id_cabeza'];  
    $products[$i]['tipoLegalizacion']    = $row['tipolegalizacion'];
    $products[$i]['fecha'] = $row['fecha'];
    $products[$i]['nombre'] = $row['nombre'];
    $products[$i]['linea'] = $row['linea'];
    $products[$i]['areaTerapeutica'] = $row['area'];
    $products[$i]['regional'] = $row['regional'];
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