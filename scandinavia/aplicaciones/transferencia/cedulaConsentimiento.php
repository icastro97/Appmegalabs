<?php
require_once '../../mcv5/clases/DB.class.php';


$cedulanopanel = $_POST['cedulanopanel'];



	$consulta="SELECT transferenciaValor from formulario_firma where cedula = '$cedulanopanel'";
	 
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'transferenciaValor' => $row['transferenciaValor'],
			 
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 

?> 