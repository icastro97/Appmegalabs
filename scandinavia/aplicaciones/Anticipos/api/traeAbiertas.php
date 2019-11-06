<?php
/**
 * Retorna lista de clientes.
 */
require '../../../../proyecto/api/consulta/database.php';


$user = $_GET['user'];

$anticipo = [];
$sql = "SELECT T1.consecutivo, T1.tipo, T1.fechaActual, T1.identificacion, T1.nombre, T1.estado FROM anticipo T1 INNER JOIN system_users T2 WHERE T1.estado = '0' and T1.userid = ".$user." AND tipo='Proveedor' group by T1.consecutivo";

$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $anticipo[$i]['numero']    = $row['consecutivo'];  
    $anticipo[$i]['tipo']    = $row['tipo'];
    $anticipo[$i]['fecha'] = $row['fechaActual'];
    $anticipo[$i]['identificacion'] = $row['identificacion'];
    $anticipo[$i]['nombre'] = $row['nombre'];
    $anticipo[$i]['estado'] = $row['estado'];
    $anticipo[$i]['aprobador'] = $row['aprobador'];
    $i++;
  }
  echo json_encode($anticipo);
}
else
{
 http_response_code(404);
}
?>