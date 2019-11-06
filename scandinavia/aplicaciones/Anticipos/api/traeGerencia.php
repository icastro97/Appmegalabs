<?php
/**
 * Retorna lista de clientes.
 */
require '../../../../proyecto/api/consulta/database.php';


$anticipo = [];
$sql = "SELECT consecutivo, tipo, fechaActual, identificacion, nombre, estado FROM consecutivomayor where identificacion <> '901154297-1' and identificacion <> '830000167-2' order by estado";
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