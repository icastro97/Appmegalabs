<?php

require('conexion.php');

$nit = $_POST['nit'];
$correo = $_POST['correo'];
$code = $_POST['code'];



	 $consulta="SELECT codigoAxapta FROM infoProveedores  where  nit = '$nit' and correo = '$correo' and codigoAxapta = '$code'";
	 $sql = mysqli_query($bd, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($bd));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'codigo' => $row['codigoAxapta']
			 
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 

?> 