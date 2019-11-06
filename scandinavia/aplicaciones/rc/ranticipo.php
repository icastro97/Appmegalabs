<?php 

require_once("../../seguridad/config.php");
$parametro = "";
$valnit = "";
$xx = "0";


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

$bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar

 $conditions['where'] = array('Documento'=> $sid,); 
$users = $db->getRows('vw_basec_vendedores',$conditions); //ojo se pone tabla a consultar

if (isset($_REQUEST['id'])) {
	$parametro = $_REQUEST['id'];
	echo "val " . $parametro;
     $xx = 1;
	  $conditionscli['where'] = array('NIT'=> $parametro,); 
$cli = $db->getRows('clientes',$conditionscli); //ojo se pone tabla a consultar
}

//get users from database
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar




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
<script type="text/javascript" src="../legalizaciones/assets/jquery.maskMoney.js"></script>

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
	  <?php } ?>
	</p> <form action="creaanticipo.php" method="get">
	<table width="100%" border="0">
	  <tr>
	    <td align="center">&nbsp;</td>
	    <td align="center"><h3>Recibo de Caja - Anticipo</h3></td>
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
              <input name="fechaactual" type="hidden" id="fechaactual" value="<?php echo date("d/m/Y");?>" /> 
              <input type="hidden" name="lineas" id="lineas" value="<?=count($users)?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="20%"><h5>Recibimos de:</h5></td>
                  <td width="20%"><h5><?php $vsalcli = "";
				                             if($xx=="0"){ 					                                
												$valnit = $empresa[0]['nit']; 
												echo $empresa[0]['razonsocial']; 
												$vsalcli = $empresa[0]['razonsocial'];
											} else { 
											   $valnit = $cli[0]['NIT']; 
											   echo $cli[0]['razonsocial']; 
											   $vsalcli = $cli[0]['razonsocial'];
											}?>
                    <input type="hidden" name="nit" id="nit" value="<?php echo $valnit; ?>" />
                    <input type="hidden" name="clie" id="clie" value="<?php echo $vsalcli; ?>" />
                  </h5></td>
                  <td width="4%">&nbsp;</td>
                  <td width="12%"><h5>Valor Documento:</h5></td>
                  <td width="44%"><div class="input-group">
             <span class="input-group-addon">$</span>                                                                    
              <input id="ValorAnticipo" name="ValorAnticipo" class="form-control currency" required="required" type="text"/>
			<script type="text/javascript">$("#ValorAnticipo").maskMoney();</script>
                                            
		          </div>  </td>
                </tr>
                <tr>
                  <td width="20%"><h5>Fecha de Pago:</h5></td>
                  <td width="20%"><div class='input-group date' id='datetimepicker1'>
                         <input type='text' name="fecha" id="fecha" class="form-control" required min="" />
                         <span class="input-group-addon">
                         <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div></td>
                  <td width="4%">&nbsp;</td>
                  <td width="12%"><h5>Codigo:</h5></td>
                  <td width="44%"><?php echo $valnit; ?>
                  <input type="hidden" name="clientecartera" id="clientecartera" value="<?php echo $valnit; ?>" /></td>
                </tr>
              </table>
            </div>
            <p>&nbsp;</p>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="20%">Observaciones:</td>
                <td width="80%"><textarea name="txtobservaciones" rows="6" class="form-control mb-2 mr-sm-2 mb-sm-0" id="txtobservaciones" placeholder="Observaciones"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <p>&nbsp;</p>
            <p>
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>">
              <input name="" type="submit" class="btn-primary" value="Enviar">
            </p>
            
            </form>           
        </div>
</div>
</div>                  
                  
                  
                </section>
               
          
			

		</section>
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
					
					
					if((parseFloat(document.getElementById("valoranticipo").value)) != 0 )
					{
						totalyanticipo = total - (parseFloat(document.getElementById("valoranticipo").value));
						jAlert('Totales Actualizados <br/> Valor de Documento a Generar por Anticipo -->  ' + totalyanticipo , 'Mensaje de confirmacion');
						document.getElementById('valdocumentoanticipo').value = totalyanticipo; 
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
			$('#datetimepicker1').datetimepicker();
		});
		
		$( document ).ready(function() {
			$('#datetimepicker2').datetimepicker();
		});
	</script>