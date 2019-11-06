<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$cedulaSesion = $_SESSION['identificacion'];
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
  header("location:../../index.php");
} 
else {?>
<!---->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>


<script type="text/javascript" src="assets/ajax.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">


<script src="assets/jquery.maskMoney.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>


<!--AJAX-->
        <script>
            $(document).ready(function() {
                
                <!--#my-form grabs the form id-->
                 $("#valida").hide();	
				<!--#my-form grabs the form id-->
				$('#seleccion').hide();
				$('#aprobadores').hide();
                $("#my-form").submit(function(e) {
                    e.preventDefault();
					document.getElementById("buttonsave").disabled = true;
                    $.ajax( {
                        <!--insert.php calls the PHP file-->
                        url: "guardarajaxEmpleado.php",
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
							document.getElementById("valor1").value= "";                            
							document.getElementById("buttonsave").disabled = false; 
							
							 $("#resultado").load('ajax-grid-antE.php',{'varidentificadounico': strMessage}); 

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
				 $("#resultado").load('ajax-grid-antE.php',{'varidentificadounico': consecutivo});
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
					$("#establecimiento"+j).focus();
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
		$('#seleccion').show();
        dato();
		$("#txtobservaciones").focus();

    }).fail( function() {

    alert( 'Error!!, Identificacion ' + x + ' no encontrada ' );	
	$("#identificacion").val('');
	$("#identificacion").focus();

});
  });
};

		
			
</script>

<script type="text/javascript">

//efectivo1
//transferencia1
//cheque1

function disableCheck(field, causer) {
if (causer.checked) {
field.checked = false;
field.disabled = true;

}
else {
field.disabled = false;
}
}

function disableDos(field) {
disableCheck(insertregistro.transferencia1, field);
}

function disableUno(field) {
disableCheck(insertregistro.efectivo1, field);

}


</script>


<script type="text/javascript">

//inversioncom1
//otros1

function disableCheck(field, causer) {
    if (causer.checked) {
    field.checked = false;
    field.disabled = true;

    }
    else {
        field.disabled = false;
    }
}

function deshabilitarInversion(field) {
disableCheck(insertregistro.inversioncom1, field);
}

function deshabilitarOtros(field) {
   
disableCheck(insertregistro.otros1, field);
}




</script>

		

<script type="text/javascript">
$(document).ready(function(){
    $("#inversioncom1").change(function(){
        var inversioncom1 = $(this).val();
        if($("#inversioncom1").prop('checked')){
        if($("#texto").length === 0){
            $("#info").append("<label id='nombreEvento'>Nombre del Evento<label>");
            $("#info").append("<input class='form-control' name='evento' required id='texto' type='text' placeholder='Nombre'>");
            $("#info2").append("<label id='inver'>C. inversión<label>");
            $("#info2").append("<input class='form-control' name='cinversion' style='text-transform:uppercase' required id='texto1' type='text'placeholder='C.inversión'>");
            $("#info3").append("<label for='ex2' id='fec'>Fecha Inicial</label>");
            $("#info3").append("<input type='date' class='form-control inputstl'required name='fechaini' id='fechaini'>");
            $("#info4").append("<label for='ex2' id='fech'>Fecha Final</label>");
            $("#info4").append("<input type='date' class='form-control inputstl' required name='fechafin' id='fechafin'>");
            $("#info5").append("<label for='ex2' id='des'>Descripcion</label>");
            $("#info5").append("<textarea name='descripcion' class='form-control input-sm' required id='descripcion1'   rows='3' cols='45'></textarea>");
        }    	
        }else{
            $("#texto").remove(); 
            $("#texto1").remove(); 
            $("#nombreEvento").remove(); 
            $("#inver").remove(); 
            $("#fechaini").remove(); 
            $("#fec").remove(); 
            $("#fechafin").remove(); 
            $("#fech").remove(); 
            $("#des").remove(); 
            $("#descripcion1").remove(); 

        }
    });
    $("#otros1").change(function(){
        var inversioncom1 = $(this).val();
        if($("#otros1").prop('checked')){
        if($("#descripcion1").length === 0){
          
            $("#info5").append("<label for='ex2' id='des'>Descripcion</label>");
            $("#info5").append("<textarea required name='descripcion' class='form-control input-sm' id='descripcion1'  style='text-transform:uppercase' rows='3' cols='45'></textarea>");
        }    	
        }else{
             
            $("#des").remove(); 
            $("#descripcion1").remove(); 

        }
    });
});


function dato()
{
	let identificacion = $('#identificacion').val();
	$.ajax({
				url:'info4.php',
				type: 'POST',
				data: {identificacion},
				success: function (response) {
					let infor = JSON.parse(response);
					let template = '';
						infor.forEach(dato => {
						template += `${dato.Aprobador} <input type="hidden" name="nombreaprobador" id="aprobador" value="${dato.idAprobador}">`
						
					
                    });

					$('#apro1').html("El aprobador de este anticipo es: <strong>"+template+"</strong></h5> ");	
					$('#apro2').html("<div id='checkaprobador'><h5>Cambiar aprobador: <input type='hidden'><input type='checkbox' id='cambioapr' name='cambioaprobador' onchange='check1()'></h5></div> <br>");	
										
				}
			})	
}

function listadoAprobadores() {
	
	$("#listaapr").autocomplete({
		source: "buscarapr.php",
		minLength: 2,		
		select: function(event, ui) {
			
			event.preventDefault();		
			
			$('#listaapr').val(ui.item.value);
			$('#listaapr1').val(ui.item.id);
			$('#listaapr2').val(ui.item.cedula);
			$('#aprobador').val('');		
			prueba();	 
		}
	});
};

function aprobador2(j) {
//Disparar funcion al hacer clic en el boton Ajax
		$('#listaapr').blur(function () {
		var x = $("#listaapr").val();
		
		//llamada ajax
				$.ajax({
				data: {var1: x} ,
				url: "getdatos1.php", //url de donde obtener los datos
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
					$('#listaapr').val(data.full_name);
					$('#listaapr2').val(data.cedula);			
					$('#listaapr1').val(data.u_userid);						
					prueba();
				}).fail(function (data) {
					
					$('#listaapr2').val('');
					$("#listaapr1").val('');
					prueba();
				})
				

		});

};


function prueba() {

			
		
let id = $('#listaapr2').val();
let cedulaIngresada = $('#identificacion').val();	 


 if(id === cedulaIngresada)
 {
   $("#valida").show();	
   $('#valida').html("<div class='alert alert-danger'><h5>Ingrese un aprobador válido</h5></div>");				
   document.getElementById("buttonsave").disabled=true;
 }
 else 
 {
    $("#valida").show();	
    $('#valida').html("<div class='alert alert-success'>VALIDO</div>");
    let codigo = document.getElementById('listaapr1').value;
    if(codigo === "")
   {
       $("#valida").show();	
       $('#valida').html("<div class='alert alert-danger'><h5>Ingrese un aprobador válido</h5></div>");

       document.getElementById("buttonsave").disabled=true;	
   }
   else
   {

       $("#valida").show();	
       $('#valida').html("<div class='alert alert-success'><h5>Aprobador válido</h5></div>");			
       document.getElementById("buttonsave").disabled=false;
       document.getElementById("listaapr").disabled=true;
   }
 }

}

function check1()
	{
		var resultado = confirm("¿Estas seguro que desea cambiar el aprobador de este anticipo?");
		
		if(resultado == true)
		{
			var isChecked1 = document.getElementById('cambioapr').checked;
			if(isChecked1)
			{
				$('#aprobadores').show(); 
				
			}
			else
			{
				$('#aprobadores').hide(); 
				$('#listaapr2').val('');
				$("#listaapr1").val('');
				$("#listaapr").val('');
				$('#valida').hide();
				
			}
		}
		else 
		{
			$('#aprobadores').hide(); 
			$('#listaapr2').val('');
			$("#listaapr1").val('');
			$("#listaapr").val('');				
			$('#valida').hide();
			document.getElementById("buttonsave").disabled=false;
			document.getElementById("cambioapr").checked=false;
			
		}

	}

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
            maxDate: '+999999999999999999999999999999d',
            minDate: '0d'
            
});
});
		
				
						
</script>



<style type="text/css">
.container{padding: 8px; }
table tr th, table tr td{font-size: 1.2rem;}

.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}


.texto 
{
    color:black;
    margin-top:4px;
}

@media screen and (max-width: 800px) 
{
    .texto
    {
        margin-top:4px;
    }
}


@media screen and (max-width: 600px) 
{
    .texto
    {
        margin-left:30px;
        margin-top:-20px ;
    }
}


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
            <a href="https://appmegalabs.com/scandinavia/aplicaciones/Anticipos/tipoAnticipo.php?op=Creaci%C3%B3n%20Anticipos" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
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
	  <?php } ?>
	</p> 
    
    <table width="100%" border="0">
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    <td colspan="3" align="center"><h3>Solicitud de Anticipo Empleado</h3></td>
            	    </tr>
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    <td colspan="4" align="right">&nbsp;</td>
            	    <td align="center" valign="top">&nbsp;</td>
            	  </tr>        
            	  </table>	
            	
    <!--<form id="my-form" method="post" action="guardar.php?inserted=1" name="insertregistro" enctype="multipart/form-data">-->
   <div class="panel" style="border:1px solid #00AB84;">
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
            			    			                                    <input name="fechaActual" type='text' required class="form-control" id="fechaActual" placeholder="Fecha" min="" value = "<?php echo date("d/m/Y");?>" readonly="readonly"/>
									                                        <input name="fecha" id="fecha1" type="hidden" value="<?php echo date("d/m/Y");?>" />
                                                                            </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Identificación</label>
                                        			    			        
                                        			    			        <input name="identificacion"  required id="identificacion" onKeyUp="empleado(1)"  onBlur="empleado2(1)" type="text" required="required" class="form-control" id="identificacion"  placeholder="Identificación"/>
                                                                            </div>
                                                                
                                                            </div>
                                                           
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Nombre</label>
                                        			    			        <input name="nombre" type="text" required="required" class="form-control" id="nombre"  placeholder="Nombre" value=""/>
                                                                            </div>
                                                                
                                                            </div>

                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Moneda</label>
                                                                                <select name="Moneda[]" class="form-control input-sm" id="Moneda1"> <option value="COP">Peso Colombiano</option><option value="USD">Dolares</option><option value="EUR">Euros</option> <option value="GBP">Libra esterlina</option> </select>
                                                                            </div>
                                                                
                                                            </div>    
                                                             <div class="col-md-2">
                                                                            <div class="form-group">                                                                            
                                                                                <div class="input-group">
                                                                                
                                                                                <label for="ex2">Monto</label>
                                                                                <div class="input-group">
                                                                                <span class="input-group-addon">$</span>                                                                    
                                                                                <input id="valor1" name="valor[]" class="form-control" type="text" required="required"/>                                                                                      
                                                                                <script type="text/javascript">$("#valor1").maskMoney();</script>
                                                                                
                                                                                </div>
                                                                                                                                                               
                                                                                </div> 
                                                                                
                                            		    			             
                                                                            </div>
                                                                          
                                                                                
                                                                                
                                                                             
                                                                
                                                            </div>                                                            
                                                            <div class="col-md-1">
                                                            </div>
                                                            <div class="col-md-3 ">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Modo de pago</label>
                                                                                <div class="row">
                                                			    			        <div class="col-md-2">
                                                                                        <input type="checkbox" required name="efectivo" id="efectivo1"  onClick="disableDos(this)"> 
                                                                                     </div>
                                                                                     <h5 class="texto">Efectivo</h5>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <input type="checkbox" required name="transferencia" id="transferencia1"  onClick="disableUno(this)">
                                                                                    </div>
                                                                                    <h5 class="texto">Transferencia</h5>
                                                                                </div>
                                                                                
                                                                                 
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-3 ">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Tipo</label>
                                                                                <div class="row">
                                                			    			        <div class="col-md-2">
                                                                                        <input type="checkbox" required name="inversioncom" id="inversioncom1" onClick="deshabilitarOtros(this)">
                                                                                     </div>   
                                                                                     <h5 class="texto"> Inversión Comercial</h5>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <input type="checkbox" required name="otros" id="otros1" onClick="deshabilitarInversion(this)">
                                                                                    </div>
                                                                                    <h5 class="texto"> Otros</h5>
                                                                                </div>
                                                                                                                                                                 
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-3 ">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Fecha Desembolso</label>
                                                                                <div class="row">
                                                			    			        <div class="col-md-8">
                                                                                    <input type="text" class="form-control form-control-lg" name="fechadesembolso" id="dateArrival1" placeholder="Seleccionar Fecha" required>
                                                                                     </div>   
                                                                                     
                                                                                </div>
                                                                                
                                                                                                                                                                 
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                        
                                                                        <div id="subida">
                                                                        </div>
                                                                        <div id="subida1">                                                                                      
                                                                        </div>
                                                                        <br>
                                                            </div>
                                                            
                            </div>                          

                             <div class="row">                                
                                                            
                                                             
                                                            
                                                            
                                                            
                                                            
                                </div>                            
                                <div class="row">
                                    <div class="col-md-3">
                                        <div id="info">                                       
                                        </div>                                     

                                    </div>
                                    <div class="col-md-2">
                                        <div id="info2">                                       
                                        </div>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <div id="info3">                                       
                                        </div>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <div id="info4">                                       
                                        </div>
                                    </div>
                                </div>    
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="info5">
                                        </div>
                                    </div>
                                </div>                      
                             
                            
                            <tr>
                              <td><br />
                                <br />
            
            <div class="panel-body" id="seleccion">
	<div class="panel" style="border:1px solid #00AB84;" >            
			<div class="panel-heading text-center form-control" >Seleccion Aprobador</div>  
			
			<td >&nbsp;</td>
			<td >&nbsp;</td>
			<div class="row">
				<div class="col-md-4" id=""></div>
				<div class="col-md-6" id="apro1"></div>				
				
			</div>
			<div class="row">
				<div class="col-md-4" id=""></div>
				<div class="col-md-6" id="apro3" ></div>				
				
			</div>			
			<div class="row">
			<div class="col-md-4" id=""></div>
			<div class="col-md-6" id="apro2"></div>			
            </div>
            <br>
			<div class="row">
            <div class="col-md-4" id=""></div>	
            
			<div class="col-md-5" id="aprobadores">
				<input type="text" class="form-control" id="listaapr"  name="aprobador" onKeyUp="listadoAprobadores()" onBlur="aprobador2(1)" OnChange="prueba()" >
				<input type="hidden"  id="listaapr1" name="codigoAprobador">
				<input type="hidden"  id="listaapr2" name="cedulaAprobador">
							
			</div>			
			</div>
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-5">
				<div id="valida"></div>
				</div>
			</div>
			

	</div>
	</div>
	</div>
            <div class="row">
                <div class="row">
                    <div class="col-md-2">
                    <input type="hidden" name="ultimoinserted" id="ultimoinserted" value="" /> 
            <input type="hidden" name="tp" id="tp" value="<?=$_REQUEST['tp']?>">
            <input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
                <input name="username" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" />
               <div id="apro"></div>
                    </div>
                <div class="col-md-10">

                    <input name="input" type="submit" id="buttonsave"  class=" btn" style="background-color:#00AB84; color:white;" value="Enviar Información" /> 
                    
                </div>
                <br>
                <br>
             </div>   
            
            
            
            
            
            </td>
                            </tr>
                          
                          
                        </div>
                       
                        
            <div class="table-responsive">  
            <table width="100%" cellspacing="1" cellpadding="1">
              <tr>
              
                <td colspan="2"><div id="resultado">
                 
                </div></td>
              </tr>
           
              
            </table>
            </div>
            
            

            
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



		
				
