<?php

require('conexion.php');

$nit = $_POST['nit'];
$correo = $_POST['correo'];


if(!empty($nit))
 {
	 $consulta="SELECT nit, correo FROM infoProveedores  where  nit = '$nit' and correo = '$correo' ";
	 $sql = mysqli_query($bd, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($bd));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'nit' => $row['nit'],
			 'correo' =>$row['correo']
			 
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 }

?> 