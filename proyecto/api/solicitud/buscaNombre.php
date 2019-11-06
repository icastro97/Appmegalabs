<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$codigo = $_GET['codigo'];

//$products = [];
$sql = "SELECT `nombre_comercial` FROM `matrizPrecios` WHERE `codigo_axapta` = '$codigo' GROUP BY nombre_comercial";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $prod  = $row['nombre_comercial']; 
    
  }
 
}
else
{
  http_response_code(404);
}

 echo json_encode($prod);
?>