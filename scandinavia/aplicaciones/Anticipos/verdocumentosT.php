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
$cedulaAnticipo = $_REQUEST['cedula'];
$cedulaLogueada = $_SESSION['identificacion'];
$sesionLogueada = $_SESSION["user_id"];


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
$conditionscabeza['where'] = array('consecutivo'=> $parametro,); 
$cabeza = $db->getRows('anticipo',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('consecutivo'=> $cabeza[0]['consecutivo'],); 
$detalle = $db->getRows('anticipo',$conditionsdetalle); //ojo se pone tabla a consultar

//totales por moneda
$conditionstotales['where'] = array('consecutivo'=> $cabeza[0]['consecutivo'],); 
$totalesdetalle = $db->getRows('vw_totanticipos',$conditionstotales); //ojo se pone tabla a consultar



//detalle soportes
$sql20= "SELECT
`type`,
`ico`,
identificacion,
consecutivo,
`tipoArchivo`,
`pdf`
FROM
anticipo T1
INNER JOIN rc_mime T2 ON
T1.id_anticipo = " . $parametro;
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
    

<a href="http://appscandinavia.com/scandinavia/aplicaciones/Anticipos/listadoTesoreria.php?op=Listado%20Anticipos" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
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
      <td colspan="2" align="center"><h3>Solicitud de Anticipos</h3></td>
	    
	  </tr>
    </table>
    <div class="panel-body">
  <div class="panel panel-default users-content">
    <div class="panel" style="border:1px solid #00AB84;">
    <div class="panel-heading text-center form-control" >Informaci&oacute;n General</div>
	<table width="100%" border="0"> 
  
	  <tr>	    
	    <td class="formato" colspan="5" align="center"><strong>Tipo:</strong> <?php echo $cabeza[0]['tipo']; ?></td><td >&nbsp;</td> <td class="formato" colspan="5" align="left"><strong>Identificaci&oacute;n: </strong><?php echo $cabeza[0]['identificacion']; ?></td> 
      <td class="formato" colspan="6" align="center"><strong>Anticipo:</strong> <?php echo $cabeza[0]['consecutivo']; ?></td>
     
	  <tr>	 
	    
	  </tr>
	 <tr>
     <td class="formato" colspan="5"></td><td class="formato" colspan="5"></td>
   </tr>
   <tr>
     <td class="formato" colspan="5" align="center"><strong>Fecha:</strong> <?php echo $cabeza[0]['fechaActual']; ?></td><td >&nbsp;</td><td class="formato" colspan="5" align="left"><strong>Nombre: </strong><?php echo $cabeza[0]['nombre']; ?></td>
   </tr>
   <tr>
   <td width="20%" class="formato" colspan="5"></td><td >&nbsp;</td>   <td class="formato" colspan="5"></td>
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
                <th rowspan="3" valign="bottom"><div align="center">Tipo</div></th>
                <th rowspan="3" align="center" ><div align="center">Identificaci&oacute;n</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Nombre </div></th>                
                <th rowspan="3" valign="bottom"><div align="center">Valor</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Adjunto</div></th>
                
              </tr>
              <tr></tr>
            </thead>
            <tbody id="userData2">
              
              <?php $sumaneto = 0;
					if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
              <tr>
              <td>&nbsp;</td>
               
                <td align="center"><?php echo $user['fechaActual']; ?></td> 
                <td align="center">
                  <?=($user['tipo']) ?></td>
                <td align="center">
                  <?=($user['identificacion']) ?></td>                
                <td align="center">
                  <?=$user['nombre']; ?></td>
                           
                               
                <td align="center"><?=$user['moneda']?> $<?=number_format($user['monto'], 2); ?></td>
                
         
                <?php    
                if($user['tipo'] == "Proveedor")
                {
                  if($user['archivo'] != "img_" )
                  {
                       ?>
                    
                        <td align="center"><?php 
                if($user['tipoArchivo'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                {
                  echo "<a href=\"uploads/" . $user['archivo'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_word.png' width='20' height='20' />"; 
                }
                else if($user['tipoArchivo'] == "image/png")
                {
                  echo "<a href=\"uploads/" . $user['archivo'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_png.png' width='20' height='20' />"; 
                  
                }  
                else if ($user['tipoArchivo'] == "application/pdf")
                {
                  echo "<a href=\"uploads/" . $user['archivo'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_pdf.png' width='20' height='20' />";                   
                }
                else if($user['tipoArchivo'] == "image/jpg" or $user['tipoArchivo'] == "image/jpeg")
                {
                  echo "<a href=\"uploads/" . $user['archivo'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_jpg.png' width='20' height='20' />"; 
                }
                else if($user['tipoArchivo'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
                {
                  echo "<a href=\"uploads/" . $user['archivo'] . " \"target=\"\_blank\">";
                  echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' />"; 
                }
                ?></td>
                        </td>                                       
                   <?php
                  }
                  else
                   {
                        ?>
                    <td align="center">No hay archivo</td>                                       
                   <?php
                        
                   
                   }
                }
                else 
                {
                  if($user['archivo'] != null)
                  {?>
                  <td align="center"><?php echo "<a href=\"" . $user['archivo'] . " \"target=\"\_blank\">";echo "<img src=\"/scandinavia/assets/images/ico/ico_pdf.png\" alt=\"" . $row_Obser['archivo']. "\" width=\"30\" height=\"30\" />"; ?></td>                                       
                  <?php  
                  }
                  else
                  {?>
                    <td align="center">No hay archivo</td>                                       
                   <?php 
                  }
                }
                ?>
                   <?php $sumaneto = $sumaneto + $user['monto'];?>
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
              <div class="row">
                     <div class="col-md-1">
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ex2" aling="center">Descripci&oacute;n:</label>
                            <textarea id="des" name="txtobservaciones" rows=4 class="form-control " id="txtobservaciones" readonly><?=$cabeza[0]['descripcion']?> </textarea>
                        </div>
                    </div>    
                   
                
                
                    
                  <div class="col-md-4">
                      
                        <div class="form-group">
                           
                            <h2 aling="center">Total</h2>
                            <hr align="left" noshade="noshade" size="2" width="45%" />
                                 <?php $sumavalores = 0; $arraymonedas = "";
                    					if(!empty($totalesdetalle)): $countyer = 0; foreach($totalesdetalle as $usertotdetalle): $countyer++; ?>
                                     
                                  <div class="col-md-3">
                                      <div align="left"><strong>Moneda:</strong> <?php echo $usertotdetalle['moneda']; ?></div>
                                    <div align="left"><strong>Valor:</strong> $<?=number_format(($usertotdetalle['sum(monto)']), 2)?></div>
                                    
                                  </div>
                                  <?php 
                    			  $arraymonedas = $arraymonedas . ", " . $usertotdetalle['moneda'] . "$" . number_format(($usertotdetalle['sum(monto)']), 2);
                    			  endforeach; else: ?>
                                  <div class="col-md-3">
                                    <td colspan="5">No existen valores para mostrar......</td>
                                  </div>
                                    <?php endif; ?>
                                </tbody>
                                <tbody>
                                </tbody>
                             </div>   
                       </div>
                    </div>
                </div>    
               </div> 
                </td>
              

            </table>
            
            
            <br />
            <br />
            <?php
            
            $fecha = $user['fechaActual'];
            
if($cabeza[0]['tipo'] == "Empleado")
{
	$text1= "<div style='text-align:justify;'><h5> El TRABAJADOR reconoce que el dinero entregado por concepto de anticipo debe ser destinado al objeto señalado en esta solicitud. Por consiguiente, se obliga a legalizarlo con
soportes y facturas originales dentro de los 5 días hábiles siguientes a $fecha, toda vez que se entiende esta como la fecha de finalización del evento para el cual se ha
otorgado el anticipo.</h5>
<h5>Así mismo, el TRABAJADOR se compromete a seguir con los procedimientos y políticas establecidas por EL EMPLEADOR para la legalización del anticipo. <br> <br>
De igual manera y en el evento en que el anticipo no sea utilizado dentro de los 5 días siguientes a su recibo, el TRABAJADOR se compromete a devolverlo dentro del término y
siguiendo el procedimiento establecido en el párrafo anterior. <br> <br>
El TRABAJADOR acepta que el dinero entregado para concepto de anticipo se encuentra bajo su responsabilidad directa, personal y exclusiva. Por ende, en caso de no realizar la
legalización o realizar la misma de manera parcial dentro del plazo establecido en los términos indicados por la Compañía o darle un uso indebido al mismo, el TRABAJADOR
autoriza expresa e irrevocablemente para que el valor del anticipo pendiente por legalizar sea descontado de sus salarios, prestaciones sociales, vacaciones, indemnizaciones,
bonificaciones o cualquier otra acreencia laboral que tuviere a su favor. <br> <br>
En el evento en que por cualquier motivo se termine el contrato de trabajo y no se haya legalizado la totalidad del anticipo, el TRABAJADOR autoriza también en forma expresa e
irrevocable para que el EMPLEADOR, del valor final de salarios, prestaciones sociales, vacaciones, indemnizaciones, bonificaciones o cualquier otra acreencia que tuviere a su favor
se descuente el valor del anticipo pendiente por legalizar.
En el evento que la liquidación final de prestaciones sociales sea insuficiente para cubrir el valor del anticipo, el TRABAJADOR se compromete a pagar directamente a el EMPLEADOR
cualquier saldo a su cargo para lo cual se realizará un acuerdo de pago entre las Partes. Para efecto de soportar dicha obligación, el TRABAJADOR firmará un pagaré en blanco el
cual hará parte integral de este Acuerdo.</h5>
</div>";

}
else{
	$text1= "<div style='text-align:center;'><h4> </h4></div>";
}

echo $text1;

?>    



          
            <p>&nbsp;</p>
            <p>&nbsp;</p>
             <?php 
             $userids = $detalle[0]['userid'];
             
             if($cabeza[0]['estado'] == '1'){?> 
              <?php //modificacion HBT febrero 2019 
				if ($cedulaAnticipo != $cedulaLogueada && $sesionLogueada != $userids){ ?><table width="70%" border="0" class="table table-striped">
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
                <td><input type="submit" name="Aprobar" id="Aprobar" value="Procesar" class="btn" style="background-color:#00AB84; color:white;" /></td>
                <?php } ?>
              </tr>
            </table>
           <div align="center">
               <?php } else 
        	    { 
        	        
        	        
        	        
        			   if($cabeza[0]['estado'] == 'APR'){ ?> 
                    </div>
                    <h4 align="center">Documento Aprobado<br> <?=$cabeza[0]['observacionP'];?></h4> 
                    <div align="center">
                      
                      <?php } 
                      
        			  if($cabeza[0]['estado'] == 'RECC'){ ?> 
                    </div>
                    <h4 align="center">DOCUMENTO RECHAZADO POR CONTABILIDAD <br> <?=$cabeza[0]['observacionconta'];?>  </h4> 
                    <div align="center">
                      <?php }
        			  
        			  if($cabeza[0]['estado'] == 'REC'){ ?> 
                    </div>
                    <h4 align="center">Documento Rechazado <br> <?=$cabeza[0]['observacionP'];?>  </h4> 
                    <div align="center">
                      <?php }  
        			   
        			  
        			  if($cabeza[0]['estado'] == 'APRC'){ ?> 
                    </div>
                    <h4 align="center">DOCUMENTO APROBADO POR CONTABILIDAD <br> <?=$cabeza[0]['observacionconta'];?>  </h4> 
                    <div align="center">
                      <?php }  
			  
			  }
			  ?>
			  
			  
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
</div></div>         
                  
              
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


<?php  }?>

		
				
