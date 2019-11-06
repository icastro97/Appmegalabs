<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
$parametro = $_REQUEST['id'];


if (isset($_REQUEST['documento'])) {
	$sid = "";   
	foreach($_REQUEST['documento'] as $key=>$value)
	{
		$hh = $value;
		$extrae =  $hh."' or Documento = '";	
		$sid = $sid . $extrae;
	}  
	  $sid  = substr ($sid, 0, strlen($sid) - 18); //elimina la ultima,
	  $sid  =  $sid  ;		
}

function eliminar_tildes($cadena){
 
    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    $cadena = utf8_encode($cadena);
 
    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );
 
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );
 
    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );
 
    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );
 
    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );
 
    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );
 
    return $cadena;
} 

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from empresa
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar

//cabeza de recibo
$conditionscabeza['where'] = array('id_cabeza'=> $parametro,); 
$cabeza = $db->getRows('lg_cabeza',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('id'=> $parametro,); 
$detalle = $db->getRows('lg_det_cabeza',$conditionsdetalle); //ojo se pone tabla a consultar


//totales por moneda
$conditionstotales['where'] = array('id'=> $parametro,); 
$totalesdetalle = $db->getRows('vw_totlegalizacion',$conditionstotales); //ojo se pone tabla a consultar


//detalle soportes
$sql20= "select a.factura,a.nit ,a.fichero as name, a.tipo as type, a.id as legalizacion, b.ico from lg_det_cabeza a inner join rc_mime b on a.tipo = b.type where a.id =   " . $parametro;
$Obser=mysqli_query($mysqli, $sql20);
$row_Obser = mysqli_fetch_assoc($Obser);
$rowcount=mysqli_num_rows($Obser);



 
$limpiacargo2 = eliminar_tildes($cabeza[0]['observaciones']);
$limpiacargo4 = eliminar_tildes($cabeza[0]['tipolegalizacion']);

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>


<?php require_once('../../cabeza.php'); 


if(!isset($_SESSION["session_username"])) {	
  header("location:../../logininicial.php");
} 
else {?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
	
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 

<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
	color: white;
}
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
            
   <a href="https://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/listadolegalizacionesc.php" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         <br>
          <section class="wrapper site-min-height">          
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
          		<section id="unseen">

                  
              <div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<p>
	  <?php }  ?>
	</p> 
  <form action="apruebalgc.php" method="get">
  <table width="80%" border="0">
  <tr>	    
	    <td colspan="2" align="center" valign="top"><img src="/scandinavia/assets/img/logobig.png" alt="" width="186" height="117"  /></td>
      <td colspan="2" align="center"><h3>Legalización de Gastos</h3></td>
	    
	  </tr>
    </table>
    <div class="panel-body">
  <div class="panel panel-default users-content">
    <div class="panel" style="border:1px solid #00AB84;">
    <div class="panel-heading text-center form-control" >Información General</div>
	<table width="100%" border="0"> 
  
	  <tr>	    
	    <td class="formato" colspan="5" align="left"><strong>Tipo de Legalización:</strong> <?php echo $limpiacargo4; ?></td><td >&nbsp;</td> <td class="formato" colspan="5"><strong>Linea: </strong><?php echo $cabeza[0]['linea']; ?></td> 
      <td class="formato" colspan="6" ><strong> </strong></td><td class="formato" colspan="6" ><strong>Legalización: </strong><?php echo $cabeza[0]['id_cabeza']; ?></td>
     
	  <tr>	 
	    
	  </tr>
	 <tr>
     <td class="formato" colspan="5"><strong>Fecha:</strong> <?php echo $cabeza[0]['fecha']; ?></td><td class="formato" colspan="5"><strong>Cto Cto: </strong><?php echo $cabeza[0]['ctocto']; ?></td>
   </tr>
   <tr>
     <td class="formato" colspan="5"><strong>Identificación: </strong><?php echo $cabeza[0]['identificacion']; ?></td><td >&nbsp;</td><td class="formato" colspan="5"><strong>Cargo: </strong><?php echo $cabeza[0]['cargo']; ?></td>
   </tr>
   <tr>
   <td width="20%" class="formato" colspan="5"><strong>Nombre: </strong><?php echo $cabeza[0]['nombre']; ?></td><td >&nbsp;</td>   <td class="formato" colspan="5"><strong>Area Terapeutica: </strong><?php echo $cabeza[0]['area']; ?></td>
   </tr>
   
	  </table>	
    
	  
            
              <input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
              <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /> 
            </div>
            <div class="table-responsive">
            <table class="table table-striped ">
            <tbody id="userData">
           
            </tbody>
            <thead>
              <tr>
                <th rowspan="3"></th>
               
                <th rowspan="3" valign="bottom"><div align="center">Fecha</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Factura</div></th>
                <th rowspan="3"  ><div align="center">NIT</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Establecimiento </div></th>
                <th rowspan="3" valign="bottom"><div align="center">Ciudad</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Codigo Inversion</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Descripcion</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Tipo Gasto</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Concepto</div></th>
                <th rowspan="3" valign="bottom"><div align="right">Valor</div></th>
                <th rowspan="3" valign="bottom">Soporte</th>
                <th rowspan="3" valign="bottom">Recibido</th>
              </tr>
              <tr></tr>
            </thead>
            <tbody id="userData2">
              <?php $sumaneto = 0;
					if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
              <tr>
              <td>&nbsp;</td>
               
                <td align="center"><?php echo $user['fecfact']; ?></td>
                <td align="center">
                  <?=($user['factura']) ?></td>
                <td align="center">
                  <?=($user['nit']) ?></td>
                <td align="center">
                  <?=$user['establecimiento']; ?></td>
                <td align="center">
                  <?=$user['ciudad']; ?></td>
                <td align="center">
                  <?=$user['cinversion']; ?></td>
                <td align="center"><?php $limpiacargo3 = eliminar_tildes($user['descripcion']);?>
                  <?=$limpiacargo3 ?></td>
                <td align="center">
                  <?=$user['tipogasto']; ?></td>
                <td align="center">
                  <?=$user['concepto']; ?></td>
                             
                <td align="right"><?=$user['moneda']?> $<?=number_format($user['valor'], 2); ?></td>
                <td align="center"><?php 
                if($user['tipo'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_word.png' width='20' height='20' />"; 
                }
                else if($user['tipo'] == "image/png")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_png.png' width='20' height='20' />"; 
                  
                }  
                else if ($user['tipo'] == "application/pdf")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_pdf.png' width='20' height='20' />";                   
                }
                else if($user['tipo'] == "image/jpg" or $user['tipo'] == "image/jpeg")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_jpg.png' width='20' height='20' />"; 
                }
                else if($user['tipo'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' />"; 
                }
                else if($user['tipo'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_powerpoint.png' width='20' height='20' />"; 
                }
                  else if($user['tipo'] == "application/vnd.ms-excel")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' />"; 
                }
                ?></td>                    
                <td align="center">
                    
                  <?php 
                  $recibido = $user['recibido'];
                  
                  if($recibido == "Si")
                  {
                      echo "Si";
                  }
                  else
                  {
                      echo "No";
                  }
                  ?></td>
                
                   <?php $sumaneto = $sumaneto + $user['valor'];?>
              </tr>
              <?php endforeach; else: ?>
              <tr>
                <td colspan="5">No existen documentos para mostrar......</td>
              </tr>
              <?php endif; 
			  $saldocontrol = $cabeza[0]['valoranticipo'] -  $sumaneto;
			  if($cabeza[0]['valoranticipo'] != 0){
			  	$sumatotal = $saldocontrol;
			  }else{
			  	$sumatotal = $sumaneto;
			  }
			  
			  ?>

            </tbody>
            <tbody>
            </tbody>
           
            </table> </div>
    <br />
<br />

            <table width="100%" border="0" cellspacing="1" cellpadding="1">
            
              <tr>
              <th rowspan="3"></th>
                <td width="21%"  colspan="5">Observaciones:</td>
                <td width="39%"name="txtobservaciones" class="formato" id="txtobservaciones"><?=$limpiacargo2?>
                </td>
                <td width="20%" align="right">Total:</td>
                <td width="20%">		<table class="table table-striped">
            <tbody id="userData2">
              <tr></tr>
            </tbody>
            <thead>
              <tr>
                <th rowspan="3"></th>
                <th rowspan="3" valign="bottom"><div align="center">Moneda</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Valor</div></th>
                
              </tr>
              <tr></tr>
            </thead>
            <tbody id="userData5">
              <?php $sumavalores = 0; $arraymonedas = "";
					if(!empty($totalesdetalle)): $countyer = 0; foreach($totalesdetalle as $usertotdetalle): $countyer++; ?>
              <tr>
              <td>&nbsp;</td>    
              
                <td align="center"><?php echo $usertotdetalle['moneda']; ?></td>
                <td align="right">
                  $<?=number_format(($usertotdetalle['valor']), 2)?></td>                                                
              </tr>
              <?php 
			  $arraymonedas = $arraymonedas . ", " . $usertotdetalle['moneda'] . "$" . number_format(($usertotdetalle['valor']), 2);
			  endforeach; else: ?>
              <tr>
                <td colspan="5">No existen valores para mostrar......</td>
              </tr>
              <?php endif; ?>
            </tbody>
            <tbody>
            </tbody>
        </table>  
                </td>
              </tr>

            </table>
            
            
            <br />
            <br />
            <?php
if($cabeza[0]['tipolegalizacion'] == "Reintegro Gastos")
{
	$text1= "<div style='text-align:justify;'>SCANDINAVIA PHARMA LTDA., consignará a nombre de " . $cabeza[0]['nombre']  . " el valor de <B>" . $arraymonedas . "</B>, correspondiente  al valor total a reintegrar a favor de " .  $cabeza[0]['nombre'] . " de la presente legalización de gastos, siempre que los gastos hayan sido previamente autorizados y los soportes de los mismos, cumplan los criterios legales vigentes establecidos y por mi conocidos. En caso que los soportes no cumplan los criterios legales, acepto el no reintegro de los valores que no cumplan con estos criterios.</div>";
}
else{
	$text1= "<div style='text-align:justify;'>Yo manifiesto que recibí de SCANDINAVIA PHARMA LTDA, Nit 800.133.807-1 la suma de Valor del Anticipo Recibido, denominada Valor del Anticipo Recibido. Declaro conocer las condiciones y términos de la Compañía relacionadas con la política de legalizaciones de Anticipos, entre ellas la de legalizar la utilización del anticipo en un plazo máximo de cinco (5) días, una vez finalizado el viaje o la comisión que ha originado el recibo del citado anticipo. Autorizo en forma expresa e irrevocable a SCANDINAVIA PHARMA LTDA  Nit 800.133.807-1 para que deduzca de las sumas que se hayan  causado o se causen en el futuro a mi favor por concepto de salarios, prestaciones sociales, vacaciones, bonificaciones de cualquier naturaleza,  eventuales indemnizaciones y cualquier acreencias laboral que  deba liquidar y pagar a mi favor bien sea durante la vigencia o a la terminación de mi contrato de trabajo, el valor de $" . number_format($saldocontrol, 2) . ", correspondiente al saldo a favor de la empresa, sobrante del presente anticipo que estoy legalizando, denominado saldo a reintegrar</div>";
}

echo $text1;

?>            

          

            
            <p>&nbsp;</p>
            <p>&nbsp;</p>
             <?php if($cabeza[0]['estado'] == 'APR'){?>
            <table width="70%" border="0" class="table table-striped">
              <tr>
                <td colspan="2" ><h4 align="center">Documento Aprobado Primer Nivel <br><br><?=$cabeza[0]['observacionapro']?></h4></td>
              </tr>
              <tr>
                <td > </td>
                <td><h4>Observaciones </h4></td>
              </tr>
              <tr>
                <td width="23%" align="right"><h5>Estado:</h5></td>
                <td><label for="estadoscartera"></label>
                  <select  name="estadoscartera" id="estadoscartera" class="form-control form-control-lg" onchange="habilitartxt(this.value);">
                    <option value="APRC">APROBADO CONTABILIDAD</option>
                    <option value="RECC">RECHAZADO CONTABILIDAD </option>
                  </select></td>
              </tr>
              <tr>
                <td><input name="pasaguid" type="hidden" id="pasaguid" value="<?=$consultaguid?>" /></td>
                <td><textarea name="ObservacionP" cols="40" rows="3" id="ObservacionP" class="form-control form-control-lg" placeholder="Descripcion"></textarea></td>
              </tr>
              <tr>
                  <input type="hidden" name="usuariolg" value="<?= $cabeza[0]['identificacion']?>">
                <td>&nbsp;</td>
                <td><input type="submit" name="Aprobar" id="Aprobar" value="Procesar" class="btn" style="background-color:#00AB84; color: white;" /></td>
              </tr>
            </table>
           <div align="center">
               <?php } else 
			   { 			   			               
   			       if($cabeza[0]['estado'] == 'REC'){ ?> 
            </div>
            <h4 align="center">Documento Rechazado Primer Nivel<br> <?=$cabeza[0]['observacionapro']?>  </h4> 
            <div align="center">
              <?php }  
			   if($cabeza[0]['estado'] == 'RECC'){ ?> 
            </div>
            <h4 align="center">DOCUMENTO RECHAZADO POR CONTABILIDAD<br> <?=$cabeza[0]['observacionP']?>  </h4> 
            <div align="center">
              <?php }
			  if($cabeza[0]['estado'] == 'APRC'){ ?> 
            </div>
            <h4 align="center">DOCUMENTO APROBADO POR CONTABILIDAD<br> <?=$cabeza[0]['observacionP']?>  </h4> 
            <div align="center">
                <?php }
			  } ?>
            </div>
            <p>&nbsp;</p>
            <p>
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>">
            <input name="rcid" type="hidden" id="rcid" value="<?=$_REQUEST['id']?>" />
            </p>
            
            </form>           
        </div>
</div>
</div>                  
                  
                  
                </section>
                <p>&nbsp;</p>
      </section><! --/wrapper --><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2018 - HBT
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->


<?php require_once('../../pie.php'); }?>


		
				
