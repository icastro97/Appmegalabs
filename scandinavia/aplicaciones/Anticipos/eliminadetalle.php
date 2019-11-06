<?php
require_once '../../mcv5/clases/DB.class.php';



$documento = $_GET['documento'];

$sql = "DELETE FROM anticipo WHERE id_anticipo=" . $documento;

$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $service);

header( "refresh:1; url=indexEmpleado.php?documento=".$documento."&op=LISTADO ANTICIPOS" ); 
?>