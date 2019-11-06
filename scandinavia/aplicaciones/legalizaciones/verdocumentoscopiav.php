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


//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from empresa
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar

//cabeza de recibo
$conditionscabeza['where'] = array('id '=> $parametro,); 
$cabeza = $db->getRows('lg_cabeza',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('id'=> $parametro,); 
$detalle = $db->getRows('lg_det_cabeza',$conditionsdetalle); //ojo se pone tabla a consultar


//totales por moneda
$conditionstotales['where'] = array('id'=> $parametro,); 
$totalesdetalle = $db->getRows('vw_totlegalizacion',$conditionstotales); //ojo se pone tabla a consultar



//flujo de aprobacion cambio HBT Feb 2019
$proceso = 'Legalizaciones';
$userid = $_SESSION['id'];
$pasoactual = $cabeza[0]['paso'];
$siguientepaso = $pasoactual + 1;
$filas2 = 0;
//ultimo registro para control de estado
$sql99 = "SELECT paso FROM  matrizaprobacion where idproceso = '" . $proceso . "' ORDER by paso DESC LIMIT 1";
$result99 = mysqli_query($mysqli, $sql99);
$ultimopaso99 =  mysqli_fetch_row($result99);

//paso en el que va
$sql = "select * from matrizaprobacion where idproceso = '" . $proceso . "'"; 
$result1 = mysqli_query($mysqli, $sql);
$filas = mysqli_num_rows($result1);
if($filas > 0){
	mysqli_data_seek($result1, $pasoactual);
	
	$row = mysqli_fetch_row($result1);
	 
	for($f=1;$f<=$filas;++$f){
	    if($row[2] == $siguientepaso)
		{
		   $pasoabuscar = $row[2];
		   
  	       //echo "Paso a buscar " . $pasoabuscar . " numero de filas  " . $filas  . " --> " . $row[0], $row[1], $row[2], $row[3];
		   
		   $sql = "select * from matrizaprobacion where idproceso = '" . $proceso . "' and paso = ". $pasoabuscar . " and concat( ',', responsable, ',') like '%," . $userid  . ",%'";
		   //echo "<br>" . $sql ;
		   $result2 = mysqli_query($mysqli, $sql);
		   $filas2 = mysqli_num_rows($result2);
		   break;
		}
	}
}




//cambio HBT Feb 2019


//detalle soportes
$sql20= "select a.factura,a.nit ,a.fichero as name, a.tipo as type, a.id as legalizacion, b.ico from lg_det_cabeza a inner join rc_mime b on a.tipo = b.type where a.id =   " . $parametro;
$Obser=mysqli_query($mysqli, $sql20);
$row_Obser = mysqli_fetch_assoc($Obser);
$rowcount=mysqli_num_rows($Obser);




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

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

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
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
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
	  
	 
	</p> <form action="apruebalg.php" method="get">
   

	<table width="100%" border="0">
	  <tr>
	    <td colspan="2" align="center">&nbsp;</td>
	    <td colspan="3" align="center"><h3>Legalización de Gastos</h3></td>
	    <td colspan="2" align="center" valign="top"><img src="/scandinavia/assets/img/logobig.png" alt="" width="186" height="117" /></td>
	    </tr>
	  <tr>
	    <td colspan="2" align="center">&nbsp;</td>
	    <td colspan="4" align="right">&nbsp;</td>
	    <td align="center" valign="top">&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="2" align="center">&nbsp;</td>
	    <td colspan="4" align="right">Tipo de Legalización:&nbsp;&nbsp;&nbsp;</td>
	    <td align="center" valign="top"><?php echo $cabeza[0]['tipolegalizacion']; ?></td>
	    </tr>
	  <tr>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    </tr>
	  <tr>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td ><label for="textarea"></label></td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td align="right" >Valor Anticipo:</td>
	    <td ><input name="ValorAnticipo" type="text" disabled="disabled" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="ValorAnticipo" value="<?php echo $cabeza[0]['valoranticipo']; ?>" /></td>
	    </tr>
	  <tr>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    </tr>
	  <tr>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    </tr>
	  <tr>
	    <td ><div align="center">Fecha</div></td>
	    <td ><div align="center">Identificación</div></td>
	    <td ><div align="center">Nombre</div></td>
	    <td ><div align="center">Cargo</div></td>
	    <td ><div align="center">Cto Cto</div></td>
	    <td ><div align="center">Linea</div></td>
	    <td ><div align="center">Area Terapeutica</div></td>
	    </tr>
	  <tr>
	    <td width="12%" ><div class='input-group date' id='datetimepicker1'>
                         <input type='text' name="fecha" id="fecha" class="form-control" required min="" value = "<?php echo $cabeza[0]['fecha']; ?>" placeholder="Fecha"/>
                         <span class="input-group-addon">
                         <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                </div></td>
	    <td width="13%" ><input name="identificacion"  type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="identificacion"  placeholder="Identificacion" value = "<?php echo $cabeza[0]['identificacion']; ?>"/></td>
	    <td width="21%" ><input name="nombre" type="text" disabled="disabled" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="nombre"  placeholder="Nombres" value="<?php echo $cabeza[0]['nombre']; ?>"/></td>
	    <td width="13%" ><input name="cargo" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="cargo"  placeholder="Cargo" value="<?php echo $cabeza[0]['cargo']; ?>"/></td>
	    <td width="9%" ><input name="ctocto" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="ctocto" value="<?php echo $cabeza[0]['ctocto']; ?>" /></td>
	    <td width="13%" ><input name="linea" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="linea" value="<?php echo $cabeza[0]['linea']; ?>" /></td>
	    <td width="19%" ><input name="area" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="area" value="<?php echo $cabeza[0]['area']; ?>" /></td>
	    </tr>
	  <tr>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    </tr>
        
	
	  </table>	
	<div >
	  <div class="panel panel-default users-content">
            <div class="panel-body"> <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"])) { ?> <a href="view/addEdit.php?op=<?php echo $_REQUEST['op']?>" class="glyphicon glyphicon-plus" ></a><?php }?>
              <input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
              <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /> 
            </div>
            <table class="table table-striped">
            <tbody id="userData">
              <tr></tr>
            </tbody>
            <thead>
              <tr>
                <th rowspan="3"></th>
               
                <th rowspan="3" valign="bottom"><div align="center">Fecha</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Factura</div></th>
                <th rowspan="3" align="center" ><div align="center">NIT</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Establecimiento </div></th>
                <th rowspan="3" valign="bottom"><div align="center">Ciudad</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Codigo Inversion</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Tipo Gasto</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Concepto</div></th>
                <th rowspan="3" valign="bottom"><div align="right">Valor</div></th>
                <th rowspan="3" valign="bottom">Soporte</th>
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
                <td align="center">
                  <?=$user['tipogasto']; ?></td>
                <td align="center">
                  <?=$user['concepto']; ?></td>
                             
                <td align="right"><?=$user['moneda']?> $<?=number_format($user['valor'], 2); ?></td>
                <td align="right"><?php echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";echo "<img src=\"/scandinavia/assets/images/ico/" .$row_Obser['ico']. "\" alt=\"" . $row_Obser['name']. "\" width=\"20\" height=\"20\" />"; ?></td>                
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
            </table><br />
<br />

            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="21%">Observaciones:</td>
                <td width="39%"><textarea name="txtobservaciones" rows="5" class="form-control mb-2 mr-sm-2 mb-sm-0" id="txtobservaciones"><?=$cabeza[0]['observaciones']?>
                </textarea></td>
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
	$text1= "SCANDINAVIA PHARMA LTDA., consignará a nombre de " . $cabeza[0]['nombre']  . " el valor de <B>" . $arraymonedas . "</B>, correspondiente  al valor total a reintegrar a favor de " .  $cabeza[0]['nombre'] . " de la presente legalización de gastos, siempre que los gastos hayan sido previamente autorizados y los soportes de los mismos, cumplan los criterios legales vigentes establecidos y por mi conocidos. En caso que los soportes no cumplan los criterios legales, acepto el no reintegro de los valores que no cumplan con estos criterios.";
}
else{
	$text1= "Yo manifiesto que recibí de SCANDINAVIA PHARMA LTDA, Nit 800.133.807-1 la suma de Valor del Anticipo Recibido, denominada Valor del Anticipo Recibido. Declaro conocer las condiciones y términos de la Compañía relacionadas con la política de legalizaciones de Anticipos, entre ellas la de legalizar la utilización del anticipo en un plazo máximo de cinco (5) días, una vez finalizado el viaje o la comisión que ha originado el recibo del citado anticipo. Autorizo en forma expresa e irrevocable a SCANDINAVIA PHARMA LTDA  Nit 800.133.807-1 para que deduzca de las sumas que se hayan  causado o se causen en el futuro a mi favor por concepto de salarios, prestaciones sociales, vacaciones, bonificaciones de cualquier naturaleza,  eventuales indemnizaciones y cualquier acreencias laboral que  deba liquidar y pagar a mi favor bien sea durante la vigencia o a la terminación de mi contrato de trabajo, el valor de $" . number_format($saldocontrol, 0,".",",") . ", correspondiente al saldo a favor de la empresa, sobrante del presente anticipo que estoy legalizando, denominado saldo a reintegrar";
}

echo $text1;

?>            

            
            <p>&nbsp;</p>
            <p>&nbsp;</p>
             <?php if($cabeza[0]['estado'] == '1'){?>
            <table width="70%" border="0" class="table table-striped">
              <tr>
                <td align="right">&nbsp;</td>
                <td><h4>Observaciones </h4></td>
              </tr>
              <tr>
                <td width="23%" align="right"><h5>Estado:</h5></td>
                <td><label for="estadoscartera"></label>
                  <select  name="estadoscartera" id="estadoscartera" class="form-control form-control-lg" onchange="habilitartxt(this.value);">
                    <option value="APR">APROBADO</option>
                    <option value="REC">RECHAZADO</option>
                  </select></td>
              </tr>
              <tr>
                <td><input name="pasaguid" type="hidden" id="pasaguid" value="<?=$consultaguid?>" /></td>
                <td><textarea name="ObservacionP" cols="40" rows="3" id="ObservacionP" class="form-control form-control-lg" placeholder="Descripcion"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><?php //modificacion HBT febrero 2019 
				if ($filas2 > 0){ ?><input type="submit" name="Aprobar" id="Aprobar" value="Procesar" class="btn-primary" /><?php } ?>
                <input name="aplicacion" type="hidden" id="aplicacion" value="<?=$proceso?>" />
                <input name="paso" type="hidden" id="paso" value="<?=$pasoabuscar?>" />
                <input type="hidden" name="ultimopaso" id="ultimopaso"  value="<?=$ultimopaso99[0]?>"/></td>
              </tr>
            </table>
           <div align="center">
               <?php } else 
			   { 			   
			   if($cabeza[0]['estado'] == 'APR'){ ?> 
            </div>
            <h4 align="center">Documento Aprobado</h4> 
            <div align="center">
              <?php } 
			  
			  if($cabeza[0]['estado'] == 'REC'){ ?> 
            </div>
            <h4 align="center">Documento Rechazado <br> <?=$cabeza[0]['observacionP']?>  </h4> 
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


		
				
