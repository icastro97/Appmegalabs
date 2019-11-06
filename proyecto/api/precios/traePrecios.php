<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$ped = [];
$sql = "SELECT `id`, `codigo_axapta`, `nombre_comercial`, `principio`, `contenido`, `precio_aprobado_x_umc`, `precio_aprobado_x_presentac`, `codigoCliente`, `nombreCliente`, `vigenciaDesde`,`vigenciaHasta`,`opcion`, `convenio`, `comentarios` FROM `matrizPrecios`";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $ped[$i]['id']    = $row['id'];
    $ped[$i]['codigo_axapta'] = $row['codigo_axapta'];
    $ped[$i]['nombre_comercial'] = $row['nombre_comercial'];
    $ped[$i]['principio'] = $row['principio'];
    $ped[$i]['contenido'] = $row['contenido'];
    $ped[$i]['precio_aprobado_x_umc']= $row['precio_aprobado_x_umc'];
    $ped[$i]['precio_aprobado_x_presentac'] = $row['precio_aprobado_x_presentac'];
    $ped[$i]['codigoCliente'] = $row['codigoCliente'];
    $ped[$i]['nombreCliente'] = $row['nombreCliente'];
    $ped[$i]['vigenciaDesde'] = $row['vigenciaDesde'];
    $ped[$i]['vigenciaHasta'] = $row['vigenciaHasta'];
    $ped[$i]['opcion'] = $row['opcion'];
    $ped[$i]['convenio'] = $row['convenio'];
    $ped[$i]['comentarios'] = $row['comentarios'];
    $i++;
  }
  echo json_encode($ped);
}
else
{
  http_response_code(404);
}

?>