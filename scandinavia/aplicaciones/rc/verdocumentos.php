<?php 

require_once("../../seguridad/config.php");
require_once('montoescrito.php'); 

$parametro = $_REQUEST['id'];

$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';



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
$conditionscabeza['where'] = array('DocumentID '=> $parametro,); 
$cabeza = $db->getRows('vw_recibostot',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('DocumentID'=> $parametro,); 
$detalle = $db->getRows('vw_recibosdetalle',$conditionsdetalle); //ojo se pone tabla a consultar

//detalle anticipo
$conditionsanticipo['where'] = array('DocOrig'=> $parametro,); 
$detanticipo = $db->getRows('rc_data_update',$conditionsanticipo); //ojo se pone tabla a consultar


//detalle soportes
$sql20= "select c.razonsocial,a.name as name, a.type as type, a.rc as rc, b.ico from uploadsrc a inner join rc_mime b on a.type = b.type inner join vw_recibos c on c.DocumentID = a.rc   where a.rc =   " . $parametro;
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
</style>


<script>
(function() {



})();
</script>

<style>
.luz.on{
  color: #FF0000;/*color del texto al cambiar*/
  text-shadow:
     1px  1px rgba(255, 255, 255, .1),
    -1px -1px rgba(0, 0, 0, .88),
     0px  0px 20px #FF0000;/*color de la luz del texto*/
}
.luz{
  font-size:18px;/*tamaño de la fuente*/
  color: #0099FF;
  text-shadow:
     1px  1px rgba(255, 255, 255, .1),
    -1px -1px rgba(0, 0, 0, .88);
}
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
	  <?php } ?>
	</p> <form action="apruebarc.php" method="get">
	<table width="100%" border="0">
	  <tr>
	    <td align="center">&nbsp;</td>
	    <td align="center"><h3>Recibo de Caja No: RC<?php echo $detalle[0]['DocumentID']; ?>
	      <input type="hidden" name="rcid" id="rcid" value="<?php echo $detalle[0]['DocumentID']; ?>" />
	      <input name="OP" type="hidden" id="OP" value="RC" />
	    </h3></td>
	    <td align="center" valign="top">&nbsp;</td>
	    </tr>
	  <tr>
	    <td width="26%" align="center"><img src="/scandinavia/assets/img/logobig.png" alt="" width="186" height="117" /></td>
	    <td width="50%" align="center"><?php echo $empresa[0]['resolucion']; ?></td>
	    <td width="24%" align="center" valign="top"><h5><img src="/scandinavia/assets/img/icontec.png" alt="" width="146" height="118" /></h5></td>
	    </tr>
	  </table>	
	<div >
	  <div class="panel panel-default users-content">
            <div class="panel-body"> <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"])) { ?> <a href="view/addEdit.php?op=<?php echo $_REQUEST['op']?>" class="glyphicon glyphicon-plus" ></a><?php }?>

              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="20%"><h5>Recibimos de:</h5></td>
                  <td width="20%"><h5><b><?php echo $cabeza[0]['razonsocial']; ?></b></h5></td>
                  <td width="4%">&nbsp;</td>
                  <td width="36%"><h5>Descuento Financiero:</h5></td>
                  <td width="20%"><h5><b><?php if($cabeza[0]['Descuento1']== "1")  echo "Si: " . $cabeza[0]['ValorDes1'] ; else  echo "No"; ?></b></h5></td>
                </tr>
                <tr>
                  <td width="20%"><h5>Fecha de Pago:</h5></td>
                  <td width="20%"><h5><b><?php echo $cabeza[0]['Fecha']; ?></b></h5></td>
                  <td width="4%">&nbsp;</td>
                  <td width="36%"><h5>Descuento Adicional por Negociación:</h5></td>
                  <td width="20%"><h5><b><?php if($cabeza[0]['Descuento2']== "1")  echo "Si: " . $cabeza[0]['ValorDes2']; else  echo "No"; ?></b></h5></td>
                </tr>
                <tr>
                  <td width="20%"><h5>Codigo Cartera:</h5></td>
                  <td width="20%"><h5><b><?php echo $cabeza[0]['Cliente']; ?></b></h5></td>
                  <td width="4%">&nbsp;</td>
                  <td width="36%"><h5>% Descuento Adicional:</h5></td>
                  <td width="20%"><h5><b><?php echo $cabeza[0]['ValorDes3']; ?></b></h5></td>
                </tr>
                <tr>
                  <td width="20%"><h5>Banco:</h5></td>
                  <td width="20%"><h5><b><?php echo $cabeza[0]['descripcion']; ?></b></h5></td>
                  <td width="4%">&nbsp;</td>
                  <td width="36%">&nbsp;</td>
                  <td width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3"><?php if($detanticipo[0]['Cliente'] <> "") {?>
                  <div align="center"><span class="luz" id="test"> Documento atado a un anticipo <?php }?>  </b></span></div></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div>
           
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th rowspan="2"></th>
                        <th rowspan="2" valign="bottom">Cliente</th>
                        
                        <th rowspan="2" valign="bottom"><div align="center">Documento</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Fecha</div></th>
                        <th rowspan="2" ><div align="right">Valor Antes <br />  IVA</div></th>
                        <th rowspan="2" ><div align="right">Valor + <br />
                      IVA</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Retencion<br />
                        Impositiva</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Descuento <br />
                        Pronto Pago</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Descuento <br />
                        Adicional</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Otros <br />
                        Descuentos</div></th>
                        <th colspan="2" align="center"><div align="center">Descuentos Cliente</div></th>                       
                        <th rowspan="2"><div align="center">Neto a Pagar</div></th>
                    </tr>
                    <tr>
                      <th><div align="center">No Nota</div></th>
                      <th><div align="center">Valor</div></th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <?php $sumaneto = 0; $sumaretimpo = 0; $sumdespago = 0; $sumdesadi=0; $sumotros =0; $sumvalnota= 0;
					if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
                    <tr>
                        <td><?php echo '#'.$count; ?> </td>
                        <td><?php echo $user['cod']; ?></td>
                        
                        <td><?php echo $user['Documento']; ?></td>
                        <td><?php echo $user['OpeFecha']; ?></td>
                        <td align="right">$<?=number_format($user['ValorDocumento'], 0,".",",") ?></td>
                        <td align="right">$
                        <?=number_format($user['ValorIva'], 0,".",",") ?></td>
                        <td align="right">$<?=number_format($user['RetImpositiva'], 0,".",",") ?></td>
                       
                        <td align="right">$<?=number_format($user['DesPPago'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['DesAdicional'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['OtrosDescuentos'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['NoNota'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['ValNota'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['ValNeto'], 0,".",",");?></td>
                        <?php $sumaneto = $sumaneto + $user['ValNeto'];
						      $sumaretimpo = $sumaretimpo + $user['RetImpositiva'];
							  $sumdespago  = $sumdespago  + $user['DesPPago'];
							  $sumdesadi   = $sumdesadi   + $user['DesAdicional'];
							  $sumotros    = $sumotros    + $user['OtrosDescuentos'];
							  $sumvalnota  = $sumvalnota  + $user['ValNota'];
						
						?>
                    </tr>
                   
                    <?php endforeach; else: ?>
                     
                    <tr><td colspan="7">No existen documentos para mostrar......</td></tr>
                    <?php endif; ?>
                    <tr>
                      <td height="67">&nbsp;</td>
                      <td colspan="9" align="left"  valign="top"><h6>VALOR NETO:<b><?php  echo strtoupper(num2letras($sumaneto));?></b></h6></td>
                      <td colspan="2" align="right"><h6>TOTAL PAGADO CLIENTE:</h6></td>
                      <td colspan="2" align="right"><h6><b>$<?=number_format($sumaneto, 0,".",",");?></b></h6></td>
                      
                    </tr>
                </tbody>
            </table>
            <p>&nbsp;</p>
            <?php if($detanticipo[0]['Cliente'] <> "") {?>
            <table width="50%" border="1" align="left" >
                <thead>
                    <tr>
                      <th colspan="5"><div align="center">Anticipo</div></th>
                    </tr>
                    <tr>
                        <th rowspan="2"></th>                        
                        <th rowspan="2" ><div align="center">Documento</div></th>
                        <th rowspan="2" ><div align="center">Fecha</div></th>
                        <th rowspan="2" ><div align="center">Valor</div></th>
                        <th rowspan="2" ><div align="center">Estado</div></th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php 
					if(!empty($detanticipo)): $count = 0; foreach($detanticipo as $useranticipo): $count++; ?>
                    <tr>
                        <td><?php echo '#'.$count; ?> </td>                        
                        <td><?php echo $useranticipo['Tipo'].$useranticipo['DocOrig']; ?></td>
                        <td><?php echo $useranticipo['OpeFecha']; ?></td>
                        <td align="right">$<?=number_format($useranticipo['Valor_original'], 0,".",",")?></td>
                        <td align="center"><?=$useranticipo['EstadoProceso'] ?></td>                        
                    </tr>                   
                    <?php endforeach; else: ?>
                     
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <?php endif; ?>

                </tbody>
            </table>
            <?php }?>
            <p>&nbsp;</p><br />

            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td colspan="2"><h5>Observaciones Vendedor:  <b><?php echo $cabeza[0]['Observaciones']; ?></b><h5></td>
              </tr>
            </table>
            <p>&nbsp;</p>
            <?php if($cabeza[0]['Aprobado'] == '0'){?>
            <table width="70%" border="0" class="table table-striped">
              <tr>
                <td align="right">&nbsp;</td>
                <td><h4>Observaciones de Cartera</h4></td>
              </tr>
              <tr>
                <td width="23%" align="right"><h5>Estado:</h5></td>
                <td><label for="estadoscartera"></label>
                  <select  name="estadoscartera" id="estadoscartera" class="form-control form-control-lg" onchange="habilitartxt(this.value);">
                    <option value="APR">APROBADO</option>
                    <option value="RECP">RECHAZO PARCIAL</option>  
                    <option value="REC">RECHAZADO</option>                   
                </select></td>
              </tr>
              <tr>
                <td align="right"><h5>Tipo de Rechazo:</h5></td>
                <td><select disabled name="TipRec" id="TipRec" class="form-control form-control-lg">
<option value="Banco">Banco</option>
<option value="Fecha">Fecha</option>
<option value="Descuentos">Descuentos</option>
<option value="Soportes">Soportes</option>
<option value="Rechazo Definitivo">Rechazo Definitivo</option>
                </select></td>
              </tr>
              <tr>
                <td><input name="pasaguid" type="hidden" id="pasaguid" value="<?=$consultaguid?>" /></td>
                <td><textarea name="Observacion" cols="40" rows="3" id="Observacion" class="form-control form-control-lg" placeholder="Descripcion"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Aprobar" id="Aprobar" value="Procesar" class="btn-primary" /></td>
              </tr>
            </table>
            <div align="center">
               <?php } else 
			             { 
						 if($cabeza[0]['Aprobado'] == 'APR'){ ?> 
            </div>
            <h4 align="center">Documento Aprobado</h4> 
            <div align="center">
                   <?php } 
				         else 
						    { ?> 
                               <h4 align="center">El Documento fue Rechazado por problemas de: "  <?php echo $cabeza[0]['Rechazo']; 
							}
					    } ?>" <?php if($cabeza[0]['Aprobado'] == 'RECP' && $cabeza[0]['Rechazo'] != 'Rechazo Definitivo'){ ?> desea modificarlo <a href="/scandinavia/aplicaciones/rc/moddocumentos.php?id=<?php echo $_REQUEST['id'] ?>&op=RC&rec=<?php echo $cabeza[0]['Rechazo']; ?>">aqui</a>? <?php }?></h4>
            </div>
            <p>&nbsp;</p>
            
	</form>           
        </div>
<p>&nbsp;</p>
<p><br />
  <?php if($rowcount>0){?>
</p>
<table width="80%" border="0" align="center">
  <tr>
    <div align="center"><h4>Soportes </h4></div>
    <td><table width="100%" >
      <tr>
        <?php
$Obser_endRow = 0;
$Obser_columns = 5; // number of columns
$Obser_hloopRow1 = 0; // first row flag
do {   
    if($Obser_endRow == 0  && $Obser_hloopRow1++ != 0) echo "<tr>";
   ?>
        <td><br />
          <table width="100%" border="0" cellpadding="15" cellspacing="15">
            <tr>
              <td align="center"><?php $valor = $row_Obser['name'];
				$longitud = strlen($valor);
				$part = $longitud - 4;
				$fitxa = substr($valor, 0, $part);
				
				echo "<a href=\"uploads/" . $row_Obser['name'] . " \"target=\"\_blank\">";
		        echo "<img src=\"/scandinavia/assets/images/ico/" .$row_Obser['ico']. "\" alt=\"" . $row_Obser['name']. "\" width=\"50\" height=\"50\" />"; ?>
                <br />
                Fichero: <?php echo strtolower($fitxa);?> <br />
                Cliente: <?php echo strtolower($row_Obser['razonsocial']);?> <br />
                </td>
            </tr>
          </table>
          <br />
          <br /></td>
        <?php  $Obser_endRow++;
if($Obser_endRow >= $Obser_columns) {
  ?>
      </tr>
      <?php
 $Obser_endRow = 0;
  }
} while ($row_Obser = mysqli_fetch_assoc($Obser));
if($Obser_endRow != 0) {
while ($Obser_endRow < $Obser_columns) {
    echo("<td>&nbsp;</td>");
    $Obser_endRow++;
}
echo("</tr>");
}?>
    </table></td>
  </tr>
</table>
<?php
 }
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
              </div>
</div>                  
                  
                  
                </section>
           
			

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

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
  </section>

<?php require_once('../../pie.php'); }?>

<script>
function habilitardescuento(value, n)
		{		
			if(value=="1")
			{ 
				for (i=1;i<=n;i++) {
					// habilitamos
					
					var a = document.getElementById("fechaactual").value;				
					var b = document.getElementById("fechavencimiento"+i).value;				
					//
						var temp1 = "";
						var temp2 = "";
						
						var str1 = a; 
						var str2 = b;
						
						var dt1  = str1.substring(0,2);
						var dt2  = str2.substring(0,2);
						
						var mon1 = str1.substring(3,5);
						var mon2 = str2.substring(3,5);
						
						var yr1  = str1.substring(6,10);  
						var yr2  = str2.substring(6,10); 
						
						temp1 = mon1 + "/" + dt1 + "/" + yr1;
						temp2 = mon2 + "/" + dt2 + "/" + yr2;
												
											
						var cfd = Date.parse(temp1);
						var ctd = Date.parse(temp2);
						
						var date1 = new Date(cfd); 
						var date2 = new Date(ctd);	
												
					//
					var tiempo = date1.getTime() - date2.getTime();
					var dias = Math.floor(tiempo / (1000 * 60 * 60 * 24));
					
					
					if(dias <=  document.getElementById("condiciondias").value)  //ojo con fecha
					{		
					    var resultado = 0;
						if(document.getElementById("tidoc"+i).value == "FV"){
							var resultado = (parseFloat(document.getElementById("valcalculo"+i).value) * (parseFloat(document.getElementById("descuento").value) ));													
   						    resultado = parseFloat(resultado).toFixed(2);
							document.getElementById("ppago"+i).value= resultado;//formatNumber.new(resultado, "$") ;
						}
						else{
							document.getElementById("ppago"+i).value= resultado;//formatNumber.new(0, "$") ;
						}	
						document.getElementById("ppago"+i).disabled=false;																					 					   										
					}
                } 
			}else 	{			
				for (i=1;i<=n;i++) {
				// deshabilitamos				   
				    document.getElementById("ppago"+i).value ="0";
					document.getElementById("ppago"+i).disabled=true;
					
				}
			}
		}
		
		
		
//Descuento adicional por negociacion

function habilitaradicional(value, n)
		{		
			if(value=="1")
			{ 			   
				for (i=1;i<=n;i++) {
					// habilitamos
					    var resultado = 0;
						if(document.getElementById("tidoc"+i).value == "FV"){
							var resultado = (parseFloat(document.getElementById("valcalculo"+i).value) * (parseFloat(document.getElementById("adicional").value)));													
   						    resultado = parseFloat(resultado).toFixed(2);
							document.getElementById("dadicional"+i).value= resultado;//formatNumber.new(resultado, "$") ;
						}
						else{
							//document.getElementById("dadicional"+i).value= resultado;//formatNumber.new(0, "$") ;
						}	
						document.getElementById("dadicional"+i).disabled=false;																					 					   										
			   } 
			}else 	{			
				for (i=1;i<=n;i++) {
				// deshabilitamos				   
				    document.getElementById("dadicional"+i).value ="0";
					document.getElementById("dadicional"+i).disabled=true;
					
				}
			}
		}	
		
		
//Descuento Adicional
function habilitaradi(value, n)
		{				
			if(value != "0")
			{ 
				for (i=1;i<=n;i++) {
					// habilitamos
					    var resultado = 0;
						if(document.getElementById("tidoc"+i).value == "FV"){
							var resultado = (parseFloat(document.getElementById("valcalculo"+i).value) * (parseFloat(document.getElementById("valoranticipo").value) ));													
   						    resultado = parseFloat(resultado / 100).toFixed(2);
							document.getElementById("dotros"+i).value= resultado;//formatNumber.new(resultado, "$") ;
						}
						else{
							//document.getElementById("dotros"+i).value= resultado;//formatNumber.new(0, "$") ;
						}	
						document.getElementById("dotros"+i).disabled=false;																					 					   										
			   } 
			}else 	{			
				for (i=1;i<=n;i++) {
				// deshabilitamos							
				    document.getElementById("dotros"+i).value ="0";
					document.getElementById("dotros"+i).disabled=true;
					
				}
			}
		}				
		
		
//calculos totales
		function calculolinea(value, n)
		{				
		      var valtotal = 0;
			  var valimpositiva = 0;
			  var valppago = 0;
			  var valadicional = 0;
			  var valotros = 0;
			  var valnot = 0;
			  var total = 0;
			  var totalyanticipo = 0;
				for (i=1;i<=n;i++) {															
					// habilitamos					
						var resultado = ((parseFloat(document.getElementById("valcalculo"+i).value)) - (parseFloat(document.getElementById("impositiva"+i).value)) - (parseFloat(document.getElementById("ppago"+i).value)) - (parseFloat(document.getElementById("dadicional"+i).value)) - (parseFloat(document.getElementById("dotros"+i).value)) - (parseFloat(document.getElementById("valnota"+i).value)));
						
						resultado = parseInt(resultado);
						document.getElementById("Neto"+i).value= formatNumber.new(resultado, "$");		
						valtotal = valtotal + parseFloat(document.getElementById("valcalculo"+i).value);
						valimpositiva = valimpositiva + parseFloat(document.getElementById("impositiva"+i).value);
						valotros = valotros + parseFloat(document.getElementById("dotros"+i).value);
						valppago = valppago +  parseFloat(document.getElementById("ppago"+i).value);
						
						valadicional = valadicional + parseFloat(document.getElementById("dadicional"+i).value);
						valnot = valnot +  parseFloat(document.getElementById("valnota"+i).value);
						total = total +  resultado;	
						
						/*if (valppago= ""){			
               				valppago =0;
					    }	*/							
					}		
					 valppago =  parseFloat(valppago).toFixed(2);
					 valimpositiva = parseFloat(valimpositiva).toFixed(2);
					 valotros = parseFloat(valotros).toFixed(2);
					 valadicional = parseFloat(valadicional).toFixed(2);
					 valnot = parseFloat(valnot).toFixed(2);
					    
					document.getElementById("txtvalor").value= formatNumber.new(valtotal, "$");						 
					document.getElementById("txtretimpo").value= formatNumber.new(valimpositiva, "$");						 
					document.getElementById("txtppago").value= formatNumber.new(valppago, "$");						 
					document.getElementById("txtdadi").value= formatNumber.new(valadicional, "$");		
					document.getElementById("txtotros").value= formatNumber.new(valotros, "$");						 
					document.getElementById("txtnc").value= formatNumber.new(valnot, "$");						 
					document.getElementById("txttot").value= formatNumber.new(total, "$");	
					document.getElementById("Enviar").disabled = false;			
					
					
					jAlert('Totales Actualizados', 'Mensaje de confirmacion');
					
					if((document.getElementById("valoranticipo").value) == ""){
								document.getElementById('valoranticipo').value = "0";
					}
					
					/*
					if((parseFloat(document.getElementById("valoranticipo").value)) != 0 )
					{
						totalyanticipo = total - (parseFloat(document.getElementById("valoranticipo").value));
						jAlert('Totales Actualizados <br/> Valor de Documento a Generar por Anticipo -->  ' + totalyanticipo , 'Mensaje de confirmacion');
						document.getElementById('valdocumentoanticipo').value = totalyanticipo; 
					}*/																						
		}		
		/**/		
		
		
var formatNumber = {
		 separador: ".", // separador para los miles
		 sepDecimal: ',', // separador para los decimales
		 formatear:function (num){
		  num +='';
		  var splitStr = num.split('.');
		  var splitLeft = splitStr[0];
		  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
		  var regx = /(\d+)(\d{3})/;
		  while (regx.test(splitLeft)) {
		  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
		  }
		  return this.simbol + splitLeft  +splitRight;
		 },
		 new:function(num, simbol){
		  this.simbol = simbol ||'';
		  return this.formatear(num);
		 }
		}	
		
		
function habilitartxt(value)
		{	
			document.getElementById("TipRec").disabled=true;	
			
			if(value == "REC")
			{ 
			  	document.getElementById("TipRec").disabled=false;	
				
				document.getElementById("TipRec").focus();																					 				   										
			}  
			if(value == "RECP")
			{ 
			  	document.getElementById("TipRec").disabled=false;	
				
				document.getElementById("TipRec").focus();																					 				   										
			}
		}		
							
							
</script>		

<script type='text/javascript'>
		$( document ).ready(function() {
			$('#datetimepicker1').datetimepicker();
		});
	</script>