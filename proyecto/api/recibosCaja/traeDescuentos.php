<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$documento = $_GET['desc'];
$products = [];
$sql = "SELECT Descuento_PP from rc_data WHERE DocOrig = '$documento'";
//var_dump($sql);
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['Descuento_PP'] = $row['Descuento_PP'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  var_dump(mysqli_error($con));
  http_response_code(404);
}

?>