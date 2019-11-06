<?php
//procesamiento de fichero cargado
require_once '../../mcv5/clases/DB.class.php';
$ficheroconsulta = $_REQUEST['id'];
$consulta = "SELECT Cliente_Especial,Tipo,DocOrig,Cliente,cod,OpeFecha,VtoFecha,Valor_original,Abono,Saldo,Valor_fact_antes_de_iva,Descuento_pp,Zona,Ciudad,Canal,Fechas_Vencimiento_segun_convenios,Fecha_Vencimiento_Plazo_Factura,Presupuesto_con_fechas_convenio,Presupuesto_con_fecha_factura,Presupuesto_Tesoreria,Presupuesto,Tipo3,Estado,
En_presupuesto,Canal2  FROM rc_data WHERE fichero = " . $ficheroconsulta;

$resultado = $mysqli->query($consulta);


while($fila = $resultado->fetch_assoc()) {
    echo "Tipo: " . $fila['Tipo'] . ", Nombre: " . $fila['Cliente'] . ", VtoFecha: " . $fila['VtoFecha'] . "<br>";
	$consultafin = "SELECT  Tipo,DocOrig from rc_data_update where Tipo = '" . $fila['Tipo'] . "' and DocOrig = '" . $fila['DocOrig']. "'";
	$resultadofin = $mysqli->query($consultafin);
	$row_cnt = $resultadofin->num_rows;	
	
		//inserta registro en caso de que sea nuevo		
		$consultainsert = "Insert into rc_data_update(Cliente_Especial,Tipo,DocOrig,Cliente,cod,OpeFecha,VtoFecha,Valor_original,Abono,Saldo,Valor_fact_antes_de_iva,Descuento_pp,Zona,Ciudad,Canal,Fechas_Vencimiento_segun_convenios,Fecha_Vencimiento_Plazo_Factura,Presupuesto_con_fechas_convenio,Presupuesto_con_fecha_factura,Presupuesto_Tesoreria,Presupuesto,Tipo3,Estado,En_presupuesto,Canal2)
		Values('" .  $fila['Cliente_Especial']. "', '" .$fila['Tipo']. "', '" .$fila['DocOrig']. "', '" .$fila['Cliente']. "', '" .$fila['cod']. "', '" .$fila['OpeFecha']. "', '" .$fila['VtoFecha']. "', '" .$fila['Valor_original']. "', '" .$fila['Abono']. "', '" .$fila['Saldo']. "', '" .$fila['Valor_fact_antes_de_iva']. "', '" .$fila['Descuento_pp']. "', '" .$fila['Zona']. "', '" .$fila['Ciudad']. "', '" .$fila['Canal']. "', '" .$fila['Fechas_Vencimiento_segun_convenios']. "', '" .$fila['Fecha_Vencimiento_Plazo_Factura']. "', '" .$fila['Presupuesto_con_fechas_convenio']. "', '" .$fila['Presupuesto_con_fecha_factura']. "', '" .$fila['Presupuesto_Tesoreria']. "', '" .$fila['Presupuesto']. "', '" .$fila['Tipo3']. "', '" .$fila['Estado']. "', '" .$fila['En_presupuesto']. "', '" .$fila['Canal2'] . "')";
	  echo "Realizando insercion: " . $consultainsert. "<br>";
       mysqli_query($mysqli, $consultainsert);

}


$consultainsert = "Update tbl_uploads set estado = 1 where id = " . $ficheroconsulta;
mysqli_query($mysqli, $consultainsert);	
echo "Realizando Update cabecera fichero: " . $consultainsert. "<br>";
header('Location: /scandinavia/default1.php?group=ReciboCaja');

//fin proceso actualizacion

?>