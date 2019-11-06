<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$status = FALSE;


require_once("../../seguridad/arraypermiso.php");
unset($_SESSION['uId']);

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




//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>


<?php  require_once('../../cabeza.php'); 


if(!isset($_SESSION["session_username"])) {	
  header("location:../../logininicial.php");
} 
else {?>
<!---->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script type="text/javascript" src="assets/popcalendar.js"></script>
<script type="text/javascript" src="assets/ajax.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
    



  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />


<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">


<!--AJAX-->
        <script>
            $(document).ready(function() {
                <!--#my-form grabs the form id-->
                $("#my-form").submit(function(e) {
                    e.preventDefault();
					 
                    $.ajax( {
                        <!--insert.php calls the PHP file-->
                        url: "guardarajax.php",
                        method: "post",
                        //data: $("form").serialize(),
					    data: new FormData( this ),
					    processData: false,
					    contentType: false,
                        dataType: "text",
                        success: function(strMessage) {
                            $("#message").text(strMessage);
							 //alert(strMessage);//this will alert you the last_id
							document.getElementById("ultimoinserted").value= strMessage; 
							 
							document.getElementById("dateArrival1").value = "";
							document.getElementById("factura1").value = "";
							document.getElementById("nit1").value =  "";
							document.getElementById("establecimiento1").value  = "";
							document.getElementById("ciudad1").value =  "";
							document.getElementById("cinversion1").value =  "";
							document.getElementById("TipoGasto1").value = "";
							document.getElementById("concepto1").value = "";
							document.getElementById("descripcion1").value = "";
							document.getElementById("Moneda1").value = "";
							document.getElementById("valor1").value = "";
							document.getElementById("file1").value = ""; 
							document.getElementById("dateArrival1").focus();
							document.getElementById("TipoLegalizacion").disabled=true;
							
							 $("#resultado").load('ajax-grid-lgi.php',{'varidentificadounico': strMessage});

                        }
                    });
                });
            });
        </script>

<script type="text/javascript">



function valida(j) {
            $("#nit"+j).autocomplete({
                source: "buscarproveedor.php",
                minLength: 2,
                select: function(event, ui) {
					event.preventDefault();
					
					$('#nit'+j).val(ui.item.Nombres);
					$('#establecimiento'+j).val(ui.item.idx);
					$("#ciudad"+j).focus();
			     }
            });
		};

	
function ciudad(j) {
            $("#ciudad"+j).autocomplete({
                source: "buscar.php",
                minLength: 1,
                select: function(event, ui) {
					event.preventDefault();					
					$('#ciudad'+j).val(ui.item.Nombres);
					$("#cinversion"+j).focus();
			     }
            });
		};	
		
	
	
function empleado(j) {
            $("#identificacion").autocomplete({
                source: "buscarempleado.php",
                minLength: 2,
                select: function(event, ui) {
					event.preventDefault();
					
					$('#identificacion').val(ui.item.Identificacion);
					$('#nombre').val(ui.item.Nombre);
					$('#namel').val(ui.item.Nombre);
					$('#cargo').val(ui.item.Cargo);
					$('#Linea').val(ui.item.Linea);
					$('#Area').val(ui.item.Areaterapeutica);
					$('#ctocto').val(ui.item.CentroCosto);   
					$("#txtobservaciones").focus();
			     }
            });
		};	
</script>






<script type='text/javascript'>
$(function(){   

$.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);

	$('#dateArrival1').datepicker({
		dateFormat : 'dd/mm/yy',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d' 
});
});
		
				
						
</script>


<script type="text/javascript">



var i = 0;



function operaciones(valor1) {	//valor5 --> costokg , campo -->valor de peso, valor4 costo en pesos

         var totalseccion1 = 0;	 
		 
			var text = 0;
			for (cic = 1; cic <= i; cic++) { 			
    			text = (parseFloat(text)) +  (parseFloat(document.getElementById('valor'+cic).value));
			}
			document.getElementById('txttot').value = (parseFloat(document.getElementById('ValorAnticipo').value))  - parseFloat(text).toFixed(2);	
			if (document.getElementById('ValorAnticipo').value ==0)
		    {
			   document.getElementById('txttot').value =  parseFloat(text).toFixed(2);	
		    }		
			
			document.getElementById('textocnfo').value = "";
			if(document.getElementById('txttot').value != 0)			
			{
				if(document.getElementById("TipoLegalizacion").value == "Legalización Anticipo")
				{
				 var texto1 = "Yo manifiesto que recibí de SCANDINAVIA PHARMA LTDA, Nit 800.133.807-1 la suma de Valor del Anticipo Recibido, denominada Valor del Anticipo Recibido. Declaro conocer las condiciones y términos de la Compañía relacionadas con la política de legalizaciones de Anticipos, entre ellas la de legalizar la utilización del anticipo en un plazo máximo de cinco (5) días, una vez finalizado el viaje o la comisión que ha originado el recibo del citado anticipo. Autorizo en forma expresa e irrevocable a SCANDINAVIA PHARMA LTDA  Nit 800.133.807-1 para que deduzca de las sumas que se hayan  causado o se causen en el futuro a mi favor por concepto de salarios, prestaciones sociales, vacaciones, bonificaciones de cualquier naturaleza,  eventuales indemnizaciones y cualquier acreencias laboral que  deba liquidar y pagar a mi favor bien sea durante la vigencia o a la terminación de mi contrato de trabajo, el valor de $" + parseFloat(text).toFixed(2)  + ", correspondiente al saldo a favor de la empresa, sobrante del presente anticipo que estoy legalizando, denominado saldo a reintegrar";
				}
				if(document.getElementById("TipoLegalizacion").value == "Reintegro Gastos")				
				{					
					var texto1 = "SCANDINAVIA PHARMA LTDA., consignará a nombre de " + document.getElementById('nombre').value  + " el valor de $" + parseFloat(text).toFixed(2) + ", correspondiente  al valor total a reintegrar a favor de " +  document.getElementById('nombre').value   + " de la presente legalización de gastos, siempre que los gastos hayan sido previamente autorizados y los soportes de los mismos, cumplan los criterios legales vigentes establecidos y por mi conocidos. En caso que los soportes no cumplan los criterios legales, acepto el no reintegro de los valores que no cumplan con estos criterios.";								
				}
				document.getElementById('textocnfo').value =  texto1;
			}
		}


function habilitartxt(value)
		{	
		  
		
		
			document.getElementById("ValorAnticipo").disabled=true;		
			if(value == "Legalización Anticipo")
			{ 
			  	document.getElementById("ValorAnticipo").disabled=false;	
				document.getElementById("ValorAnticipo").focus();																					 				   										
			}
			else
			{
				document.getElementById("ValorAnticipo").value=0;	
				document.getElementById("ValorAnticipo").disabled=true;	
			}
		}		
			

var ii=0;

function seleccionaselect(campo, k)
{	

	var myobject = {
		'Taxis': 'Taxis',
		'Capacitacion': 'Capacitación',
		'Casino y Restaurante': 'Casino y Restaurante',
		'Combustibles': 'Combustibles',
		'Gastos Personal Exterior': 'Gastos Personal Exterior',
		'Mantenimiento': 'Mantenimiento',
		'Gastos de Desarrollo': 'Gastos de Desarrollo',
		'Atencion Empleados': 'Atencion Empleados',
	};


	var select = document.getElementById("concepto"+k);	
	
	$("#concepto" + k + " option[value='Taxis']").remove();
	$("#concepto" + k + " option[value='Capacitacion']").remove();
	$("#concepto" + k + " option[value='Casino y Restaurante']").remove();
	$("#concepto" + k + " option[value='Combustibles']").remove();
	$("#concepto" + k + " option[value='Gastos Personal Exterior']").remove();
	$("#concepto" + k + " option[value='Mantenimiento']").remove();
	$("#concepto" + k + " option[value='Gastos de Desarrollo']").remove();
	$("#concepto" + k + " option[value='Atencion Empleados']").remove();
	$("#concepto" + k + " option[value='Inv. Comercial']").remove();

	if(campo != ""){					
        select.options[select.options.length] = new Option('Inv. Comercial', 'Inv. Comercial');										
		$("#concepto"+k).val('Inv. Comercial')
	}
	else{	
		for(index in myobject) {
		select.options[select.options.length] = new Option(myobject[index], index);
}
	
		$("#concepto"+k).val('Taxis')

	}
}
</script>




<style type="text/css">
.container{padding: 8px; }
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
	</p> 
    
    <!--<form id="my-form" method="post" action="guardar.php?inserted=1" name="insertregistro" enctype="multipart/form-data">-->
    
   <form id="my-form" method="post"  name="insertregistro" enctype="multipart/form-data">

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
	    <td align="center" valign="top"><select class="form-control form-control-lg" name="TipoLegalizacion" id= "TipoLegalizacion" onchange="habilitartxt(this.value);">
        <option value="Reintegro Gastos">Reintegro Gastos</option>
	      <option value="Legalización Anticipo">Legalización Anticipo</option>
           <option value="Caja Menor">Caja Menor</option>
	      <option value="Tarjeta de Cr&eacute;dito">Tarjeta de Cr&eacute;dito</option>	      
	      </select></td>
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
	    <td ><input name="ValorAnticipo" type="number" disabled="disabled" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="ValorAnticipo" value="0" /></td>
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
	    <td width="12%" ><input name="fechamos" type='text' required class="form-control" id="fechamos" placeholder="Fecha" min="" value = "<?php echo date("d/m/Y");?>" readonly="readonly"/>
                       <input name="fecha" id="fecha" type="hidden" value="<?php echo date("d/m/Y");?>" />
                </td>
	    <td width="13%" ><input name="identificacion"  onKeyUp="empleado(1)" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="identificacion"  placeholder="Identificacion"/></td>
	    <td width="21%" ><input name="nombre" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="nombre"  placeholder="Nombres" value=""/></td>
	    <td width="13%" ><input name="cargo" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="cargo"  placeholder="Cargo"/></td>
	    <td width="9%" ><input name="ctocto" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="ctocto"  /></td>
	    <td width="13%" ><input name="Linea" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="Linea"  placeholder="Linea"/>
	      
	    </td>
	    <td width="19%" >
        <input name="Area" type="text" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="Area"  placeholder="Area"/>        
        </td>
	    </tr>
	  <tr>
	    <td colspan="7" ><br />
<br />
 </td>
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
	
   
    
	  <div class="panel panel-default users-content">
            <div class="panel-body"> 
              <p>
                <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"])) { ?> 
                <a href="view/addEdit.php?op=<?php echo $_REQUEST['op']?>" class="glyphicon glyphicon-plus" ></a>
                <?php }?>
                <input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
                <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /></p>
              <h3 align="center">Alta de Informacion </h3></p>
              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                  <td><div class="col-xs-2">
			    			      <label for="ex2">Fecha</label>
                                  <div class="input-group">
			    			      
			    			        <input type="text" class="form-control inputstl" name="fechasiguiente[]" id="dateArrival1" placeholder="Seleccionar Fecha" required>
		    			         
		    			        </div></div>
                                
                                
                                
                    <div class="col-xs-3">
			    			      <label for="ex2">Factura</label>
                                  <div class="input-group">
			    			     
			    			      <input name="factura[]" class="form-control input-sm" id="factura1"  required="required" type="text" placeholder="Factura">
		    			        </div></div>
                                

					<div class="col-xs-3">
			    			      <label for="ex2">Nit</label>
                                  <div class="input-group">
			    			     
			    			      <input name="nit[]" class="form-control" id="nit1" onKeyUp="valida(1)"   required="required" type="text" placeholder="NIT">
		    			        </div></div>                                
                                               
                                               
                    <div class="col-xs-4">
			    			      <label for="ex2">Establecimiento</label>
                                  <div class="input-group">
			    			     
			    			      <input name="establecimiento[]" class="form-control input-sm" id="establecimiento1" style="text-transform:uppercase" required="required" type="text" placeholder="Establecimiento">
		    			        </div></div>                                       
                                
                  </td>
                </tr>
                <tr>
                  <td>
                  <div class="col-xs-2">
			    			      <label for="ex2">Ciudad</label>
                                  <div class="input-group">
			    			     
			    			      <input name="ciudad[]" id="ciudad1" onKeyUp="ciudad(1)" class="form-control" style="text-transform:uppercase" required="required" type="text" placeholder="Ciudad">
		    			        </div></div>
                                
                    <div class="col-xs-3">
			    			      <label for="ex2">Codigo Inversion</label>
                                  <div class="input-group">
			    			     
			    			     <input name="cinversion[]" class="form-control input-sm" id="cinversion1" style="text-transform:uppercase" type="text" placeholder="C. Inversion" value ="" onBlur="seleccionaselect(document.getElementById('cinversion1').value,1)" >
		    			        </div></div>          
                                
                     
                    <div class="col-xs-3">
			    			      <label for="ex2">Tipo de Gasto</label>
                                  <div class="input-group">
			    			     
			    			     <select name="TipoGasto[]" class="form-control input-sm" id="TipoGasto1" style="width: 180px;"> <option value="Compras">Compras</option><option value="Servicios">Servicios</option><option value="Restaurante con Propina">Restaurante con Propina</option><option value="Restaurante sin Propina">Restaurante sin Propina</option><option value="Transportes Terrestres">Transportes Terrestres</option> </select>
		    			        </div></div>           
                               
                               
                    <div class="col-xs-4">
			    			      <label for="ex2">Concepto</label>
                                  <div class="input-group">
			    			     
			    			     <select name="concepto[]" class="form-control input-sm" id="concepto1" style="width: 180px;"> 
                    
                </select>
		    			        </div></div>  
                  
                  </td>
                </tr>
                <tr>
                  <td><div class="col-xs-5">
			    			      <label for="ex2">Descripcion</label>
                                  <div class="input-group">
			    			      
			    			       <textarea name="descripcion[]" class="form-control input-sm" id="descripcion1"  style="text-transform:uppercase" rows="3" cols="45"></textarea>	</div></div> 
                                   
                                   
                    <div class="col-xs-3">
			    			      <label for="ex2">Moneda</label>
                                  <div class="input-group">
			    			     
			    			      <select name="Moneda[]" class="form-control input-sm" id="Moneda1"> <option value="COP">Peso Colombiano</option><option value="US">Dolares</option><option value="EUR">Euros</option> </select> 
		    			        </div></div> 
                                
                                
                    <div class="col-xs-2">
			    			      <label for="ex2">Valor</label>
                                  <div class="input-group">
			    			     
			    			      <input name="valor[]" class="form-control input-sm" id="valor1" required="required" onclick="operaciones();" onblur="operaciones();" onChange="operaciones();" type="number" placeholder="0" >
		    			        </div></div>               
                                  
                                  
                                 
               	  </td>
                </tr>
                <tr>
                  <td><div class="col-xs-5">
			    			      <label for="ex2">Soporte</label>
                                  <div class="input-group">
			    			     
			    			      <input name="file[]" required="required" type="file" id="file1">
		    			        </div></div>
                  
                  </td>
                </tr>
                <tr>
                  <td><br />
                    <br />
<input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>" />
<input type="hidden" name="ultimoinserted" id="ultimoinserted" value="" />
<input name="input" type="submit" class="btn-primary" value="Enviar" /></td>
                </tr>
              </table>
              
            </div>
           
            
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
              
                <td colspan="4"><div id="resultado">
                 
                </div></td>
              </tr>
              <tr>
                <td width="21%">&nbsp;</td>
                <td width="20%" colspan="2"></td>
              </tr>
              <tr>
                <td colspan="4"><br />
                  <br />
<textarea name="textocnfo" rows="9" disabled="disabled" class="form-control mb-2 mr-sm-2 mb-sm-0" id="textocnfo"></textarea></td>
              </tr>
              
              <tr>
                <td colspan="4"><br />
                  <br />
</td>
              </tr>
              <tr>
                <td colspan="4"><div class="col-xs-10">
                  <label for="ex2">Observaciones</label>
                  <div class="input-group">
                    <textarea name="txtobservaciones" rows="3" class="form-control mb-2 mr-sm-2 mb-sm-0" id="txtobservaciones" placeholder="Observaciones" onclick="operaciones();"></textarea>
                  </div></div> </td>
              </tr>
              
            </table>
            
            
            

            
            <p>&nbsp;</p>
            
            
       
            
            
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



		
				
