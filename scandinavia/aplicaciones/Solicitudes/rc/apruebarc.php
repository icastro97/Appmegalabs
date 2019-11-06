<?php
session_start();
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();


$recibo =$_REQUEST['rcid'];
$estadoscartera =$_REQUEST['estadoscartera'];


if (!isset($_REQUEST['TipRec'])) { 
	$TipRec ="";
}
else{
	$TipRec =$_REQUEST['TipRec'];
}


if (!isset($_REQUEST['Observacion'])) {
   $observaciones = "Sin Observacion";
}
else{
	$observaciones =$_REQUEST['Observacion'];
}

//$newDate = date("d/m/Y", strtotime($fecha));

$usuariomodifica = $_SESSION["user_id"];

$sql="UPDATE rc_cabeza SET Aprobado = '$estadoscartera', ObservacionesCartera = '$observaciones', usuariomodifica = $usuariomodifica, Rechazo = '$TipRec' Where DocumentID = $recibo";
mysqli_query($mysqli, $sql);

if($_REQUEST['estadoscartera'] == 'REC'){
$sql="UPDATE rd_detalle SET Habilitado = 0 Where DocumentID = $recibo";
mysqli_query($mysqli, $sql);
}



header('Location: /scandinavia/aplicaciones/rc/listadorc.php');	
?>