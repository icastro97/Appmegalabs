<?php
session_start();
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();





if (!isset($_REQUEST['descuento'])) {
   $descuento = 0;
}
else{
	$descuento =$_REQUEST['descuento'];
}
if (!isset($_REQUEST['adicional'])) {
   $adicional = 0;
}
else{
	$adicional = $_REQUEST['adicional'];
}
if (!isset($_REQUEST['condiciondias'])) {
   $condiciondias = 0;
}
else{
	$condiciondias =$_REQUEST['condiciondias'];
}
if (!isset($_REQUEST['fechaactual'])) {
   $fechaactual = 0;
}
else{
	$fechaactual =$_REQUEST['fechaactual'];
}

if (!isset($_REQUEST['clientecartera'])) {
   $clientecartera = 0;
}
else{
	$clientecartera =$_REQUEST['clientecartera'];
}


if (!isset($_REQUEST['Dtofinanciero'])) {
   $Dtofinanciero = "No";
}
else{
	$Dtofinanciero =$_REQUEST['Dtofinanciero'];
}
if (!isset($_REQUEST['Negociacion'])) {
   $Negociacion = "No";
}
else{
	$Negociacion =$_REQUEST['Negociacion'];
}
if (!isset($_REQUEST['valoranticipo'])) {
   $valoranticipo = "0";
}
else{
	$valoranticipo =$_REQUEST['valoranticipo'];
	$descuentosadicionales = "1";
}

if (!isset($_REQUEST['banco'])) {
   $banco = 0;
}
else{
	$banco =$_REQUEST['banco'];
}

if (!isset($_REQUEST['txtobservaciones'])) {
   $observaciones = "Sin Observaacion";
}
else{
	$observaciones =$_REQUEST['txtobservaciones'];
}

$fecha = $_REQUEST['fecha'];

$newDate = date("d/m/Y", strtotime($fecha));

$usuarioinserta = $_SESSION["user_id"];

if (!isset($_REQUEST['TipoPago'])) { 
     $TipoPago = 0;
}
else{
	$TipoPago =$_REQUEST['TipoPago'];
}

if (!isset($_REQUEST['NoCheque'])) { 
	$NoCheque ="---";
}
else{
	$NoCheque =$_REQUEST['NoCheque'];
}


if (!isset($_REQUEST['ValorCheque'])) { 
	$ValorCheque ="0";
}
else{
	$ValorCheque =$_REQUEST['ValorCheque'];
}

if (!isset($_REQUEST['fecha2'])) { 
	$fecha2 = "";
	$newDate2 = "";
}
else{
	$fecha2 = $_REQUEST['fecha2'];
	$newDate2 = date("Y/m/d", strtotime($fecha2));
}


if (!isset($_REQUEST['anticipo'])) {
   $anticipo = 0;
}
else{
	$anticipo = $_REQUEST['anticipo'];
}
if (!isset($_REQUEST['valdocumentoanticipo'])) {
   $valoranticipo1 = 0;
}
else{
	$valoranticipo1 =$_REQUEST['valdocumentoanticipo'];
}
if (!isset($_REQUEST['nombrecliente'])) {
   $nombrecliente = 0;
}
else{
	$nombrecliente =$_REQUEST['nombrecliente'];
}

if (!isset($_REQUEST['ncodecliente'])) {
   $ncodecliente = 0;
}
else{
	$ncodecliente =$_REQUEST['ncodecliente'];
}

if (!isset($_REQUEST['rctempo'])) {
   $rctempo = 0;
}
else{
	$rctempo =$_REQUEST['rctempo'];
}



$sql="INSERT INTO rc_cabeza(Cliente,Descuento1 ,ValorDes1 ,Descuento2 ,ValorDes2 ,Descuento3 ,ValorDes3 ,BancoID ,Fecha,FechaReal ,usuario, Observaciones, TipoPago, Cheque, Valor, FechaCheque) VALUES('$clientecartera','$Dtofinanciero',$descuento, '$Negociacion', $adicional, '$descuentosadicionales', $valoranticipo, $banco, '$newDate', '$fechaactual', '$usuarioinserta', '$observaciones', '$TipoPago', '$NoCheque', '$ValorCheque', '$newDate2')";

mysqli_query($mysqli, $sql);
    
echo $sql;	
	
//inserta detalles 
$UltimoId = mysqli_insert_id($mysqli);

$vtidoc = ""; $vvalorfactura = ""; $vimpositiva = ""; $vppago = ""; $vdadicional = ""; $vdotros = "";$vnotano = ""; $vvalnota = ""; $vNeto = ""; $vNumDoc = "";
$vcondiciondias = ""; $vcondiasmax = ""; $vfecven = "";
	foreach($_REQUEST['tidoc'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vtidoc = $vtidoc . $extrae;
		}
	foreach($_REQUEST['valcalculo'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vvalorfactura = $vvalorfactura . $extrae;
		}
	foreach($_REQUEST['impositiva'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vimpositiva = $vimpositiva . $extrae;
		}
	foreach($_REQUEST['ppago'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vppago = $vppago . $extrae;
		}
	foreach($_REQUEST['dadicional'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vdadicional = $vdadicional . $extrae;
		}
		
	foreach($_REQUEST['dotros'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vdotros = $vdotros . $extrae;
		}
		
	foreach($_REQUEST['notano'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vnotano = $vnotano . $extrae;
		}
	foreach($_REQUEST['valnota'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vvalnota = $vvalnota . $extrae;
		}
	foreach($_REQUEST['Neto'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vNeto = $vNeto . $extrae;
		}	
		
	foreach($_REQUEST['DocFinal'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vNumDoc = $vNumDoc . $extrae;
		}			
		
	
		
		
		
	foreach($_REQUEST['fechavencimiento'] as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
			$vfecven = $vfecven . $extrae;
		}				
		
        $vtidoc         = substr ($vtidoc, 0, strlen($vtidoc) - 1); //elimina la ultima ,
		$vvalorfactura  = substr ($vvalorfactura, 0, strlen($vvalorfactura) - 1); //elimina la ultima ,
		$vimpositiva    = substr ($vimpositiva, 0, strlen($vimpositiva) - 1); //elimina la ultima ,
		$vppago         = substr ($vppago, 0, strlen($vppago) - 1); //elimina la ultima ,
		$vdadicional    = substr ($vdadicional, 0, strlen($vdadicional) - 1); //elimina la ultima ,
		$vdotros        = substr ($vdotros, 0, strlen($vdotros) - 1); //elimina la ultima ,
		$vnotano        = substr ($vnotano, 0, strlen($vnotano) - 1); //elimina la ultima ,
		$vvalnota       = substr ($vvalnota, 0, strlen($vvalnota) - 1); //elimina la ultima ,
		$vNeto          = substr ($vNeto, 0, strlen($vNeto) - 1); //elimina la ultima ,
		$vNumDoc        = substr ($vNumDoc, 0, strlen($vNumDoc) - 1); //elimina la ultima ,	
		$vcondiciondias = $_REQUEST['condiciondias'];
		$vcondiasmax    = $_REQUEST['condiciondias']; //hay que enviar el parametro porque no se sabe de donde tomarlo		
		$vfecven        = substr ($vfecven, 0, strlen($vfecven) - 1); //elimina la ultima ,		
		
		$avtidoc         = explode(",", $vtidoc);
		$avvalorfactura  = explode(",", $vvalorfactura);
		$avimpositiva    = explode(",", $vimpositiva);
		$avppago         = explode(",", $vppago);
		$adadicional     = explode(",", $vdadicional);
		$avdotros        = explode(",", $vdotros);
		$avnotano        = explode(",", $vnotano);	
		$avvalnota       = explode(",", $vvalnota);
		$avNeto          = explode(",", $vNeto);	
		$avNumDoc        = explode(",", $vNumDoc);		
		$avcondiciondias = $vcondiciondias;
		$avcondiasmax    = $vcondiasmax;
		$avfecven        = explode(",", $vfecven);	
		
        $tamañolinea = $_REQUEST['lineas'];

		//Variable que va a tener la cadena de insercion
		$cadenainsert = "(";
		for($k=0;$k<=$tamañolinea - 1 ;$k++)
		{						         
		      $kk = str_replace('$','',$avNeto[$k]);
			  $kk = str_replace('.','',$kk);
			  
			  
			  $varMarca = "V";
			  if($avcondiciondias <= $avcondiasmax){ $varMarca = "F"; }
			  
			  if($avimpositiva[$k] == ""){ $avimpositiva[$k] = 0;}
			  if($avppago[$k] == ""){ $avppago[$k] = 0;}
			  if($adadicional[$k] == ""){ $adadicional[$k] = 0;}
			  if($avdotros[$k] == ""){ $avdotros[$k] = 0;}
			  if($avnotano[$k] == ""){ $avnotano[$k] = 0;}
			  if($avvalnota[$k] == ""){ $avvalnota[$k] = 0;}
			  
			  			 
			  $sql="INSERT INTO rd_detalle(DocumentID,Documento,ValorDocumento,RetImpositiva,DesPPago,DesAdicional,OtrosDescuentos,NoNota,ValNota,ValNeto,DiasPago,TiempoPago) 
			  VALUES($UltimoId, '$avNumDoc[$k]',$avvalorfactura[$k],$avimpositiva[$k],$avppago[$k],$adadicional[$k],$avdotros[$k],$avnotano[$k],$avvalnota[$k],$kk, $avcondiciondias,'$varMarca')";
			  
			  //echo $sql . "<br>";

			  mysqli_query($mysqli, $sql);
		}
		
		
//inserta filas si existe anticipo
if($anticipo == 'Si' && $valoranticipo != 0){
$newDate = date('Y/m/d');	
//crea registros en data 
$NumRc = "RC". $UltimoId;
	$queryinsertanticipo  = "insert into rc_data  (Cliente_Especial,Tipo,DocOrig,Cliente ,cod,CliVtaGrupoDes ,Analista_cartera,DocVouchOrig,OpeFecha,VtoFecha,VtoDias_sistema,Calculo_fecha_ven_con_plazo_sistema,CliCondTipo,Descrpcion_condicion ,Tipo_de_Pedido_AX_09,Valor_original,Abono,Saldo,Valor_fact_antes_de_iva,Descuento_pp,Zona,Ciudad,Concepto,Descripcion_Doc,Canal,Plazo1_999_181,Plazo2_180_121,Plazo3_120_91,Plazo4_90_61,Plazo5_60_31,Plazo6_30_0,Total_cartera_corriente,Plazo1_1_30,Plazo2_31_60,Plazo3_61_90,Plazo4_91_120,Plazo5_121_180,Plazo6_181_360,Plazo7_361,Total_cartera_vencida,Total,Presupuesto_general,Fechas_Vencimiento_segun_convenios,Fecha_Vencimiento_Plazo_Factura,Presupuesto_con_fechas_convenio,Presupuesto_con_fecha_factura,Presupuesto_Tesoreria,Dias_Vencido_Convenio_Presupuesto,Dias_Vencidos_Reales_Presupuesto,Plazo_Con_Convenio,Plazos_Real,Plazo_Real_Prorroga,Dias_Vencidos_a_cierre_Plazo_factura,Dias_Vencidos_a_cierre_Segun_plazo_convenio,Presupuesto,Tipo3,Estado,En_presupuesto,Canal2,Cupo_De_Credito,Cliente2 ,fichero ,procesado ) VALUES ('','RC','$UltimoId','$nombrecliente','$ncodecliente','$nombrecliente','aplicativo','$NumRc','$newDate','$newDate','0','0','0','0 Dias','aplicativo',$valoranticipo1,0,$valoranticipo1,$valoranticipo1,0,'sin zona','sin ciudad','ANTICIPO $NumRc','ANTICIPO $NumRc','COMERCIAL',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'$newDate','$newDate',0,0,0,0,0,0,0,0,0,0,'NO','Saldos','Saldos', 'No Presupuestado','COMERCIAL',0,'$nombrecliente',0,0)";
	echo $queryinsertanticipo;
			  $Ejecuta = mysqli_query($mysqli, $queryinsertanticipo) ;
			  
			  
//crea registros en data_update
$UltimoIdRC = mysql_insert_id();
$cli = $nombrecliente;
$valo = $valoranticipo1;
	$InsertarSQLn="INSERT INTO rc_data_update(Cliente_Especial,Tipo,DocOrig,Cliente,cod,OpeFecha,VtoFecha,Valor_original,Abono,Saldo,Valor_fact_antes_de_iva,Descuento_pp,Zona,Ciudad,Canal,Fechas_Vencimiento_segun_convenios,Fecha_Vencimiento_Plazo_Factura,Presupuesto_con_fechas_convenio,Presupuesto_con_fecha_factura,Presupuesto_Tesoreria,Presupuesto,Tipo3,Estado,En_presupuesto,Canal2,EstadoProceso,Observacion) VALUES ('', 'RC', $UltimoId, '$nombrecliente', '$ncodecliente','$newDate','$newDate', $valoranticipo1, 0,$valoranticipo1, 0,0,'sin zona','sin ciudad', 'COMERCIAL','$newDate','$newDate',0,0,0,'NO','Saldos','Saldos','No Presupuestado','COMERCIAL','ACT', 'Documento de Anticipo') ";	
	$Result3 = mysqli_query($mysqli, $InsertarSQLn);			  
	
	echo $InsertarSQLn;
}
//fin inserta fila anticipo		
		
		
//control para actualizar los uploads de soporte
$consultainsert ="update uploadsrc set rc = " . $UltimoId . " where rc = " . $rctempo;
mysqli_query($mysqli, $consultainsert);	   
echo 		   $consultainsert;		
header('Location: /scandinavia/aplicaciones/rc/grillaclientes.php?op=GRILLA CLIENTES');
		

?>