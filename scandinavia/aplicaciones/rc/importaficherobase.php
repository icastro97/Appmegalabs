<?php
set_time_limit(0);
include '../../mcv5/clases/DB.class.php';
require('../../cabeza.php'); 
if(isset($_POST['btn-upload']))
{    
     
 $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="uploads/";
 $date = date("Y-m-d H:i:s");
 $usuario = $_SESSION["user_id"];
 $tipoupload = "Base Cartera";
 
 move_uploaded_file($file_loc,$folder.$file);
 $sql="INSERT INTO tbl_uploads(file,type,size,date, user, tipo) VALUES('$file','$file_type','$file_size', '$date', '$usuario', '$tipoupload')";
 mysqli_query($mysqli, $sql);
 
 $sqil="SELECT @@identity AS id";
 $rs = mysqli_query($mysqli, $sqil);
 
 if ($row = mysqli_fetch_row($rs)) {
	$ultimoid = trim($row[0]);
 }
 
 
 
 
 /**/
 date_default_timezone_set("America/Bogota");
 $db_host="localhost";
	$db_name="scandapp_app";
	$db_user="scandapp_app";
	$db_pass="Qwerty1234$";
    include '../../mcv5/clases/simplexlsx.class.php';	
	
    $xlsx = new SimpleXLSX(  $folder.$file );
    try {
       $conn = new PDO( "mysql:host=$db_host;dbname=$db_name", "$db_user", "$db_pass");
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $stmt = $conn->prepare( "
	INSERT INTO rc_data (Cliente_Especial,Tipo,DocOrig,Cliente,cod,CliVtaGrupoDes,Analista_cartera,DocVouchOrig,OpeFecha,VtoFecha,VtoDias_sistema,Calculo_fecha_ven_con_plazo_sistema,CliCondTipo,Descrpcion_condicion,Tipo_de_Pedido_AX_09,Valor_original,Abono,Saldo,Valor_fact_antes_de_iva,Descuento_pp,Zona,Ciudad,Concepto,Descripcion_Doc,Canal,Plazo1_999_181,Plazo2_180_121,Plazo3_120_91,Plazo4_90_61,Plazo5_60_31,Plazo6_30_0,Total_cartera_corriente,Plazo1_1_30,Plazo2_31_60,Plazo3_61_90,Plazo4_91_120,Plazo5_121_180,Plazo6_181_360,Plazo7_361,Total_cartera_vencida,Total,Presupuesto_general,Fechas_Vencimiento_segun_convenios,Fecha_Vencimiento_Plazo_Factura,Presupuesto_con_fechas_convenio,Presupuesto_con_fecha_factura,Presupuesto_Tesoreria,Dias_Vencido_Convenio_Presupuesto,Dias_Vencidos_Reales_Presupuesto,Plazo_Con_Convenio,Plazos_Real,Plazo_Real_Prorroga,Dias_Vencidos_a_cierre_Plazo_factura,Dias_Vencidos_a_cierre_Segun_plazo_convenio,Presupuesto,Tipo3,Estado,En_presupuesto,Canal2,Cupo_De_Credito,Cliente2,fichero) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindParam( 1, $Cliente_Especial);
	$stmt->bindParam( 2, $Tipo);
	$stmt->bindParam( 3, $DocOrig);
	$stmt->bindParam( 4, $Cliente);
	$stmt->bindParam( 5, $cod);
	$stmt->bindParam( 6, $CliVtaGrupoDes);
	$stmt->bindParam( 7, $Analista_cartera);
	$stmt->bindParam( 8, $DocVouchOrig);
	$stmt->bindParam( 9, $OpeFecha);
	$stmt->bindParam( 10, $VtoFecha);
	$stmt->bindParam( 11, $VtoDias_sistema);
	$stmt->bindParam( 12, $Calculo_fecha_ven_con_plazo_sistema);
	$stmt->bindParam( 13, $CliCondTipo);
	$stmt->bindParam( 14, $Descrpcion_condicion);
	$stmt->bindParam( 15, $Tipo_de_Pedido_AX_09);
	$stmt->bindParam( 16, $Valor_original);
	$stmt->bindParam( 17, $Abono);
	$stmt->bindParam( 18, $Saldo);
	$stmt->bindParam( 19, $Valor_fact_antes_de_iva);
	$stmt->bindParam( 20, $Descuento_pp);
	$stmt->bindParam( 21, $Zona);
	$stmt->bindParam( 22, $Ciudad);
	$stmt->bindParam( 23, $Concepto);
	$stmt->bindParam( 24, $Descripcion_Doc);
	$stmt->bindParam( 25, $Canal);
	$stmt->bindParam( 26, $Plazo1_999_181);
	$stmt->bindParam( 27, $Plazo2_180_121);
	$stmt->bindParam( 28, $Plazo3_120_91);
	$stmt->bindParam( 29, $Plazo4_90_61);
	$stmt->bindParam( 30, $Plazo5_60_31);
	$stmt->bindParam( 31, $Plazo6_30_0);
	$stmt->bindParam( 32, $Total_cartera_corriente);
	$stmt->bindParam( 33, $Plazo1_1_30);
	$stmt->bindParam( 34, $Plazo2_31_60);
	$stmt->bindParam( 35, $Plazo3_61_90);
	$stmt->bindParam( 36, $Plazo4_91_120);
	$stmt->bindParam( 37, $Plazo5_121_180);
	$stmt->bindParam( 38, $Plazo6_181_360);
	$stmt->bindParam( 39, $Plazo7_361);
	$stmt->bindParam( 40, $Total_cartera_vencida);
	$stmt->bindParam( 41, $Total);
	$stmt->bindParam( 42, $Presupuesto_general);
	$stmt->bindParam( 43, $Fechas_Vencimiento_segun_convenios);
	$stmt->bindParam( 44, $Fecha_Vencimiento_Plazo_Factura);
	$stmt->bindParam( 45, $Presupuesto_con_fechas_convenio);
	$stmt->bindParam( 46, $Presupuesto_con_fecha_factura);
	$stmt->bindParam( 47, $Presupuesto_Tesoreria);
	$stmt->bindParam( 48, $Dias_Vencido_Convenio_Presupuesto);
	$stmt->bindParam( 49, $Dias_Vencidos_Reales_Presupuesto);
	$stmt->bindParam( 50, $Plazo_Con_Convenio);
	$stmt->bindParam( 51, $Plazos_Real);
	$stmt->bindParam( 52, $Plazo_Real_Prorroga);
	$stmt->bindParam( 53, $Dias_Vencidos_a_cierre_Plazo_factura);
	$stmt->bindParam( 54, $Dias_Vencidos_a_cierre_Segun_plazo_convenio);
	$stmt->bindParam( 55, $Presupuesto);
	$stmt->bindParam( 56, $Tipo3);
	$stmt->bindParam( 57, $Estado);
	$stmt->bindParam( 58, $En_presupuesto);
	$stmt->bindParam( 59, $Canal2);
	$stmt->bindParam( 60, $Cupo_De_Credito);
	$stmt->bindParam( 61, $Cliente2);
	$stmt->bindParam( 62, $fichero); 					
	$i= 0;
	
	
    foreach ($xlsx->rows() as $fields)
    {
		if ($i!=0){
			     $Cliente_Especial=$fields[0];
				 $Tipo=$fields[1];
				 $DocOrig=$fields[2];
				 $Cliente=$fields[3];
				 $cod=$fields[4];
				 $CliVtaGrupoDes=$fields[5];
				 $Analista_cartera=$fields[6];
				 $DocVouchOrig=$fields[7];
				 $OpeFecha=$fields[8];
				 $VtoFecha=$fields[9];
				 $VtoDias_sistema=$fields[10];
				 $Calculo_fecha_ven_con_plazo_sistema=$fields[11];
				 $CliCondTipo=$fields[12];
				 $Descrpcion_condicion=$fields[13];
				 $Tipo_de_Pedido_AX_09=$fields[14];
				 $Valor_original=$fields[15];
				 $Abono=$fields[16];
				 $Saldo=$fields[17];
				 $Valor_fact_antes_de_iva=$fields[18];
				 $Descuento_pp=$fields[19];
				 $Zona=$fields[20];
				 $Ciudad=$fields[21];
				 $Concepto=$fields[22];
				 $Descripcion_Doc=$fields[23];
				 $Canal=$fields[24];
				 $Plazo1_999_181=$fields[25];
				 $Plazo2_180_121=$fields[26];
				 $Plazo3_120_91=$fields[27];
				 $Plazo4_90_61=$fields[28];
				 $Plazo5_60_31=$fields[29];
				 $Plazo6_30_0=$fields[30];
				 $Total_cartera_corriente=$fields[31];
				 $Plazo1_1_30=$fields[32];
				 $Plazo2_31_60=$fields[33];
				 $Plazo3_61_90=$fields[34];
				 $Plazo4_91_120=$fields[35];
				 $Plazo5_121_180=$fields[36];
				 $Plazo6_181_360=$fields[37];
				 $Plazo7_361=$fields[38];
				 $Total_cartera_vencida=$fields[39];
				 $Total=$fields[40];
				 $Presupuesto_general=$fields[41];
				 $Fechas_Vencimiento_segun_convenios=$fields[42];
				 $Fecha_Vencimiento_Plazo_Factura=$fields[43];
				 $Presupuesto_con_fechas_convenio=$fields[44];
				 $Presupuesto_con_fecha_factura=$fields[45];
				 $Presupuesto_Tesoreria=$fields[46];
				 $Dias_Vencido_Convenio_Presupuesto=$fields[47];
				 $Dias_Vencidos_Reales_Presupuesto=$fields[48];
				 $Plazo_Con_Convenio=$fields[49];
				 $Plazos_Real=$fields[50];
				 $Plazo_Real_Prorroga=$fields[51];
				 $Dias_Vencidos_a_cierre_Plazo_factura=$fields[52];
				 $Dias_Vencidos_a_cierre_Segun_plazo_convenio=$fields[53];
				 $Presupuesto=$fields[54];
				 $Tipo3=$fields[55];
				 $Estado=$fields[56];
				 $En_presupuesto=$fields[57];
				 $Canal2=$fields[58];
				 $Cupo_De_Credito=$fields[59];
				 $Cliente2=$fields[60];
  			     $fichero=$ultimoid;
			 
			 //$stmt->debugDumpParams();
			 
			 try {
                $stmt->execute();
             }
             catch(PDOException $e)
             {
                echo $e->getMessage();
				break;
              }			 			 			 
		}
		$i++;
    }
 /**/ 
 header('Location: /scandinavia/default1.php?group=ReciboCaja');
}

?>
 <div class="panel-heading"> Upload de Fichero </div>
<form action="" method="post" enctype="multipart/form-data">

<table width="50%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td colspan="4" align="center"><br>
      Fichero Base Cartera<br>
      <br></td>
    </tr>
  <tr>
    <td width="1%" align="right">&nbsp;</td>
    <td colspan="2" align="right"><input type="file" name="file" /></td>
    <td width="33%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td width="33%" align="right">&nbsp;</td>
    <td width="33%" align="center"><br>      <button type="submit" name="btn-upload" class="btn btn-success">Enviar</button></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>

<?php require_once('../../pie.php'); ?>
