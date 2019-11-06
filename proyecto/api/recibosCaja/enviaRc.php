<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
require("../precios/database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  //TRAEMOS LA SESION
require '../../../scandinavia/seguridad/config.php';

  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  $user = $_SESSION['user_id'];
  $doc = $_GET['doc'];
  $productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
 //   var_dump($productosArray);
 $i = 0;
  foreach ($productosArray as $row) {
         $descuento = 0;
   if($row['valorDescuentoAdicional'] != 0){
       $add = 1;
   }
   else{
       $add = 0;
   }
   $adicional = $row['valorDescuentoAdicional'];
   
   $banco = $row['banco'];
   $fechaactual = $row['fechaPago'];
   $observaciones = $row['obser'];
   $TipoPago = $row['tipoPago'];
   $NoCheque = $row['numcheque'];
   $ValorCheque = $row['valorCheque'];
   $newDate2 = $row['fechaPago'];
      $newDate = date('Y/m/d');	
      $cliente = $row['cliente'];
      
         //ingresamos a rccabeza
           $sql1="UPDATE rc_cabeza SET
           Descuento1 = '1'
           ,ValorDes1 = '$descuento'
           ,Descuento2 = '$add' 
           ,ValorDes2 = '$adicional' 
           ,Descuento3 = '1' 
           ,ValorDes3 = 0 
           ,BancoID = '$banco'
           ,Fecha = '$newDate' 
           ,FechaReal = '$fechaactual' 
           ,usuario = '99',
           Observaciones = '$observaciones', 
           TipoPago = '$TipoPago', 
           Cheque = '$NoCheque', 
           Valor = '$ValorCheque', 
           FechaCheque = '$newDate2'
           WHERE DocumentID = $doc";
      //var_dump($sql1);
       $ejecutar =$con->query($sql1);
      
      
      
      
     
    //crea registros en data 
        $NumRc = "RC". $doc;
      	$sql  = "insert into rc_data
      	(Cliente_Especial
      	,Tipo,DocOrig
      	,Cliente
      	,cod
      	,CliVtaGrupoDes
      	,Analista_cartera
      	,DocVouchOrig,
      	OpeFecha
      	,VtoFecha
      	,VtoDias_sistema
      	,Calculo_fecha_ven_con_plazo_sistema
      	,CliCondTipo,Descrpcion_condicion
      	,Tipo_de_Pedido_AX_09,Valor_original,
      	Abono
      	,Saldo
      	,Valor_fact_antes_de_iva
      	,Descuento_pp
      	,Zona
      	,Ciudad
      	,Concepto
      	,Descripcion_Doc
      	,Canal
      	,Plazo1_999_181
      	,Plazo2_180_121
      	,Plazo3_120_91,
      	Plazo4_90_61,
      	Plazo5_60_31,
      	Plazo6_30_0,
      	Total_cartera_corriente,
      	Plazo1_1_30,
      	Plazo2_31_60,
      	Plazo3_61_90,
      	Plazo4_91_120,
      	Plazo5_121_180,
      	Plazo6_181_360,
      	Plazo7_361,
      	Total_cartera_vencida,
      	Total,
      	Presupuesto_general,
      	Fechas_Vencimiento_segun_convenios,
      	Fecha_Vencimiento_Plazo_Factura,
      	Presupuesto_con_fechas_convenio,
      	Presupuesto_con_fecha_factura,
      	Presupuesto_Tesoreria,
      	Dias_Vencido_Convenio_Presupuesto,
      	Dias_Vencidos_Reales_Presupuesto,
      	Plazo_Con_Convenio,Plazos_Real,
      	Plazo_Real_Prorroga,
      	Dias_Vencidos_a_cierre_Plazo_factura,
      	Dias_Vencidos_a_cierre_Segun_plazo_convenio,
      	Presupuesto,
      	Tipo3,
      	Estado,
      	En_presupuesto,
      	Canal2,
      	Cupo_De_Credito,
      	Cliente2,
      	fichero 
      	,procesado ) 
      	VALUES('',
      	'RC',
      	'$doc',
      	'$row[cliente]',
      	'$row[codigo]',
      	'$row[cliente]',
      	'aplicativo',
      	'$NumRc',
      	'$newDate',
      	'$newDate',
      	'0',
      	'0',
      	'0',
      	'0 Dias',
      	'aplicativo',
      	0,
      	0,
      	0,
      	0,
      	0,
      	'sin zona',
      	'sin ciudad',
      	'ANTICIPO $NumRc',
      	'ANTICIPO $NumRc',
      	'COMERCIAL',
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	'$newDate',
      	'$newDate',
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	0,
      	'NO',
      	'Saldos',
      	'Saldos',
      	'No Presupuestado',
      	'COMERCIAL'
      	,0,
      	'$row[cliente]',
      	0,
      	0)";
  //  var_dump($sql);
   $ejecucion=$con->query($sql);
   

   
   

  $sql2 = "INSERT INTO rc_data_update
  (Cliente_Especial,
  Tipo,
  DocOrig,
  Cliente,
  cod,
  OpeFecha,
  VtoFecha,
  Valor_original,
  Abono,
  Saldo,
  Valor_fact_antes_de_iva,
  Descuento_pp,
  Zona,
  Ciudad,
  Canal,
  Fechas_Vencimiento_segun_convenios,
  Fecha_Vencimiento_Plazo_Factura,
  Presupuesto_con_fechas_convenio,
  Presupuesto_con_fecha_factura,
  Presupuesto_Tesoreria,
  Presupuesto,
  Tipo3,
  Estado,
  En_presupuesto,
  Canal2,
  EstadoProceso,
  Observacion)
  VALUES
  ('',
  'RC',
  $doc,
  '$row[cliente]',
  '$row[codigo]',
  '$newDate',
  '$newDate',
  0,
  0,
  0,
  0,
  0,
  'sin zona',
  'sin ciudad',
  'COMERCIAL',
  '$newDate',
  '$newDate',
  0,
  0,
  0,
  'NO',
  'Saldos',
  'Saldos',
  'No Presupuestado',
  'COMERCIAL',
  'ACT', 
  'Documento de Anticipo')";
 // var_dump($sql2);
  $resultado=$con->query($sql2);
  
  }
//var_dump($ejecutar);
  class Result {}
  if ($ejecutar == true) {
    $response = new Result();
    $response->resultado = 'OK';

} else {
  $response = new Result();
  $response->resultado=mysqli_error($con);
  $reponse->mensaje = mysqli_error($con);
    
}

  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>