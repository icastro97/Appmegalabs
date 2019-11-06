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
	$sid = $_REQUEST['documento'];  		
}


//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from database
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar


$bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar

$conditions['where'] = array('id_cabeza'=> $sid,); 
$users = $db->getRows('lg_cabeza',$conditions); //ojo se pone tabla a consultar


$condicion['where'] = array('u_userid'=> $users[0]['aprobador'],); 
$apr = $db->getRows('system_users',$condicion); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('id'=> $sid,); 
$detalle = $db->getRows('lg_det_cabeza',$conditionsdetalle); //ojo se pone tabla a consultar

$conditionsdetalle1['where'] = array('identificador'=> $detalle[0]['identificador'],); 
$detalle1 = $db->getRows('lg_det_cabeza',$conditionsdetalle1); //ojo se pone tabla a consultar






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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script type="text/javascript" src="assets/popcalendar.js"></script>
<script type="text/javascript" src="assets/ajax.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
    
  <script  src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="		  crossorigin="anonymous"></script>
<script	  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="	  crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />


<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">

<script src="assets/jquery.maskMoney.js" type="text/javascript"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--AJAX-->
        <script>
            $(document).ready(function() {
               	$('#num').hide();
				$('#panel10').hide();
				$('#pan2').hide();
				$('#cantidad').hide();
				$('#importador1').hide();			
				$('#nopaneles2').hide();
				$('#empleados1').hide();
				$('#nopaneles1').hide();
				$('#pan1').hide();
				$("#valida").hide();					
				$('#actualizaciontipo').hide();
				$('#aprobadores').hide();
                $("#info").hide();
                $("#info").show();
				$("#info1").hide();
				dato();
                <!--#my-form grabs the form id-->
                $("#my-form").submit(function(e) {
                    e.preventDefault();
					 document.getElementById("buttonsave").disabled = true; 
                    $.ajax( {
                        <!--insert.php calls the PHP file-->
                        url: "guardarajax2.php",
                        method: "post",
                        //data: $("form").serialize(),
					    data: new FormData( this ),
					    processData: false,
					    contentType: false,
                        dataType: "text",
                        success: function(strMessage) {
                            $("#message").text(strMessage);
							// alert(strMessage);//this will alert you the last_id
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
							
							document.getElementById("valor1").value = "";
							document.getElementById("file1").value = ""; 
							document.getElementById("dateArrival1").focus();
							document.getElementById("buttonsave").disabled = false; 
							traerDatos();
							
							$("#resultadotemporal").hide();
							$("#resultado1").load('ajax-grid-lgi.php',{'varidentificadounico': strMessage});
							
							 
							 

                        }
                    });
                });
            });
        </script>

<script type="text/javascript">
function eliminarsolicitud2(idempleado,idkey){
	//donde se mostrará el resultado de la eliminacion
	divResultado = document.getElementById('resultado1');
	
	//usaremos un cuadro de confirmacion	
	var eliminar = confirm("De verdad desea eliminar la factura " + idkey + " ?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizará el proceso de eliminación
		//junto con un valor que representa el id del empleado
		ajax.open("GET", "eliminadetalle.php?documento="+idempleado+"&factura="+idkey,true);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				//mostrar resultados en esta capa
				divResultado.innerHTML = ajax.responseText
				traerDatos();
				
				$("#resultadotemporal").hide();
				 $("#resultado1").load('ajax-grid-lgi.php',{'varidentificadounico': idkey});
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
		
		
		
$(function () {
	
	
		if($('#identificacion').val())
		{
			let identificacion = $('#identificacion').val();
			$.ajax({
				url:'info.php',
				type: 'POST',
				data: {identificacion},
				success: function (response) {
					let datos = JSON.parse(response);
					let template = '<option value=" ">Anticipo emitido por Axapta</option>';
						datos.forEach(dato => {
						template += `					
						<option value="${dato.consecutivo}">${dato.consecutivo}, ${dato.descripcion}, ${dato.moneda}, $${dato.monto}, $${dato.total}</option>`
						
					
					});

					if(template === "")
					{
						document.getElementById("anticipoE").length=0;
						document.getElementById("anticipoE").disabled = true;
					    $('#anticipoE').html(template);	
					}
					else
					{
						document.getElementById("anticipoE").disabled = false;
						$('#anticipoE').html(template);	
						
					}
					
				}
			})
		}
		else
		{
			document.getElementById("anticipoE").value = "";
			document.getElementById('nombre').value = "";
			document.getElementById('cargo').value = "";		
			document.getElementById('Linea').value = "";
			document.getElementById('Area').value = "";
			document.getElementById('ctocto').value = ""; 
			$('#info').hide();
		}
	
	 
 });	
 
 
 
 function traerDatos()
{
	let identificacion = $('#identificacion').val();
	$.ajax({
				url:'info3.php',
				type: 'POST',
				data: {identificacion},
				success: function (response) {
					let infor = JSON.parse(response);
					let template = '<option value=" ">Anticipo emitido por Axapta</option>';
						infor.forEach(dato => {
						template += `					
						<option value="${dato.consecutivo}">${dato.consecutivo}, ${dato.descripcion}, ${dato.moneda}, $${dato.monto}, $ ${dato.total}</option>`
						
					
					});
					$('#anticipoE').html(template);	
									
				}
			})	
}




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
						template += `<input name="aprobador" type="text" value="${dato.idAprobador}">`
						
					
					});
					$('#apro').html(template);	
					
										
				}
			})	
}





function actualizartipo() 
{
	let tipolegalizacion = $('#tipolegalizacion').val();
	let consecutivo = $('#docupdate').val();
	$.ajax({
				url:'actualizacionTipo.php',
				type: 'POST',
				data: {tipolegalizacion, consecutivo},
				success: function (response) {					
					if(response == "Ok")
					{
						swal ( "Tipo legalizacion" ,  "Se realizó el cambio del tipo correctamente." ,  "success");		
							setInterval("actualizar()",1000);
						
					}
					else 
					{
						swal ( "Tipo legalizacion" ,  "No se realizó el cambio del tipo." ,  "error");
						let tipo = $('#tipe').val();			
						$('#tipolegalizacion').val(tipo);
					}
								
				}
	})		
}

function actualizarObservacion() 
{
	let observaciones = $('#txtobservaciones').val();
	let consecutivo = $('#docupdate').val();
	$.ajax({
				url:'actualizacionOb.php',
				type: 'POST',
				data: {observaciones, consecutivo},
				success: function (response) {					
					if(response == "Ok")
					{
						swal ( "Observaciones" ,  "Se realizó el cambio de las observaciones correctamente" ,  "success");		
							setInterval("actualizar()",1000);
					}
					else 
					{
						swal ( "Observaciones" ,  "No se realizó el cambio de las observaciones." ,  "error");
						let tipo = $('#txtobservaciones').val();			
						$('#txtobservaciones').val(tipo);
					}
								
				}
	})		
}








function check1()
	{
		var resultado = confirm("¿Estas seguro que desea cambiar el aprobador de esta legalización?");
		
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
						template += `<h5>El aprobador de esta legalizacion es: <strong>${dato.full_name}</strong><h5> <input type="hidden" name="nombreaprobador" id="aprobador" value="${dato.u_userid}">  <input type="hidden" name="cedulaAprobador" id="cedulaAprobador" value="${dato.cedulaAprobador}">`
						
					
					});
					
					
					$('#apro2').html("<div id='checkaprobador'><h5>Cambiar aprobador: <input type='hidden'><input type='checkbox' id='cambioapr' name='cambioaprobador' onchange='check1()'></h5></div> <br>");	
								
				}
			})	
}






function prueba() {

			
		
let id = $('#listaapr2').val();
let cedulaIngresada = $('#identificacion').val();	 


 if(id === cedulaIngresada)
 {
   $("#valida").show();	
   $('#valida').html("<div class='alert alert-danger'><h5>Ingrese un aprobador válido</h5></div>");				
   swal ( "Cambio aprobador" ,  "No se realizó el cambio del aprobador." ,  "error");
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
	   swal ( "Cambio aprobador" ,  "No se realizó el cambio del aprobador." ,  "error");
	   document.getElementById("buttonsave").disabled=true;	
   }
   else
   {

	   $("#valida").show();	
	   $('#valida').html("<div class='alert alert-success'><h5>Aprobador válido</h5></div>");
	   let listaapr1 = $('#listaapr1').val();
	   let consecutivo = $('#docupdate').val();
	   $.ajax({
				url:'actualizaAprobador.php',
				type: 'POST',
				data: {listaapr1, consecutivo},
				success: function (response) {					
					if(response == "Ok")
					{
						swal ( "Cambio aprobador" ,  "Se realizó el cambio del aprobador correctamente." ,  "success");		
						setInterval("actualizar()",1000);
					}
					else 
					{
						swal ( "Cambio aprobador" ,  "No se realizó el cambio del aprobador." ,  "error");
					}
								
				}
	})			
	   document.getElementById("buttonsave").disabled=false;
	   document.getElementById("listaapr").disabled=true;
   }
 }

}

function actualizar(){location.reload(true);}
//Función para actualizar cada 4 segundos(4000 milisegundos)
  



function listadoAprobadores() {
	let cedula = $('#cedulaLogueada').val();
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
            maxDate: '0d' 
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


$(function () {
    
            let tipo = $("#tipolegalizacion").val();
            if(tipo === "Legalizacion Anticipo")
			{ 
			  	document.getElementById("anticipoE").disabled=false;	
				document.getElementById("anticipoP").disabled=false;
				$('#info').show();																					 				   										
			}
			else
			{
				$('#info').hide();	
				$('#info1').hide();	
				document.getElementById("anticipoE").disabled=true;	
				document.getElementById("anticipoP").disabled=true;	
			}
			
 });

var ii=0;

function seleccionaselect(campo, k)
{	

	var myobject = {
				'Capacitacion': 'Capacitación',
		'Casino y Restaurante': 'Casino y Restaurante',
		'Combustibles': 'Combustibles',
		'Atencion a Empleados':'Atencion a Empleados',
		'Dotacion':'Dotacion',
		'Gastos de desarrollo':'Gastos de desarrollo',
		'Tramites Legales Locales':'Tramites Legales Locales',
		'Personal del exterior':'Personal del exterior',
		'Taxis y Buses':'Taxis y Buses',
		'Viajes al exterior':'Viajes al exterior',
		'Aseo y Cafeteria': 'Aseo y Cafeteria',
		'Envio Documentos Exterior': 'Envio Documentos Exterior',
		'Viajes Nacionales': 'Viajes Nacionales',
		'Utiles Papeleria y Fotocopias': 'Utiles Papeleria y Fotocopias',
		'Envio Mercancia':'Envio Mercancia',
		'Viajes Gerencia General': 'Viajes Gerencia General',
		'Manten y Rep. Edificios y C':'Manten y Rep. Edificios y C',
		'Manten y Rep. Equipo Oficina': 'Manten y Rep. Equipo Oficina',
		'Manten y Rep. Equipo Computo': 'Manten y Rep. Equipo Computo',
		'Muestras Calidad':'Muestras Calidad',
		'Tramites Legales Exterior':'Tramites Legales Exterior',
		'Tramites Legales Cambio Imagen': 'Tramites Legales Cambio Imagen'
	};


	var select = document.getElementById("concepto"+k);	
	
$("#concepto" + k + " option[value='Capacitacion']").remove();
	$("#concepto" + k + " option[value='Casino y Restaurante']").remove();
	$("#concepto" + k + " option[value='Combustibles']").remove();
	$("#concepto" + k + " option[value='Atencion a Empleados']").remove();
	$("#concepto" + k + " option[value='Dotacion']").remove();
	$("#concepto" + k + " option[value='Tramites Legales Locales']").remove();
	$("#concepto" + k + " option[value='Personal del exterior']").remove();
	$("#concepto" + k + " option[value='Taxis y Buses']").remove();
	$("#concepto" + k + " option[value='Viajes al exterior']").remove();
	$("#concepto" + k + " option[value='Aseo y Cafeteria']").remove();
	$("#concepto" + k + " option[value='Envio Documentos Exterior']").remove();
	$("#concepto" + k + " option[value='Viajes Nacionales']").remove();
	$("#concepto" + k + " option[value='Utiles Papeleria y Fotocopias']").remove();
	$("#concepto" + k + " option[value='Envio Mercancia']").remove();
	$("#concepto" + k + " option[value='Viajes Gerencia General']").remove();
	$("#concepto" + k + " option[value='Manten y Rep. Edificios y C']").remove();
	$("#concepto" + k + " option[value='Manten y Rep. Equipo Oficina']").remove();
	$("#concepto" + k + " option[value='Manten y Rep. Equipo Computo']").remove();
	$("#concepto" + k + " option[value='Gastos de desarrollo']").remove();
	$("#concepto" + k + " option[value='Muestras Calidad']").remove();
	$("#concepto" + k + " option[value='Tramites Legales Exterior']").remove();
	$("#concepto" + k + " option[value='Inv. Comercial']").remove();
	$("#concepto" + k + " option[value='Tramites Legales Cambio Imagen']").remove();
	
	if(campo != ""){					
        select.options[select.options.length] = new Option('Inv. Comercial', 'Inv. Comercial');										
		$("#concepto"+k).val('Inv. Comercial')
		pruebaDatos();
	}
	else{	
		for(index in myobject) {
		select.options[select.options.length] = new Option(myobject[index], index);
		pruebaDatos();
}
	
		$("#concepto"+k).val('Taxis')

	}
}

function deshabilitarUno() 
{
	let checkeado = $('#panel').prop('checked');
	if(checkeado )
	{
		document.getElementById("nopanel").disabled=true;	
		document.getElementById("empleado").disabled=true;
		document.getElementById("importadorM").disabled=true;
		document.getElementById("farm").disabled=true;
		document.getElementById("panelcom").disabled=true;	
		$('#pan1').show();

		
	}
	else
	{
		document.getElementById("nopanel").disabled=false;	
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#pan1').hide();
		$('#alertaC').hide();
	}

}
function deshabilitarDos() 
{
	let checkeado = $('#nopanel').prop('checked');
	if(checkeado )
	{
		document.getElementById("panel").disabled=true;	
		document.getElementById("empleado").disabled=true;
		document.getElementById("importadorM").disabled=true;
		document.getElementById("farm").disabled=true;
		document.getElementById("panelcom").disabled=true;	
		$('#nopaneles1').show();
		$('#nopaneles2').show();
		$('#alertaT').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#nopaneles1').hide();
		$('#nopaneles2').hide();
		$('#alertaT').hide();
	}

}

function deshabilitarTres() 
{
	let checkeado = $('#empleado').prop('checked');
	if(checkeado )
	{
		document.getElementById("panel").disabled=true;	
		document.getElementById("nopanel").disabled=true;
		document.getElementById("importadorM").disabled=true;
		document.getElementById("farm").disabled=true;
		document.getElementById("panelcom").disabled=true;	
		$('#empleados1').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#empleados1').hide();
	}

}
function deshabilitarCuatro()
{

	let checkeado = $('#importadorM').prop('checked');
	if(checkeado )
	{
		document.getElementById("panel").disabled=true;	
		document.getElementById("nopanel").disabled=true;
		document.getElementById("empleado").disabled=true;
		document.getElementById("farm").disabled=true;
		document.getElementById("panelcom").disabled=true;	
		$('#importador1').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("empleado").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#importador1').hide();
	}

}

function deshabilitarCinco()
{

	let checkeado = $('#farm').prop('checked');
	if(checkeado )
	{
		
		document.getElementById("panelcom").disabled=true;	
		document.getElementById("panel").disabled=true;	
		document.getElementById("nopanel").disabled=true;
		document.getElementById("empleado").disabled=true;
		document.getElementById("importadorM").disabled=true;
		$('#num').show();
		$('#cantidad').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#num').hide();
		$('#cantidad').hide();
	}

}

function deshabilitarSeis()
{

	let checkeado = $('#panelcom').prop('checked');
	if(checkeado )
	{
		document.getElementById("panel").disabled=true;	
		document.getElementById("nopanel").disabled=true;
		document.getElementById("empleado").disabled=true;
		document.getElementById("importadorM").disabled=true;
		document.getElementById("farm").disabled=true;
		$('#panel10').show();
				$('#pan2').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;		
		document.getElementById("farm").disabled=false;
		$('#panel10').hide();
				$('#pan2').hide();
	}

}

function darBaja()
{
	
	 
		let dato = $('#id_cabeza').val();
		
		swal({
			title: "¿Esta seguro de dar de baja a esta legalización?",
			text: "",
			icon: "warning",					
			buttons: true,
			dangerMode: true,
			}).then((result) => {
				if (result == true) {
					$.ajax({
						url:'baja.php',
						type:'POST',
						data:{dato},
						success: function (response) {

							if(response == "true")
							{
								swal("Se ha dado de baja satisfactoriamente", {
								icon: "success"
								}).then((success=>{
								window.location.href='https://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/listadoAbiertas/index.php?op=Abiertas';    
								}));
								
								
								
								
								
							}
							else
							{
								swal("Error al dar de baja!", {
								icon: "error",
								});
								setInterval("actualizar()",1000);
							}
							
						}
					});
					
				} else {
					swal("Cancelado!",{ icon:'error'});
					setInterval("actualizar()",1000);
				}
				});
		
}


</script>




<style type="text/css">
.container{padding: 8px; }
table tr th, table tr td{font-size: 1.2rem;}
.ui-front{
    z-index: 7000000000;
}

.glyphicon{font-size: 20px; }
.tabla{height:25px;}
.icono{color:red;}
.glyphicon-plus{float: right; }
a.glyphicon{text-decoration: none; }
a.glyphicon-trash{margin-left: 10px; font-size:180px;}
.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
	color: white;
}

.btn i {
    font-size: 15px;
    vertical-align: -1px;
}




@media screen and (max-width: 800px) 
{
  .input
    {
    	background-color:#00965e;
    	color:white;
    	margin-left:280px;
    	margin-bottom:10px;
    }
    
}


@media screen and (max-width: 600px) 
{
  .input
    {
    	background-color:#00965e;
    	color:white;
    	margin-left:170px;
    	margin-bottom:10px;
    }
   
}




</style>




 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
            <a href="https://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/listadolegalizacionesproceso.php?op=ABIERTAS" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         <br> 
				 <div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6"></div>
						<div class="col-md-3"><a href="#" class="btn btn-danger" onclick="darBaja()">Dar baja </a></div>
						<input type="hidden" name="dato" id="id_cabeza" value="<?php echo $users[0]['id_cabeza']; ?>">

					</div>
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
            	    <td colspan="3" align="center"><h3>Legalización de gastos</h3></td>
            	    </tr>
            	  
		
    </table>	

    <!--<form id="my-form" method="post" action="guardar.php?inserted=1" name="insertregistro" enctype="multipart/form-data">-->
    
   <form id="my-form" method="post"  name="insertregistro" enctype="multipart/form-data">
   		
	<div class="row">	
	<div class="col-md-3">
			
			<div class="form-group">
				<label for="ex2">Tipo de Legalización:</label>
				<select name="tipolegalizacion" type="text"  required="required" class="form-control form-control-lg" id="tipolegalizacion" onchange="actualizartipo()"></td>	
				<option id ="tipe" value="<?php echo $users[0]['tipolegalizacion']; ?>"><?php echo $users[0]['tipolegalizacion']; ?></option>
				<option value="Reintegro Gastos">Reintegro Gastos</option>
				<option value="Legalizacion Anticipo">Legalizacion Anticipo</option>
				<option value="Caja Menor">Caja Menor</option>
				<option value="Tarjeta de Credito">Tarjeta de Credito</option>
	</select>
			</div>
        </div>	    
	</div>     
	<div class="panel panel-default users-content">
    <div class="panel-body">
	<div class="panel" style="border:1px solid #00AB84;">            
			<div class="panel-heading text-center form-control" >Información General</div>  
			
			<td >&nbsp;</td>
			<td >&nbsp;</td>
			<div class="row">
					<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									<label for="ex2">Fecha</label>
									<input name="fechamos" type='text' required class="form-control" id="fechamos" placeholder="Fecha" min="" value = "<?php echo $users[0]['fecha']; ?>" readonly="readonly"/>
									<input name="fecha" id="fecha" type="hidden" value="<?php echo date("d/m/Y");?>" />
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									<label for="ex2">Identificación</label>
									<input name="identificacion"  id="identificacion" onKeyUp="empleado(1)"  onBlur="empleado2(1)" type="text" required="required" class="form-control"   placeholder="Identificación" value="<?php echo $users[0]['identificacion']; ?>"  disabled/>
									</div>
						
					</div>
					<div class="col-md-3">
									<div class="form-group">
									<label for="ex2">Nombre</label>
									<input name="nombre" type="text" required="required" class="form-control" id="nombre"  placeholder="Nombres" value="<?php echo $users[0]['nombre']; ?>" disabled/>
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									<label for="ex2">Cargo</label>
									<input name="cargo" type="text" required="required" class="form-control" id="cargo"  placeholder="Cargo" value="<?php echo $users[0]['cargo']; ?>" disabled/>
									</div>
					</div>
					<div class="col-md-1">
									<div class="form-group">
									<label for="ex2">Cto Cto</label>
									<input name="ctocto" type="text" required="required" class="form-control" id="ctocto" value="<?php echo $users[0]['ctocto']; ?>" disabled />
									</div>
					</div>
					
					
					
			</div>
			<div class="row">
					<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
					</div>
					<div class="col-md-3">
									<div class="form-group">
									<label for="ex2">Linea</label>
									<input name="Linea" type="text" required="required" class="form-control" id="Linea"  placeholder="Linea" value="<?php echo $users[0]['linea']; ?>" disabled/>
									</div>
					</div>
					<div class="col-md-3">
									<div class="form-group">
									<label for="ex2">Area Terapeutica</label>
									<input name="Area" type="text" required="required" class="form-control" id="Area"  placeholder="Area" value="<?php echo $users[0]['area']; ?>" disabled/>        
									</div>
					</div>
					<div class="col-md-4">
						<label for="ex2">Observaciones</label>
						<div class="input-group">
							<textarea name="txtobservaciones" rows="3" class="form-control " id="txtobservaciones" placeholder="Observaciones" onchange="actualizarObservacion()" onclick="operaciones();" ><?php echo $users[0]['observaciones']; ?></textarea>
						</div>
		</div>
				</div>
			
				
		
		<input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
                <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /></p>
				<div id="apro"></div>
				<input name="docupdate" type="hidden" id="docupdate" value="<?=$_REQUEST['documento'];?>" />
				
	</div>
	
   <div class="panel panel-default users-content" id="seleccion">
    <div class="panel-body">
	<div class="panel" style="border:1px solid #00AB84;" >            
			<div class="panel-heading text-center form-control" >Seleccion Aprobador</div>  
			
			<td >&nbsp;</td>
			<td >&nbsp;</td>
			<div class="row">
				<div class="col-md-4" id=""></div>
				<div class="col-md-6" id="apro1"><h5>El aprobador de esta legalizacion es: <strong><?php echo $apr[0]['full_name']; ?></strong><h5></div>		
				<input type="hidden" name="nombreaprobador" id="" value="<?php echo $apr[0]['u_userid']; ?>">				
			</div>
			<div class="row">
				<div class="col-md-4" id=""></div>
				<div class="col-md-6" id="apro3" ></div>				
				
			</div>			
			<div class="row">
			<div class="col-md-4" id=""></div>
			<div class="col-md-6" id="apro2"></div>			
			</div>
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
    
	   
	<div class="panel" style="border:1px solid #00AB84;">            
	<div class="panel-heading text-center form-control" >Alta información</div>                    
			<td >&nbsp;</td>
			<td >&nbsp;</td>    
			<div id="tipo" ></div> 
              <div class="row">
			  <div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
					</div>
                   <div class="col-md-2">
			    			      <label for="ex2">Fecha</label>
                                  <div class="input-group">	
								  <input type="text" class="form-control inputstl" name="fechasiguiente[]" id="dateArrival1" placeholder="Seleccionar Fecha" required>
								  </div>
					</div>                              
                                
                                
                    <div class="col-md-2">
			    			      <label for="ex2">Factura</label>
                                  <div class="input-group">			    			     
			    			      <input name="factura[]" class="form-control input-sm" id="factura1"  required="required" type="text" placeholder="Factura">
		    			          </div>
					</div>
                                

					<div class="col-md-2">
			    			      <label for="ex2">Nit</label>
                                  <div class="input-group">			    			     
			    			      <input name="nit[]" class="form-control" id="nit1" onKeyUp="valida(1)"  required="required" type="text" placeholder="NIT">
		    					  </div>
					</div>                                
                                               
                                               
                    <div class="col-md-3">
			    			      <label for="ex2">Establecimiento</label>
                                  <div class="input-group">			    			     
			    			      <input name="establecimiento[]" class="form-control input-sm" id="establecimiento1" style="text-transform:uppercase" required="required" type="text" placeholder="Establecimiento">
		    			        </div>
					</div>                                       
            </div>                    
            <div class="row"> 
					<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
					</div>     
                  <div class="col-md-2">
			    			      <label for="ex2">Ciudad</label>
                                  <div class="input-group">
			    			     
			    			      <input name="ciudad[]" id="ciudad1" onKeyUp="ciudad(1)" class="form-control" style="text-transform:uppercase" required="required" type="text" placeholder="Ciudad">
		    			        </div></div>
                                
                    <div class="col-md-2">
			    			      <label for="ex2">Codigo Inversion</label>
                                  <div class="input-group">
			    			     
			    			     <input name="cinversion[]" class="form-control input-sm" id="cinversion1" style="text-transform:uppercase" type="text" placeholder="C. Inversion" value ="" onBlur="seleccionaselect(document.getElementById('cinversion1').value,1)" >
		    			        </div></div>          
                                
                     
                    <div class="col-md-2">
			    			      <label for="ex2">Tipo de Gasto</label>
                                  <div class="input-group">
			    			     
			    			     <select name="TipoGasto[]" class="form-control input-sm" id="TipoGasto1" style="width: 180px; height:25px;"> <option value="Compras">Compras</option><option value="Otros Servicios">Otros Servicios</option><option value="Restaurante con Propina">Restaurante con Propina</option><option value="Restaurante sin Propina">Restaurante sin Propina</option><option value="Transportes Terrestres">Transportes Terrestres</option><option value="Transportes Aereos">Transportes Aereos</option><option value="Alojamiento">Alojamiento</option><option value="Tramites Legales Cambio Imagen">Tramites Legales Cambio Imagen</option> </select>
		    			        </div></div>           
                               
                               
                    <div class="col-md-3">
			    			      <label for="ex2">Concepto</label>
                                  <div class="input-group">
			    			     
			    			     <select name="concepto[]" class="form-control input-sm" id="concepto1" style="width: 180px;height:25px;"> 
                    
                </select>
		    			        </div></div>  
			</div>					
                  
            <div class="row"> 
					<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
					</div>     
                  <td><div class="col-md-5">
			    			      <label for="ex2">Descripcion</label>
                                  <div class="input-group">
			    			      
			    			       <textarea name="descripcion[]" class="form-control input-sm" id="descripcion1"   rows="3" cols="45" required></textarea>	</div></div> 
                                   
                                   
                     <div class="col-md-2">
			    			      <label for="ex2">Moneda</label>
			    			     <div class="input-group">
			    			      <select name="Moneda[]" class="form-control input-sm"  id="Moneda1" style="height:25px;"> <option value="COP">Peso Colombiano</option><option value="US">Dolares</option><option value="EUR">Euros</option> <option value="GBP">Libra esterlina</option></select> 
		    			        </div>
                                </div>
                                
                    <div class="col-md-2">
			    			      <label for="ex2">Valor</label>
                                  <div class="input-group">
                                   <span class="input-group-addon">$</span>                                                                    
                                   <input id="valor1" name="valor[]" class="form-control currency" onChange="operaciones();" type="text" required/>
									<script type="text/javascript">$("#valor1").maskMoney();</script>
                                            
		    			        </div></div>               
            </div>                      
                                  
            <div class="row">
            
					<div class="col-md-1">
									<div class="form-group">   
									</div>
					</div>
                  <div class="col-md-3">
			    			      <label for="ex2">Soporte</label>
                                  <div class="input-group">			    			     
			    			      <input name="file[]" required="required" type="file" id="file1">
		    			        </div></div>
                  <div class="col-md-3" id="info1" >
				<label for="ex2">Seleccione el anticipo por Proveedor: </label>	
				<select id="anticipoP" name="anticipoP1" class="form-control form-control-lg" disabled>
				<option value=''>Seleccione una opción</option>	
					

				</select>	
						
				</div>			
				<div class="col-md-2"></div>
				<div class="col-md-4" id="info">
				<label for="ex2">Seleccione el anticipo por Empleado: </label>	
				<select id="anticipoE" name="anticipoE1" class="form-control form-control-lg" disabled>
				<option value=''>Seleccione una opción</option>	
					

				</select>	
				</div>								   
            </div>
			<td >&nbsp;</td>
			<td >&nbsp;</td>				
	</div>
</div>
			<td >&nbsp;</td>
			<td >&nbsp;</td> 
             <div class="row">
			 	<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
				</div>   
				<input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>" />
				<input type="hidden" name="ultimoinserted" id="ultimoinserted" value="" />
				<input type="hidden" id="lgcabeza" value="<?= $users[0]['id_cabeza']; ?>">
				<div class="col-md-3">
					<input name="input" type="submit" id="buttonsave" class="btn input" style="background-color:#00AB84; color:white;" value="Añadir" /> 
				</div>
			</div>
           
			<td >&nbsp;</td><td >&nbsp;</td>
			<div class="table-responsive">  
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
              
                <td colspan="2"><div id="resultado1">
                 
                </div></td>
              </tr>
              <tr>
                <td><div id="resultadotemporal">
    
						 
															<table class="table table-striped table-bordered">
								
								<tbody id="userData">
									<tr></tr>
								</tbody>
								<thead>
									<tr>
										<th rowspan="2">No</th>									
										<th rowspan="2" valign="bottom"><div align="center">Fecha</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Factura</div></th>
										<th rowspan="2" valign="center" ><div align="center">NIT</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Establecimiento </div></th>
										<th rowspan="2" valign="bottom"><div align="center">Codigo de inversión </div></th>
										<th rowspan="2" valign="bottom"><div align="center">Tipo Gasto</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Valor</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Adjunto</div></th>																				
										<th rowspan="2" valign="bottom"><div align="center">Eliminar</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Asistentes</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Ver</div></th>
										
									</tr>
									<tr></tr>
								</thead>
								<tbody id="userData2">
									<?php $sumaneto = 0;
									if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
									<tr>
									<td><?php echo $user['id'];?></td>
									
										<td align="center"><?php echo $user['fecfact']; ?></td>
										<td align="center">
											<?=($user['factura']) ?></td>
										<td align="center">
											<?=($user['nit']) ?></td>
											
										<td align="center">
											<?=$user['establecimiento']; ?></td>
										<td align="center">
											<?=$user['cinversion']; ?></td>	
										<td align="center">
											<?=$user['tipogasto']; ?></td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($user['valor'],2); ?></td>
										<td align="center">
											<?php 
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
											?>
										</td>
										
										<td align="center">
											<a class="btn btn-danger" href="eliminadetallef.php?op=LISTADO LEGALIZACIONES&amp;documento=<?=$user['identificador']?>&&id=<?=$user['id']?> "> <i class="glyphicon glyphicon-trash"></i></a>
										</td>
										<?php 
										if($user['tipoCodigo'] == "SI")
													{
										?>
										
										<td align="center">
										
										<?php

										
										 

												$consulta="SELECT Cliente FROM medicos WHERE cedula_usuario = ". $cedulaSesion;
												$sql = mysqli_query($mysqli, $consulta);
													
												$array = array();
													while($row = mysqli_fetch_array($sql))
													{
														$equipo = utf8_encode($row['Cliente']);														
														array_push($array, $equipo);
													}


											?> 	
										<?php 
										$usuario = $user['identificador'];
											echo "<input type='hidden' id='$usuario' value='$usuario'>"; 
											
										?>
											<a href="" class="btn btn-primary tabla monohp" data-toggle="modal" data-id="<?= $user['identificador'];?>" data-target="#largeModal" ><i class="glyphicon glyphicon-plus"></i></a>
										
										
										</td>	
												<?php

													}
											?>	
										
										
										<?php
										$identificadorDet = $user['identificador'];		
										$sqls = "SELECT identificadordet from asistencia where identificadordet = ". $identificadorDet;					
										$query = mysqli_query($mysqli, $sqls);
										$numero = mysqli_num_rows($query);
										
										$asistencia = $user['asistencia'];							

										if($asistencia != "" && $numero > 0)
										{	
										
										echo "<td align='center'> <a href='#' class='btn btn-sm tabla' data-toggle='modal' data-id='$usuario' data-target='#largeModal1' style='background-color:#00AB84; justify-content:center;' ><i class='glyphicon glyphicon-search icono' style='color:white;'></i></a> </td>";
										
										
										}										
										?>
										
										
										
									</tr>
									
									
									<?php endforeach; else: ?>
									<tr>
										<td colspan="7">No existen documentos para mostrar......</td>
									</tr>
									<?php endif; ?>
									
									
                               <tr>
							   <?php
							   $cabeza = $users[0]['id_cabeza'];
							   $sql = "SELECT id, asistencia, tipoCodigo FROM `lg_det_cabeza` WHERE id = '$cabeza'  and asistencia IS NULL and tipoCodigo = 'SI'";
									
								$query = mysqli_query($mysqli,$sql);
								
								while($row = mysqli_fetch_assoc($query))
								{
									$ids =  $row['id'];		
														
								}
							   foreach ($detalle as $key) 
							   {
									$identificadordetlg = $key['identificador'];   
									
									
									$sqla = "SELECT * FROM `asistencia` WHERE identificadorlg ='$identificadordetlg')";									
									
									$querys = mysqli_query($mysqli,$sqla);
									$resultado = mysqli_num_rows($querys);
								    
								}	
								if($resultado == 0 && $ids == $detalle[0]['id'] )
								{
							   
									
								
								?>
									<td>
										<a class="btn"style="background-color:#00AB84; color:white;" href="finalizadoc.php?op=LISTADO LEGALIZACIONES&amp;documento=<?=$user['id']?>&aprobador=<?=$users[0]['aprobador']?>&us=<?=$users[0]['identificacion']?>" role="button" disabled>Finalizar </a>
									</td>
							<?php	
								}
								else {
									
							?>		
									<td>
										<a class="btn"style="background-color:#00AB84; color:white;" href="finalizadoc.php?op=LISTADO LEGALIZACIONES&amp;documento=<?=$user['id']?>&aprobador=<?=$users[0]['aprobador']?>&us=<?=$users[0]['identificacion']?>" role="button">Finalizar </a>
										</td>
							
							<?php
									}
									
								?>
                              </tr>
								</tbody>
								
								<tbody>

								</tbody>
								
									
									
								</table>
							
								</div> 
                </div>
								</td>
              </tr>
						
              

              
            </table>
            
    
            
            
		     
          </form> 
            
            
         
            
                      
        </div>
</div>
</div>                 
 
<input type="hidden" class="btn btn-primary" data-toggle="modal" data-target="#largeModal">
										
										
										<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Módulo asistencia</h4>
														<button type="button" class="close" data-dismiss="modal"></button>
													</div>
													<div class="modal-body" >
														<div class="row">
															<div class="col-md-4">
																<input type="checkbox" name="panel" id="panel" onChange="deshabilitarUno()">
																<input type="hidden" id="idhp" value="">
																<h5>Panel</h5>						

															</div>
																														
															<div class="col-md-5 ui-front" >
																<input type="text" name="paneles"  class="form-control" id="pan1" placeholder="Nombre del médico">
																<div id="alertaC"></div>
																<input type="hidden" name="cedulapanel1" id="panel1">
																<input type="hidden" name="" id="panel2">
																<input type="hidden" name="" id="panel3">
															</div>

														<!-- Inicio Panel General -->
													
															<div class="col-md-4">
																<input type="checkbox" name="panelCompleto" id="panelcom" onChange="deshabilitarSeis()">
																
																<h5>Panel Megalabs</h5>						

															</div>
																														
															<div class="col-md-3 ui-front" >
																<input type="text" name="paneles"  class="form-control" id="pan2" placeholder="Cédula del médico" onkeyup="buscarCC()">
																<div id="alertaC"></div>
																
																<input type="hidden" name="" id="panel4">
																<input type="hidden" name="" id="panel5">
															</div>
															<div class="col-md-4">
																	
																	
															<input type="text" name="cedulapanel2" id="panel10" class="form-control" placeholder="Nombre del médico">
																	
															</div>
														<!-- Fin Panel General -->


														<div class="col-md-4">
															<input type="checkbox" name="nopanel" id="nopanel" onClick="deshabilitarDos()" >
															<h5>No panel</h5>
														</div>
															<div class="col-md-4">
																	
															<input type="text" name="nopaneles2" class="form-control"  id="nopaneles2" placeholder="Cédula" onkeyup="prueba2()">
															<div id="alertaT"></div>
															</div>
															<div class="col-md-3">
																	
																	
																	<input type="text" name="nopaneles" class="form-control"  id="nopaneles1" placeholder="Nombre Médico">
																	
															</div>
															
															<?php

										
										 

																$consulta="SELECT nombres FROM empleadolg";
																$sql = mysqli_query($mysqli, $consulta);
																	
																$arrayempleado = array();
																	while($row = mysqli_fetch_array($sql))
																	{
																		$nombreempleado = utf8_encode($row['nombres']);														
																		array_push($arrayempleado, $nombreempleado);
																	}


																?> 	
														
														<div class="col-md-4">
															<input type="checkbox" name="empleado" id="empleado" onClick="deshabilitarTres()" >													
															<h5>Empleado</h5>																										
														</div>
															<div class="col-md-4">
																	<input type="text" name="empleados" class="form-control"  id="empleados1" placeholder="Nombre Empleado">
																	<input type="hidden" name="cedulaempleado" id="panel45">
																	
															</div>
															
														<!-- inicio codigo  Importador -->
														
															<div class="col-md-4">
																																									
															</div>
																<div class="col-md-4">
																		
																		<input type="checkbox" name="importador" id="importadorM" onClick="deshabilitarCuatro()" >													
																		<h5>Importador</h5>	
																</div>
																<div class="col-md-4">
																<button id="importador1" class="btn btn-azure" onclick="importador(<?=$users[0]['id_cabeza'];?>)">Importador</button>
																<input id="ideprueba" type="hidden">
																
																</div>
																<div class="col-md-1">																																								
															</div>
														<!-- Fin codigo  importador -->	

														<!-- inicio codigo  farmacias -->

															<div class="col-md-4">
															<input type="checkbox" name="farmacia" id="farm" onClick="deshabilitarCinco()" >													
															<h5>Farmacias</h5>																										
														</div>
															<div class="col-md-2">
																	<h5 id="cantidad">Cantidad:</h5>
																	<input type="number" name="numero" class="form-control form-control-sm"  id="num" placeholder="Cantidad">
															</div>				
														<!-- fin codigo  farmacias -->
												
											</div>

											<!-- Modal footer -->
											<div class="modal-footer">												
												<button type="submit" class="btn btn-success" data-dismiss="modal" onclick="registrar()">Registrar</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
											</div>
											
											</div>
											</div>
										</div>
										</div> 
 
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
															<div class="col-sm-1"><h5><strong>Eliminar</strong></h5></div>
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


<script>
$(document).ready(function () {

	
  var items = <?= json_encode($array)?>
  
  $("#pan1").autocomplete({
		 source: items,
		 select: function (event, item) {
			 var params = { equipo:item.item.value};
			 $.get("getdatos2.php", params, function (response) {
				 var json = JSON.parse(response);
				 if(json.status == 200)
				 {						
						$('#panel1').val(json.id_cliente);
						//if(json.transferenciaValor == "Si")
						//{
						//	$('#alertaC').html('<div class="alert alert-success" role="alert"><h5>Tiene transferencia de valor</h5></div>');
						//}
						//else
						//{
							//$('#alertaC').html('<div class="alert alert-danger" role="alert"><h5>No tiene transferencia de valor</h5></div>');
						//}
				 }
				 else
				 {

					$('#alertaC').html('<h5>No existe.</h5>');
				 }
			 });
		 },
		 minLength: 2
	});
	
	
  
	


	var opciones = <?= json_encode($arrayempleado)?>

	$("#empleados1").autocomplete({
		 source: opciones,
		 minLength: 2,
		 select:function (event, item) {
			 var params = { nombreempleado:item.item.value};
			 $.get("getdatos3.php", params, function (response) {
				 var json = JSON.parse(response);
				 if(json.status == 200)
				 {						
						$('#panel45').val(json.cedula);
						console.log(json.cedula);
				 }
				 else
				 {

				 }
			 });
		 }
  });


});

$(".monohp").click(function(){
	let id = $(this).data('id');
	$(".modal-body #idhp").val(id);
	$(".modal-body #ideprueba").val(id);
	
})

$(".tabla").click(function(){
	let ide = $(this).data('id');	
	$(".modal-body1 #idhp").val(ide);
	let lgcabeza = $('#lgcabeza').val();
	$.ajax({
		 type: 'POST',
		 url: 'traerAsistentes.php',
		 data:{ide, lgcabeza},
		 success:function(r)
			{
				let json = JSON.parse(r);
				console.log(json);
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
					<div class='col-sm-1'><a href="#" class="btn btn-danger tabla" onclick="eliminarAsistentes(${dato.id_asistencia}, ${dato.consecutivo})"><i class="glyphicon glyphicon-trash"></i></a></div>
					</div>`;
 				});
				
				$('#columna').html(template);
				
			}
	});



})

function eliminarAsistentes(asistencia, consecutivo)
{	

	swal({
  title: "Estas seguro ?",
  text: "se removera el asistente",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    $.ajax({
		url:'eliminarAsistentes.php',
		type:'POST',
		data:{asistencia, consecutivo},
		success: function (response)
		{
			if(response == "true")
			{
				swal("Bien", {
      			icon: "success",
    		});
				setInterval("actualizar()",1000);
			}
			else
			{
				swal("Mals :(",{
					icon:"error",
				});	
			}
		}
	});
  } else {
    swal("Cancelado :(",{
					icon:"error",
				});	
  }
});
	
}

function registrar()
{
	let lgcabeza = $('#lgcabeza').val();
	let id = $(".modal-body #idhp").val();
	let panel = $('#pan1').val();
	let cedulapanel = $('#panel1').val();
	let nopanel = $('#nopaneles1').val();
	let nopanelcedula = $('#nopaneles2').val();
	let empleado = $('#empleados1').val();	
	let cedulaempleado = $('#panel45').val();
	let cantidad = $('#num').val();
	let panel2 = $('#pan2').val();
	let panel10 = $('#panel10').val();
	let primercheck;
	let segundocheck;
	let tercercheck;
	let cuartocheck;
	let quintocheck;
	let sextocheck;
	if($('#panel').prop('checked'))
	{
		primercheck = "panel";
		
	}
	else
	{
		primercheck = " ";
		
	}
	if($('#nopanel').prop('checked'))
	{
		segundocheck = "nopanel";
		
	}
	else
	{
		segundocheck = " ";
		
	}
  if($('#empleado').prop('checked'))
	{
		tercercheck = "empleado";
		
	}
	else
	{
		tercercheck = " ";
		
	}
	if($('#importadorM').prop('checked'))
	{
		cuartocheck = "importado";
	}
	else
	{
		cuartocheck = "";
	}
	if($('#farm').prop('checked'))
	{
		quintocheck = "Farmacia";
	}
	else
	{
		quintocheck = "";
	}
	if($('#panelcom').prop('checked'))
	{
	    sextocheck = "PanelM";
	}
	else
	{
	    sextocheck = "";
	}
	
	$.ajax({
			type:"POST",
			url: "insertar.php",
			data:{lgcabeza, id, cantidad, panel, nopanel, nopanelcedula, empleado, primercheck, segundocheck, tercercheck, quintocheck,sextocheck, cedulapanel, cedulaempleado,panel2, panel10},
			success:function(r)
			{
				if(r != null)
				{
					swal ( "Agregado correctamente" ,  "Se agrego la información correctamente" ,  "success");
					setInterval("actualizar()",1000);
					$('#panel1').val('');
                	$('#nopaneles1').val('');
                	$('#nopaneles2').val('');
                	$('#empleados1').val('');	
                	$('#panel45').val('');
                	$('#num').val('');
                	$('#pan2').val('');
                	$('#panel10').val('');
				}
				else
				{
					swal ( "Fallo en el server" ,  "No se realizó la inserción." ,  "error");
					
				}
			}
	});
 
}


function buscarCC() 
{
		
	
	$("#pan2").autocomplete({
		source: 'buscarCedulam.php', 
		response: function(e, ui){	
			ui.content.map(i => i.label = i.cedula);			
		},
		minLength: 2,		
		select: function(event, ui) {
			
			event.preventDefault();		
			
			$('#panel10').val(ui.item.nombremedico);
			$('#pan2').val(ui.item.cedula);		 
		}
	});
}


function prueba2()
{
	let cedulanopanel = $('#nopaneles2').val();
	$.ajax({
		url:'cedulaConsentimiento.php',
		data:{cedulanopanel},
		type:'POST',
		success: function (response)
		{
				
				let json = JSON.parse(response);
				let template = '';
					json.forEach(dato => {
					template += `${dato.transferenciaValor}`
					

				});
				if(template != '')
				{
					
					$('#alertaT').html("<div class='alert alert-success' role='alert'><h5>"+template+"</h5></div>");
				}
				else
				{
					$('#alertaT').html("<div class='alert alert-danger' role='alert'><h5>No tiene transferencia de valor para este medico</h5></div>");
					
				}
		}

	});
}

// function importar()
// {
// 	$.ajax({
// 			type:"POST",
// 			url: "pruebas.php",
// 			data:{lgcabeza, id, nombre, },
// 			success:function(r)
// 			{
// 				if(r)
// 				{
// 					alert("Agregado con exito");
					
// 				}
// 				else
// 				{
// 					alert("Fallo el server");
// 				}
// 			}
// 	});
// }
	function pruebaDatos()
	{
		
				let codigo = $('#cinversion1').val();
					
					let dato = new String();

					dato = codigo;

					
					 var conversion = dato.substring(8,10);

					

				 $.ajax({
				 			type:'POST',
				 			url:'transferencia.php',
				 			data:{conversion},					
				 			success: function (response)
				 			{
				 				let json = JSON.parse(response);
				 				let template = '';
								 json.forEach(dato => {
									template += `					
									<input name='tipoCodigo' type='hidden' value="${dato.tipo}"> <input name='codigoTipo' type='hidden'  value='${dato.codigo}'>`
						
					
									});
									$('#tipo').html(template);
				 			}

				 });
	
	}
function importador(id_cabeza)
{
    let ide = $('#ideprueba').val();
    window.open("importadorAsistentes.php?id_cab="+id_cabeza+"&identificador="+ide);
    
}
</script>
<?php
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


?>
		
				
