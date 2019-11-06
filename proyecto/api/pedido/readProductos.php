<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$products = [];
$sql = "SELECT T1.id_maestro, T1.Codigo_de_articulo, T2.nombre_comercial, T1.ISO_Key FROM maestroProductos T1 INNER JOIN matrizPrecios T2 ON T1.Codigo_de_articulo = T2.codigo_axapta  where SUBSTRING(T1.Nombre_del_articulo, 1, 1) <> '#' and SUBSTRING(T1.Codigo_de_articulo, 1, 3) = 001 GROUP BY T2.codigo_axapta";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id']    = $row['id_maestro'];  
    $products[$i]['codigo']    = $row['Codigo_de_articulo'];
    $products[$i]['nombre'] = $row['nombre_comercial'];
    $products[$i]['principio'] = $row['ISO_Key'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}
