<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['identificacion'];


if(!empty($id))
 {
 	
	$consulta="SELECT consecutivo, descripcion, identificacion, moneda, monto, valor, (monto - valor) as saldo FROM (SELECT consecutivo, descripcion, identificacion, moneda, SUM(monto) AS monto FROM anticipo WHERE tipo='Empleado' GROUP BY consecutivo ) T1 LEFT JOIN (SELECT anticipoE1, SUM(valor) AS valor FROM lg_det_cabeza GROUP BY(anticipoE1) ) T2 ON T2.anticipoE1 = T1.consecutivo WHERE identificacion=".$id;
	
 	$sql = mysqli_query($mysqli, $consulta);
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
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
 }

?> 