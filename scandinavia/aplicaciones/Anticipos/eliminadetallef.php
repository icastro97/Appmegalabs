<?php
require_once '../../mcv5/clases/DB.class.php';


$consecutivo = $_REQUEST['consecutivo'];
$documento = $_REQUEST['documento'];

$sql = "DELETE FROM anticipo WHERE id_anticipo=" . $documento;
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $documento);

  header( "refresh:0; url=indexEmpleado2.php?documento=".$consecutivo."&op=LISTADO ANTICIPOS" ); 
?>
