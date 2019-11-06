<?php
require_once '../../mcv5/clases/DB.class.php';



$documento = $_REQUEST['documento'];
$factura = $_REQUEST['id'];

$sql = "DELETE FROM lg_det_cabeza WHERE identificador= ".$documento ;

$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $documento);



 //header("Location: index2.php?documento=".$documento."&op=LISTADO LEGALIZACIONES");
  header( "refresh:1; url=index2.php?documento=".$factura."&op=LISTADO LEGALIZACIONES" ); 
?>
