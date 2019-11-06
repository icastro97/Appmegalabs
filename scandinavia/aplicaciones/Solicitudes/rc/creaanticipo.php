<?php
session_start();
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();


if (!isset($_REQUEST['nit'])) {
   $nit = 0;
}
else{
	$nit =$_REQUEST['nit'];
}
if (!isset($_REQUEST['ValorAnticipo'])) {
   $ValorAnticipo = 0;
}
else{	
	$ValorAnticipo = str_replace(',', '', $_REQUEST['ValorAnticipo']);
}
if (!isset($_REQUEST['fecha'])) {
   $fecha = 0;
}
else{
	$fecha =$_REQUEST['fecha'];
}
if (!isset($_REQUEST['txtobservaciones'])) {
   $txtobservaciones = 0;
}
else{
	$txtobservaciones =$_REQUEST['txtobservaciones'];
}

if (!isset($_REQUEST['clie'])) {
   $clie = 0;
}
else{
	$clie =$_REQUEST['clie'];
}



$newDate = date("d/m/Y");
$usuarioinserta = $_SESSION["user_id"];
$op= $_REQUEST['OP'];

$sql="INSERT INTO rc_anticipos(tipodoc,cliente,fechanticipo,fechareal,valor,saldo,observaciones,userid, razon) VALUES('RCA','$nit','$fecha', '$newDate', $ValorAnticipo, 0, '$txtobservaciones', $usuarioinserta,'$clie')";

mysqli_query($mysqli, $sql);
    echo $op;
//inserta detalles 
$UltimoId = mysqli_insert_id($mysqli);
header('Location: /scandinavia/aplicaciones/rc/grillaanticipos.php?op='.$op);	
?>