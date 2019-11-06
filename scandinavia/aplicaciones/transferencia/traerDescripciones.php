<?php
require_once '../../mcv5/clases/DB.class.php';

$ide = $_POST['ide'];


	 $consulta="SELECT id_factura, fecha_cambio, full_name,  nuevo_estado, observacion FROM HistorialFacturas where id_factura = '$ide'";
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'id_factura' => $row['id_factura'],
			 'fecha' => $row['fecha_cambio'],
			 'full_name' => $row['full_name'],
			 'nuevo_estado' => $row['nuevo_estado'],
			 'observacion' => $row['observacion']
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 

?> 
