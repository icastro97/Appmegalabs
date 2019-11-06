<?php
session_start();
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();


$recibo =$_REQUEST['rcid'];
$estadoscartera =1;
$estadoscarteraobs =$_REQUEST['estadoscartera'];



if (!isset($_REQUEST['TipRec'])) { 
	$TipRec ="";
}
else{
	$TipRec =$_REQUEST['TipRec'];
}


if (!isset($_REQUEST['ObservacionP'])) {
   $observaciones = "Sin Observacion";
}
else{
	$observaciones =$_REQUEST['ObservacionP'];
}


//arreglo hbt febrero 2019
if (!isset($_REQUEST['aplicacion'])) {
   $aplicacion = "";
}
else{
	$aplicacion =$_REQUEST['aplicacion'];
}

if (!isset($_REQUEST['paso'])) {
   $paso = "";
}
else{
	$paso =$_REQUEST['paso'];
}

$fechareal =  date("d-m-Y");

if($_REQUEST['ultimopaso'] == $paso)
{
	$estadoscartera = $_REQUEST['estadoscartera'];
}

$usuariomodifica = $_SESSION["user_id"];

$sql="UPDATE lg_cabeza SET estado = '$estadoscartera', observacionP = '$observaciones', usermodifica = $usuariomodifica, paso = $paso Where id = $recibo";

echo "valor 1: " . $sql . "<br>";
mysqli_query($mysqli, $sql);

if($_REQUEST['estadoscartera'] == 'REC'){
$sql="UPDATE lg_det_cabeza SET habilitado = 0 Where id = $recibo";
mysqli_query($mysqli, $sql);
$sql="UPDATE lg_cabeza SET estado = 'REC' Where id = $recibo";
mysqli_query($mysqli, $sql);
}


//arreglo HBT feb 2019
$sql="INSERT INTO  observaciones (estado, aplicacion, observacion, paso, userid, fecha, iddocumento) VALUES('$estadoscarteraobs', '$aplicacion','$observaciones', $paso, $usuariomodifica, '$fechareal', $recibo)";
echo "valor 2: " . $sql . "<br>";
mysqli_query($mysqli, $sql);


//header('Location: /scandinavia/aplicaciones/legalizaciones/listadolegalizaciones.php');	
?>