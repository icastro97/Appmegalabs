<?php
session_start();
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();
$controla = 0;
$rcids = $_REQUEST['rcid'];
if($_REQUEST['rec'] == "Banco"){
	$valorrechazobanco = $_REQUEST['banco'];
	$cadena = "update rc_cabeza set Aprobado = 0, Rechazo = '', BancoID = " . $valorrechazobanco ." where DocumentID = $rcids";
}
if($_REQUEST['rec'] == "Fecha"){
	$valorrechazofecha =$_REQUEST['fecha'];
    $newDate = date("d/m/Y", strtotime($valorrechazofecha));
	$cadena = " update rc_cabeza set  Aprobado = 0, Rechazo = '', Fecha = '" . $valorrechazofecha . "' where DocumentID = $rcids";
}
if($_REQUEST['rec'] == "Descuentos"){
	$controla = 1;
	$Dtofinanciero = $_REQUEST['Dtofinanciero'];
	$Negociacion = $_REQUEST['Negociacion'];
	$adicional = $_REQUEST['adicional'];
	$descuento =$_REQUEST['descuento'];
	$descuentosadicionales = $_REQUEST['valoranticipo'];
	$valdesadicional = 0;
	if($descuentosadicionales != "0"){
		$valdesadicional = 1;
	}
	
	$cadena = "update rc_cabeza set  Aprobado = 0, Rechazo = '', Descuento1 = $Dtofinanciero,ValorDes1 = $descuento,Descuento2 =$Negociacion,ValorDes2 = $adicional,Descuento3 = $valdesadicional, ValorDes3 = $descuentosadicionales where DocumentID = $rcids";
}



$usuarioinserta = $_SESSION["user_id"];



if (!isset($_REQUEST['fecha2'])) { 
	$fecha2 = "";
	$newDate2 = "";
}
else{
	$fecha2 = $_REQUEST['fecha2'];
	$newDate2 = date("Y/m/d", strtotime($fecha2));
}


$sql=$cadena;
echo  $cadena . "<br>";
mysqli_query($mysqli, $sql);
    
//actualiza detalles 
if($controla == 1)		{
		$UltimoId = $rcids;
		
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
					  
								 
					  $sql="update rd_detalle set
					   ValorDocumento=$avvalorfactura[$k],RetImpositiva=$avimpositiva[$k],DesPPago=$avppago[$k],DesAdicional=$adadicional[$k],OtrosDescuentos=$avdotros[$k],NoNota=$avnotano[$k],ValNota=$avvalnota[$k],ValNeto=$kk,DiasPago=$avcondiciondias where DocumentID = $UltimoId";
					  
					  echo $sql . "<br>";
		
					  mysqli_query($mysqli, $sql);
				}
}
		
header('Location: /scandinavia/aplicaciones/rc/grillaclientes.php?op=GRILLA CLIENTES');
		

?>