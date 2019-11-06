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
  header("location:../../scandinavia/seguridad/index.php");
} 
else {?>
<!---->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>


<script type="text/javascript" src="assets/ajax.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">


<script src="assets/jquery.maskMoney.js" type="text/javascript"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
      <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
          
<script type='text/javascript'>
    $( document ).ready(function() {
        $('#datetimepicker1').datetimepicker();
        $('#datetimepicker2').datetimepicker();
    });
    
</script>
<!--AJAX-->
        <script>
            $(document).ready(function() {
                <!--#my-form grabs the form id-->
                $("#my-form").submit(function(e) {
                    e.preventDefault();
					document.getElementById("buttonsave").disabled = true; 
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
							 var kkk = strMessage;
							document.getElementById("ultimoinserted").value= strMessage; 
							 
							
							document.getElementById("cuenta").value =  "";
							document.getElementById("tipo1").value =  "";
							document.getElementById("banco1").value = "";
							document.getElementById("ciudad1").value = "";
							document.getElementById("cinversion1").value = "";
							document.getElementById("Moneda1").value = ""; 
							document.getElementById("valor1").value= "";
							document.getElementById("buttonsave").disabled = false;
							
							 $("#resultado").load('ajax-grid-lgi.php',{'varidentificadounico': strMessage}); 

                        }
                    });
                });
            });
        </script>

<script type="text/javascript">

function eliminarsolicitud2(idanticipo, consecutivo ){
	//donde se mostrará el resultado de la eliminacion
	divResultado = document.getElementById('resultado');
	
	//usaremos un cuadro de confirmacion	
	var eliminar = confirm("De verdad desea eliminar la transacción " + consecutivo + " este dato?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizará el proceso de eliminación
		//junto con un valor que representa el id del empleado
		ajax.open("GET", "eliminadetalle.php?documento="+idanticipo,true); 
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				//mostrar resultados en esta capa
				divResultado.innerHTML = ajax.responseText
				 $("#resultado").load('ajax-grid-lgi.php',{'varidentificadounico': consecutivo});
			}
		}
		//como hacemos uso del metodo GET
		//colocamos null
		ajax.send(null)
	}
}


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
                source: "buscarDatos.php",
                minLength: 1,
                select: function(event, ui) {
					event.preventDefault();					
					$('#ciudad'+j).val(ui.item.Nombres);
					$("#cinversion"+j).focus();
			     }
            });
		};	
		
function banco(j) {
            $("#banco"+j).autocomplete({
                source: "buscar.php",
                minLength: 1,
                select: function(event, ui) {
					event.preventDefault();
					$('#banco'+j).val(ui.item.descripcion); 
					
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
		

function empleado2(j) {
//Disparar funcion al hacer clic en el boton Ajax
$('#identificacion').blur(function () {
	var x = $("#identificacion").val();

  //llamada ajax
  $.ajax({
	data: {var1: x} ,
    url: "getdatos.php", //url de donde obtener los datos
    dataType: 'json', //tipo de datos retornados
    type: 'post' //enviar variables como post
  }).done(function (data){
	  
      /*ejecutar las siguientes instrucciones
      * al terminar de ejecutar la llamada
      * ajax*/
 
      //convertir el objeto JSON a texto
      var json_string = JSON.stringify(data);
      
      //convertir el texto a un nuevo objeto
      var obj = $.parseJSON(json_string);
	  

	  
 
      /*asignar los valores obtenidos del objeto
      * a cada unos de losc controlres deseados
      * en el formulario*/
		$('#nombre').val(data.Nombre);
		$('#cargo').val(data.Cargo);
		
		$('#Linea').val(data.Linea);
		$('#Area').val(data.Areaterapeutica);
		$('#ctocto').val(data.CentroCosto);   
		$("#txtobservaciones").focus();

    }).fail( function() {

    alert( 'Error!!, Identificacion ' + x + ' no encontrada ' );	
	$("#identificacion").val('');
	$("#identificacion").focus();

});
  });
};

		
			
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
    
    <table width="100%" border="0">
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    <td colspan="3" align="center"><h3>Solicitud de Anticipo</h3></td>
            	    </tr>
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    <td colspan="4" align="right">&nbsp;</td>
            	    <td align="center" valign="top">&nbsp;</td>
            	  </tr>        
            	  </table>	
            	
    <!--<form id="my-form" method="post" action="guardar.php?inserted=1" name="insertregistro" enctype="multipart/form-data">-->
   <div class="panel panel-primary">
            <div class="panel-heading text-center form-control" ></div>
             
               <form id="my-form" method="post"  name="insertregistro" enctype="multipart/form-data">
                
                        
            	
               
                    <div class="panel-body"> 
                            <?php
                            date_default_timezone_set('America/Bogota');
                            $fechaActual=date("d-m-Y");
                            ?>
                            <div class="row">
                                
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Fecha de solicitud</label>
            			    			                                    <input class="form-control" type="datetime" name="fechaActual" id="fecha" readonly="readonly" value="<?= $fechaActual?>"/> 
                                                                            </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Identificación</label>
                                        			    			        <input name="identificacion"  id="identificacion" onKeyUp="empleado(1)"  onBlur="empleado2(1)" type="text" required="required" class="form-control" id="identificacion"  placeholder="Identificación"/>
                                                                            </div>
                                                                
                                                            </div>
                                                           
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Nombre del solicitante</label>
                                        			    			        <input name="nombre" type="text" required="required" class="form-control" id="nombre"  placeholder="Nombre" value=""/>
                                                                            </div>
                                                                
                                                            </div>
                             
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Consignar en cuenta</label>
                                                                                <div class="input-group">
                                            			    			        <input name="cuenta[]" class="form-control input-sm" id="cuenta" style="text-transform:uppercase" required="required" type="text" placeholder="Cuenta">
                                            		    			            </div>
                                                                            </div>
                                                                
                                                            </div>
                            </div>
                             <div class="row">                                
                                                            
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Tipo</label>
                                                			    			     <select name="Tipo[]" class="form-control input-sm" id="tipo1" style="width: 180px;"> <option value="ahorros">Ahorros</option><option value="corriente">Corriente</option><option value="efectivo">Efectivo</option> </select>
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                 <label for="ex2">Banco</label>
                                                                                 <input name="banco[]" id="banco1" onKeyUp="banco(1)" class="form-control" style="text-transform:uppercase" required="required" type="text" placeholder="Banco">
                                                                            </div>
                                                            </div>
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Ciudad</label>
                			    			                                    <input name="ciudad[]" id="ciudad1" onKeyUp="ciudad(1)" class="form-control" style="text-transform:uppercase" required="required" type="text" placeholder="Ciudad">
                                                                            </div>
                                                                
                                                            </div>
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Codigo Inversion</label>
                                                                                <input name="cinversion[]" class="form-control input-sm" id="cinversion1" style="text-transform:uppercase" type="text" placeholder="C. Inversion" value ="" >
                                                                            </div>
                                                                
                                                            </div>
                                                             
                                                           
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Fecha Inicial</label>
                                                                                  <div class="input-group date"  id="datetimepicker1">
                                                                                        <input type="text" name="fechaIni" class="form-control" value="01/08/2019">
                                                                                        <div class="input-group-addon">
                                                                                            <span class="glyphicon glyphicon-th"></span>
                                                                                        </div>
                                                                                   </div>
                                                                            </div>
                                                                
                                                            </div>
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Fecha Final</label>
                                                                                  <div class="input-group date"  id="datetimepicker2">
                                                                                    <input type="text" name="fechaFin" class="form-control" value="01/08/2019">
                                                                                    <div class="input-group-addon">
                                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                                    </div>
                                                                               </div>
                                                                            </div>
                                                                
                                                            </div>
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Moneda</label>
                                                                                <select name="Moneda[]" class="form-control input-sm" id="Moneda1"> <option value="COP">Peso Colombiano</option><option value="US">Dolares</option><option value="EUR">Euros</option> <option value="GBP">Libra esterlina</option> </select>
                                                                            </div>
                                                                
                                                            </div>
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Valor</label>
                                                                              <div class="input-group">
                                                                               <span class="input-group-addon">$</span>                                                                    
                                                                               <input id="valor1" name="valor[]" class="form-control currency"  type="text"/>
                                            											<script type="text/javascript">$("#valor1").maskMoney();</script>
                                            								    </div>			
                                                                            </div>
                                                                
                                                            </div>
                                                          
                                                            <div class="col-md-6">
                                                                            <div class="form-group">
                                                                             <label for="ex2">Descripcion</label>
                                                                             <textarea name="descripcion[]" class="form-control input-sm" id="descripcion1"  style="text-transform:uppercase" rows="3" cols="45"></textarea>	</div>
                                                                            </div>
                                                                
                                                            </div>
                                                            
                             
                            
                            <tr>
                              <td><br />
                                <br />
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>" />
            <input type="hidden" name="ultimoinserted" id="ultimoinserted" value="" /> 
            
            <input name="input" type="submit" id="buttonsave"  class=" btn btn-primary" value="Enviar Información" /> 
            
            
            
            
            </td>
                            </tr>
                          
                          
                        </div>
                       
                        
                        <table width="100%" border="0" cellspacing="1" cellpadding="1">
                          <tr>
                          
                            <td colspan="4">
                                <div id="resultado">
                             
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td width="21%">&nbsp;</td>
                            <td width="20%" colspan="2"></td>
                          </tr>
                         
            
                          
                        </table>
                        
                        
                        
            
                        
                        <p>&nbsp;</p>
                        
                        
                   
                        
                        
                      </form> 
                        
            </div>              
                     
                        
                                  
                    </div>
            </div>
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
              2019 - HBT
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
      

<?php require_once('../../pie.php'); }?>



		
				
