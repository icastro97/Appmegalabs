<?php 

require_once("../../seguridad/config.php");
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

//get users from database
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar


$bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar

 $conditions['where'] = array('Documento'=> $sid,); 
$users = $db->getRows('vw_basec_vendedores',$conditions); //ojo se pone tabla a consultar


$conditions['where'] = array('estado'=> 1,); 
$doclegalizar = $db->getRows('rc_anticipos',$conditions); //ojo se pone tabla a consultar


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
<link rel="stylesheet" type="text/css" href="../../bower_components/dropzone/downloads/css/dropzone.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">	
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script type="text/javascript" src="../../bower_components/dropzone/downloads/dropzone.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>


    




<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
</style>





<script type="text/javascript">

 
function ShowSelected()
{
/* Para obtener el valor */
var cod = 0;
    cod = document.getElementById("legalizaanticipo").value;
 
/* Para obtener el texto */
var combo = document.getElementById("legalizaanticipo");
var selected = combo.options[combo.selectedIndex].text;
var subCadena = selected.substring(16, 40);
var primera = subCadena.split(' ')[1];
var res = primera.replace("$","");
    res = res.replace(",","");
	res = res.replace(",","");
	res = res.replace(",","");
	res = res.replace(",","");
	document.getElementById("vallegalizarok").value = res;
	alert(combo);
	document.getElementById("valseleccion").value = cod;  
	document.getElementById("valseleccion0").value = primera;
}
</script>

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
	</p> <form action="crearc.php" method="get">
	<table width="100%" border="0">
	  <tr>
	    <td align="center">&nbsp;</td>
	    <td align="center"><h3>Recibo de Caja</h3></td>
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
              <input name="descuento" type="hidden" id="descuento" value="0.05" /> <!--Se debe poner el % de descuento del cliente-->
              <input name="adicional" type="hidden" id="adicional" value="0.03" /> <!--Se debe poner el % de descuento adicional cliente-->
              <input type="hidden" name="condiciondias" id="condiciondias" value="1000">
              <input name="fechaactual" type="hidden" id="fechaactual" value="<?php echo date("d/m/Y");?>" /> 
              <input type="hidden" name="lineas" id="lineas" value="<?=count($users)?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="20%"><h5>Recibimos de:</h5></td>
                  <td width="20%"><h5><?php echo $users[0]['Cliente']; ?>
                    <input type="hidden" name="nombrecliente" id="nombrecliente" value="<?=$users[0]['Cliente']?>" />
                    <input type="hidden" name="ncodecliente" id="ncodecliente" value="<?=$users[0]['cod']?>" />
                    
                  </h5></td>
                  <td width="4%">&nbsp;</td>
                  <td width="24%"><h5>Descuento Financiero:</h5></td>
                  <td width="32%"><label>
                    <input type="radio" name="Dtofinanciero" value="1" id="Dtofinanciero0" onchange="habilitardescuento(this.value,<?=count($users)?> );" />
                    Si</label>
                    
                    <label>
                      <input type="radio" name="Dtofinanciero"  value="0" id="Dtofinanciero1" onchange="habilitardescuento(this.value,<?=count($users)?> );"  checked="checked"  />
                      No</label>
                    <label for="porcentaje"></label>                    </td>
                </tr>
                <tr>
                  <td width="20%"><h5>Fecha de Pago:</h5></td>
                  <td width="20%"><div class='input-group date' id='datetimepicker1'>
                         <input type='text' name="fecha" id="fecha" class="form-control" required min="" />
                         <span class="input-group-addon">
                         <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div>
                      
                    
                      </td>
                  <td width="4%">&nbsp;</td>
                  <td width="24%"><h5>Descuento Adicional por Negociación:</h5></td>
                  <td width="32%"><input type="radio" name="Negociacion" value="1" id="Negociacion0" onchange="habilitaradicional(this.value,<?=count($users)?> );" />
Si
  <input name="Negociacion" type="radio" id="Negociacion1" value="0" onchange="habilitaradicional(this.value,<?=count($users)?> );"  checked="checked"  />
No</td>
                </tr>
                <tr>
                  <td width="20%"><h5>Codigo Cartera:</h5></td>
                  <td width="20%"><h5><?php echo $users[0]['NIT']; ?>
                    <input type="hidden" name="clientecartera" id="clientecartera" value="<?php echo $users[0]['NIT']; ?>" />
                  </h5></td>
                  <td width="4%">&nbsp;</td>
                  <td width="24%"><h5>% Descuento Adicional:</h5></td>
                  <td width="32%"><input name="valoranticipo" type="text" id="valoranticipo" autocomplete="off" onkeyup="checkDecimals(this.form.valordescuentofinanciero, this.form.valoranticipo.value);" onchange="habilitaradi(this.value,<?=count($users)?> );" value="0" placeholder="Porcentaje Adicional" size="20" class="form-control mb-2 mr-sm-2 mb-sm-0"/></td>
                </tr>
                <tr>
                  <td width="20%"><h5>Banco:</h5></td>
                  <td width="20%"><select class="form-control form-control-lg" name="banco">
						<?php 
						foreach ($bancos as $row) {														    
							echo '<option value="'.$row['codigo'].'">'.$row['descripcion'].'</option>';								
                        }?>
	    			</select>  </td>
                  <td width="4%">&nbsp;</td>
                  <td width="24%"><h5>Tipo de Pago:</h5></td>
                  <td width="32%"><select class="form-control form-control-lg" name="TipoPago" onchange="habilitartxt(this.value);">
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Posfechado">Posfechado</option>
                    
                  </select></td>
                </tr>
                <tr>
                  <td><h5>Cheque No:</h5></td>
                  <td><input name="NoCheque" type="text" disabled="disabled" id="NoCheque" autocomplete="off" onchange="habilitaradi(this.value,<?=count($users)?> );" onkeyup="checkDecimals(this.form.valordescuentofinanciero, this.form.valoranticipo.value);" value="" size="20" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="No. Cheque"/></td>
                  <td>&nbsp;</td>
                  <td><h5>Valor:</h5></td>
                  <td><input name="ValorCheque" type="text" disabled="disabled" id="ValorCheque" autocomplete="off" onchange="habilitaradi(this.value,<?=count($users)?> );" onkeyup="checkDecimals(this.form.valordescuentofinanciero, this.form.valoranticipo.value);" value="" size="20" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Valor"/></td>
                </tr>
                <tr>
                  <td><h5>Fecha Cheque:</h5></td>
                  <td><div class='input-group date' id='datetimepicker2'>
                         <input name="fecha2" type='text' disabled="disabled" required class="form-control" id="fecha2" min="" />
                         <span class="input-group-addon">
                         <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                  </div></td>
                  <td>&nbsp;</td>
                  <td><h5>Anticipo:</h5></td>
                  <td><input type="radio" name="anticipo" id="anticipo" value="Si" onChange="habilitaranticipo(this.value);">
          <label for="anticipo"></label>
          Si 
          <input name="valoranticipon" type="text" disabled="disabled" id="valoranticipon" autocomplete="off" onKeyUp="checkDecimals(this.form.valordescuentofinanciero, this.form.valoranticipo.value);" value="0" size="10" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Valor"/>
          <input name="anticipo" type="radio" id="radio2" onChange="habilitaranticipo(this.value);" value="No" checked="checked">
        No  
         <input type="hidden" name="valdocumentoanticipo" id="valdocumentoanticipo"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><h5>Ingresos por Legalizar
                    <input name="vallegalizarok" type="hidden" id="vallegalizarok" value="0" />
                    <input name="valseleccion" type="hidden" id="valseleccion" value="0" />
                    <input name="valseleccion0" type="hidden" id="valseleccion0" value="0" />
                  </h5></td>
                  <td colspan="2"><select name="legalizaanticipo" id="legalizaanticipo" onchange="ShowSelected();" class="form-control form-control-lg">
                    
                    <?php 
						foreach ($doclegalizar as $rowlegalizar) {						  
							echo '<option value="'.$rowlegalizar['id'].'">'. $rowlegalizar['fechanticipo'].' - ' .$rowlegalizar['tipodoc'].$rowlegalizar['id']. '  $' .number_format($rowlegalizar['valor'],2). '</option>';
						  
						}   
																								
						?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div>
            
            <table cellpadding="0" cellspacing="0" class="table table-sm">  <!--class="table table-condensed"-->
                <thead>
                    <tr>
                        <th rowspan="2"></th>
                       
                        <th rowspan="2" valign="bottom"><div align="center">Documento</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Fecha</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Valor Antes <br />
                        IVA</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Valor + IVA</div></th>
                        <th rowspan="2" valign="bottom"><div align="right">Saldo</div></th>
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
                <tbody >
               
                    <?php if(!empty($users)): $count = 0; foreach($users as $user): $count++; ?>
                    <tr>
                        <td><?php echo '#'.$count; ?> </td>
                       
                        <td><?php echo $user['Documento']; ?><input type="hidden" name="tidoc[]" id="tidoc<?=$count;?>" value="<?=$user['Tipo']?>">
                        <input type="hidden" name="DocFinal[]" id="DocFinal<?=$count;?>" value="<?=$user['Documento']?>">
                        </td>
                        <td><?php echo $user['OpeFecha']; ?></td>
                        <td align="right">$<?=number_format($user['ValAntesIva'], 0,".",",") ?> <input type="hidden" name="valcalculo[]" id="valcalculo<?=$count;?>" value="<?=$user['Saldo']?>"></td>
                        <td width="10%" align="right">$ <?=number_format($user['Valor_original'], 0,".",",") ?>   </td>
                        <td align="right">$<?=number_format($user['Saldo'], 0,".",",") ?> </td>
                        <td><input name="impositiva[]" type="text"  class="form-control form-control-sm" id="impositiva<?=$count;?>" value="0" ></td>
                       
                        <td><input name="ppago[]" type="text"    class="form-control mb-2 mr-sm-2 mb-sm-0" id="ppago<?=$count;?>" onChange="habilitardescuento(this.value,1 );" value="0" >
                          <span class="panel-body">
                          <input name="fechavencimiento[]" type="hidden" id="fechavencimiento<?=$count?>" value="<?php echo $user['VtoFecha']; ?>" />
                        </span></td>
                        <td><input name="dadicional[]" type="text"   class="form-control mb-2 mr-sm-2 mb-sm-0" id="dadicional<?=$count;?>" onChange="habilitaradicional(this.value,1 );" value="0"></td>
                        <td><input name="dotros[]" type="text"  class="form-control mb-2 mr-sm-2 mb-sm-0" id="dotros<?=$count;?>" value="0" ></td>
                        <td><input name="notano[]" type="text"   class="form-control mb-2 mr-sm-2 mb-sm-0" id="notano<?=$count;?>" value="0" /></td>
                        <td><input name="valnota[]" type="text"   class="form-control mb-2 mr-sm-2 mb-sm-0" id="valnota<?=$count;?>" value="0" /></td>
                        <td width="12%"><input name="Neto[]" type="text"   class="form-control mb-2 mr-sm-2 mb-sm-0" id="Neto<?=$count;?>" onClick="calculolinea(this.value,<?=count($users)?> );" required="required"></td>
                    </tr>
                   
                    <?php endforeach; else: ?>
                     
                    <tr><td colspan="7">No existen documentos para mostrar......</td></tr>
                    <?php endif; ?>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="3"  valign="top"><h3>Totales:</h3></td>
                      <td>&nbsp;</td>
                      <td width="14%"><input type="hidden" name="valtotcalc" id="valtotcalc" />
                      <input name="txtvalor" type="text" id="txtvalor" class="form-control mb-2 mr-sm-2 mb-sm-0" readonly="readonly" /></td>
                      <td><input name="txtretimpo" type="text" id="txtretimpo" class="form-control mb-2 mr-sm-2 mb-sm-0" readonly="readonly" /></td>
                      <td><input name="txtppago" type="text" id="txtppago" class="form-control mb-2 mr-sm-2 mb-sm-0" readonly="readonly" /></td>
                      <td><input name="txtdadi" type="text" id="txtdadi" class="form-control mb-2 mr-sm-2 mb-sm-0" readonly="readonly" /></td>
                      <td><input name="txtotros" type="text" id="txtotros" class="form-control mb-2 mr-sm-2 mb-sm-0" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td ><input name="txtnc" type="text" id="txtnc" class="form-control mb-2 mr-sm-2 mb-sm-0" readonly="readonly" /></td>
                      <td><input name="txttot" type="text" id="txttot"  class="form-control mb-2 mr-sm-2 mb-sm-0" readonly="readonly" /></td>
                    </tr>
                  
                </tbody>
            </table>
            <p>&nbsp;</p>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td>Observaciones:</td>
                <td><input name="txtobservaciones" type="text" id="txtobservaciones" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Observaciones"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <p>&nbsp;</p>
            <p>
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>">
              <input name="envio" id="envio" type="submit" class="btn-primary"  value="Enviar" disabled="disabled">
               <input name="rctempo" type="hidden" id="rctempo" value="">
            </p>
            
            </form>  
            
            

	<form name="form1" method="post" action="">
	  <div class="panel panel-default users-content">
              <input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
              <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /> 
             

            <p>&nbsp;</p>
            <div id="dropzone" class="dropzone">
            
            </div>
           
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>">
           
            
            </form>           
        </div>
  
            
           
          
           
   
                     
        </div>
</div>
</div>                  
                  
                  
                </section>
                <p>&nbsp;</p>
          		</div>
          	</div>
			

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
function habilitaranticipo(value)
		{
			if(value=="Si")
			{
				// habilitamos
				document.getElementById("valoranticipon").disabled=false;			
				document.getElementById("valoranticipon").value ="";
				document.getElementById("valoranticipon").focus();
			}
			if(value=="No"){
				// deshabilitamos
				document.getElementById("valoranticipon").disabled=true;
				document.getElementById("valoranticipon").value="0";
			}
		}	


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
			  document.getElementById("envio").disable = true;
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
						document.getElementById("valtotcalc").value = valtotal;
						 
						
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
																						
					//jAlert('Totales Actualizados', 'Mensaje de confirmacion');					
										
					if((document.getElementById("valoranticipon").value) == "" || (document.getElementById("valoranticipon").value) == "0"){
								document.getElementById('valoranticipon').value = "0";
					}
															
					if((parseFloat(document.getElementById("valoranticipon").value)) != 0 )
					{
						totalyanticipo = total - (parseFloat(document.getElementById("valoranticipon").value));
						alert('Totales Actualizados \n Valor de Documento a Generar por Anticipo -->  ' + totalyanticipo);
						document.getElementById('valdocumentoanticipo').value = totalyanticipo; 
					}	
															
					//comprobacion de saldos si hay legalizacion	
					var bt = document.getElementById('envio');
					
					if(document.getElementById("vallegalizarok").value != '0'){
												
						if(parseFloat(document.getElementById("valtotcalc").value) ==parseFloat(document.getElementById("vallegalizarok").value)){											
						    bt.disabled = false;
						}else{							
							alert("El valor: " + document.getElementById("valseleccion0").value + " de la legalizacion no corresponde con el valor del RC " + document.getElementById("txttot").value);
							bt.disabled = true;
						}						
					}
					else{
						bt.disabled = false;					
					}
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
			document.getElementById("NoCheque").disabled=true;	
			document.getElementById("ValorCheque").disabled=true;
			document.getElementById("fecha2").disabled=true;		
			if(value == "Cheque" || value == "Posfechado")
			{ 
			  	document.getElementById("NoCheque").disabled=false;	
				document.getElementById("ValorCheque").disabled=false;
				document.getElementById("fecha2").disabled=false;
				document.getElementById("NoCheque").focus();																					 				   										
			} 
		}		
			
			
			
function checkDecimals(fieldName, fieldValue) 
	{
		decallowed = 2; // how many decimals are allowed?
		if (isNaN(fieldValue) || fieldValue == "") 
		{
			fieldName.select();
			fieldName.focus();
			fieldName.value = "0";
			return "";
		}
		else 
		{
			if (fieldValue.indexOf('.') == -1) fieldValue += ".";
			dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);
	
			if (dectext.length > decallowed)
			{
				alert ("El numero debe tener " + decallowed + " decimales.");
				fieldName.select();
				fieldName.focus();
				fieldName.value = "";
    			return "";
			}
			else {
				//alert ("Número validado satisfactoriamente.");
			}
	   }
	}			
			
							
</script>		

<script type='text/javascript'>
		$( document ).ready(function() {
			$('#datetimepicker1').datetimepicker({
				maxDate: moment(), 
               format: 'DD/MM/YYYY'
});
		});
		
		$( document ).ready(function() {
			$('#datetimepicker2').datetimepicker({		
			   maxDate: moment(),		
               format: 'DD/MM/YYYY'
});
		});
	</script>
    
 
    
<script type="text/javascript">
	
	 var guid = "";
	 var aleatoriocontrol = 0;
		function S4() {
			return (((1+Math.random())*0x10000)|0).toString(16).substring(1); 
		}
		 
		// then to call it, plus stitch in '4' in the third group
		guid = (S4() + S4() + "-" + S4() + "-4" + S4().substr(0,3) + "-" + S4() + "-" + S4() + S4() + S4()).toLowerCase();
	    aleatoriocontrol =  Math.round(Math.random()*1000);	
		document.getElementById("rctempo").value = aleatoriocontrol;
			
	
	$(document).ready(function()
	{
		Dropzone.autoDiscover = false;
		$("#dropzone").dropzone({
			url: "uploads.php?inf="+guid+"&rc="+aleatoriocontrol,
			addRemoveLinks: true,
			maxFileSize: 100000,
			dictResponseError: "Ha ocurrido un error en el server",
			acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF,.rar,application/pdf,.psd',
			complete: function(file)
			{
				if(file.status == "success")
				{
					alert("El siguiente archivo ha subido correctamente: " + file.name);
				}
			},
			error: function(file)
			{
				alert("Error subiendo el archivo " + file.name + " ,es muy grande o no es permitido este tipo de fichero" );
			},
			removedfile: function(file, serverFileName)
			{
				var name = file.name;
				$.ajax({
					type: "POST",
					url: "uploads.php?delete=true&rc="+aleatoriocontrol,
					data: "filename="+name,
					success: function(data)
					{
						var json = JSON.parse(data);
						if(json.res == true)
						{
							var element;
							(element = file.previewElement) != null ? 
							element.parentNode.removeChild(file.previewElement) : 
							false;
							alert("El fichero fué eliminado: " + name); 
						}
					}
				});
			}
		});
	});
	</script>    