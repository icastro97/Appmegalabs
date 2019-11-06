<?php
require_once '../../mcv5/clases/DB.class.php';



$documento = $_GET['documento'];
$factura = $_GET['factura'];
$sql = "DELETE FROM lg_det_cabeza WHERE identificador= ". $documento;




$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems " . $service);



?>