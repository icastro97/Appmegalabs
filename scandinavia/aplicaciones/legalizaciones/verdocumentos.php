<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

//start session
session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
$parametro = $_REQUEST['id'];
$cedulaLegalizacion = $_REQUEST['cedula'];
$cedulaLogueada = $_SESSION['identificacion'];
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




//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

require_once('../../cabeza.php'); 


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
table tr th, table tr td{font-size: 1.2rem; }
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
.formato{font-size:96%;}
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
    
   <a href="https://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/listadoLegalizacionesAprobador/index.php?op=Listado" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         <br> 
                  
<div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<p>
	  <?php }  ?>
	</p> 
  <form action="apruebalg.php" method="get">
  <table width="80%" border="0">
  <tr>	    
	    <td colspan="2" align="center" valign="top"><img src="/scandinavia/assets/img/logobig.png" alt="" width="186" height="117"  /></td>
      <td colspan="2" align="center"><h3>Legalización de Gastos</h3></td>
	    
	  </tr>
    </table>
    <div class="panel-body">
  <div class="panel panel-default users-content">
    <div class="panel" style="border: 1px solid #00AB84;">
    <div class="panel-heading text-center form-control" >Información General</div>
	<table width="100%" border="0"> 
  
	  <tr>	    
	    <td class="formato" colspan="5" align="left"><strong>Tipo de Legalización:</strong> <?php echo $cabeza[0]['tipolegalizacion']; ?></td><td >&nbsp;</td> <td class="formato" colspan="5"><strong>Linea: </strong><?php echo $cabeza[0]['linea']; ?></td> 
      <td class="formato" colspan="6" ></td>
     <td class="formato" colspan="6" ><strong>Legalización: </strong><?php echo $cabeza[0]['id_cabeza']; ?></td>
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
                <th rowspan="3" valign="bottom"><div align="center">Asistentes</div></th></th>
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
                  <?=$user['descripcion']; ?></td>
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
                 else if($user['tipo'] == "application/vnd.ms-excel")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' />"; 
                }
                 else if($user['tipo'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
                {
                  echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_powerpoint.png' width='20' height='20' />"; 
                }
                ?></td>    
                <?php
                
                $usuario = $user['identificador'];
                
                
                ?>
                <td align="center">
                    <?php
                    
                    
                    if($user['tipoCodigo'] == "SI")
                    {
                        ?>
                        <a href='#' class='btn btn-sm tabla' data-toggle='modal' data-id='<?=$usuario?>' data-target='#largeModal1' style='background-color:#00AB84; justify-content:center;' ><i class='glyphicon glyphicon-search icono' style='color:white;'></i></a> 
                        <?php
                        
                    }
                    else
                    {
                        echo "No son necesarios los asistentes.";
                    }
                    
                    
                    ?>
                        
                    </td>
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
                <td width="39%"name="txtobservaciones" class="formato" id="txtobservaciones"><?=$cabeza[0]['observaciones']?>
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
            <input type="hidden" id="lgcabeza" value="<?php echo $cabeza[0]['id_cabeza']; ?>" >
             <?php if($cabeza[0]['estado'] == '1'){?> 
              
            <?php //modificacion HBT febrero 2019 
				if ($cedulaLegalizacion != $cedulaLogueada){ ?><table width="70%" border="0" class="table table-striped">
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
                <input type="hidden" name="usuariolg" value="<?= $cabeza[0]['identificacion']?>">
                <td><input type="submit" name="Aprobar" id="Aprobar" value="Procesar" class="btn btn-success" /><?php } ?>
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
			  
			  if($cabeza[0]['estado'] == 'REC'){ 
			  
			  
			  ?> 
            </div>
            <h4 align="center">Documento Rechazado <br> <?=$cabeza[0]['observacionP']?>  </h4> 
            <div align="center">
              <?php }  
			  
			  if($cabeza[0]['estado'] == 'RECC'){ ?> 
          </div>
          <h4 align="center">Documento Rechazado por contabilidad <br> <?=$cabeza[0]['observacionP']?>  </h4> 
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
<?php

    if($cabeza[0]['estado'] == 'REC' || $cabeza[0]['estado'] == 'RECC'  && $cedulaLegalizacion == $cedulaLogueada )
    {
      if($cabeza[0]['boton'] == "1")
      {
          
      ?>
            
            <div align="center">
            <form action="recrearlg.php" method="post">
            <input type="hidden" name="id" value="<?php echo $parametro?>">
            <input type="submit" value="Recrear LG" class="btn" style="background-color:#00AB84; color:white;" >
            </form>
            </div>
<?php
      }
    }
  
?>

</div>                  
</div></div>         


<div class="modal fade" id="largeModal1" tabindex="-1" role="dialog" aria-labelledby="largeModal1" aria-hidden="true">
										<div class="modal-dialog modal-lg">
									
											<div class="modal-content">
												<div class="modal-header">
												<h4>Asistentes ingresados</h4>
													<button type="button" class="close" data-dismiss="modal" ></button>
													
												</div>
												<div class="modal-body1 ">

													<div class="row">
															<div class="col-md-4"></div>	
															
															
													</div>
													
												
												</div>
												<table class="table" width="150%">
															
															<thead>
															<div class="row">
															<div class="col-sm-1"></div>	
															<div class="col-sm-1"><h5><strong>Id</strong></h5></div>	
															<div class="col-sm-1"><h5><strong>Tipo</strong></h5></div>
															<div class="col-sm-1"><h5><strong>Cantidad</strong></h5></div>
															<div class="col-sm-2"><h5><strong>Nombre Asistente</strong></h5></div>
															<div class="col-sm-2"><h5><strong>Cedula Asistente</strong></h5></div>
															<div class="col-sm-2"><h5><strong>Consentimiento Trans. Valor</strong></h5></div>
															
															</div>
															</thead>
														
															
															<tbody id="columna" >
																
															</tbody>
															<input type="hidden" id="ide" value="">
													</table>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
													
												</div>
											</div>
										</div>
									</div>
                      
        </div>
</div>
        

 <script> 
 $(".monohp").click(function(){
	let id = $(this).data('id');
	$(".modal-body #idhp").val(id);
})

$(".tabla").click(function(){
	let ide = $(this).data('id');	
	$(".modal-body1 #ide").val(ide);
	let lgcabeza = $('#lgcabeza').val();
	$.ajax({
		 type: 'POST',
		 url: 'traerAsistentes.php',
		 data:{ide, lgcabeza},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<div class="row">
					<div class='col-sm-1'></div>
					<div class='col-sm-1'><h5>${dato.id_asistencia}</h5></div>					
					<div class='col-sm-1'><h5>${dato.tipo}</h5></div>	
					<div class='col-sm-1'><h5>${dato.cantidad}</h5></div>	
					<div class='col-sm-2'><h5>${dato.nombreAsistente}</h5></div>
					<div class='col-sm-2'><h5>${dato.cedulaAsistente}</h5></div>
					<div class='col-sm-2'><h5>${dato.transferenciaValor}</h5></div>
					
					</div>`;
 				});
				
				$('#columna').html(template);
				
			}
	});



})

 </script>
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

<?php } ?>


		
				
