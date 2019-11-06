<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['nit'];
$sesion = $_POST['sesion'];


	$consulta="SELECT consecutivo, descripcion, identificacion, moneda, monto, (monto - valor) AS saldo, estado FROM ( SELECT consecutivo, descripcion, identificacion, moneda, estado, userid, SUM(monto) AS monto FROM anticipo t WHERE tipo = 'Proveedor' GROUP BY consecutivo ) T1 LEFT JOIN( SELECT anticipoP1, SUM(valor) AS valor FROM lg_det_cabeza GROUP BY (anticipoP1) ) T2 ON T2.anticipoP1 = T1.consecutivo WHERE T1.userid = ".$sesion." AND T1.identificacion ='".$id."' and T1.estado = 'APRC'";
	
	$sql = mysqli_query($mysqli, $consulta);
	if(!$sql)
	{
		die('Query Error'. mysqli_error($mysqli));
	}

	$json = array();
	while($row = mysqli_fetch_array($sql))
	{
		$json[] = array(
			'consecutivo' => $row['consecutivo'],
 			'descripcion' => $row['descripcion'],
 			'moneda' => $row['moneda'],
			'monto' => $row['monto'],
			'total' => $row['saldo']
		);
	}
	$jsonstring = json_encode($json);
	echo $jsonstring;


?> 