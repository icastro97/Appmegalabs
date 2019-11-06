<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$rc = $_GET['rc'];
$products = [];
$sql = "SELECT `id`, `documento`, `nombreDoc` FROM `rc_documentos` WHERE rc = '$rc'";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id'] = $row['id'];
    $products[$i]['documento'] = $row['documento'];
    $products[$i]['nombreDoc'] = $row['nombreDoc'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}

?>