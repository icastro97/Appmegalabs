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

$modulo = 'Legalizaciones';




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

$condition['where'] = array('cedulaSesion'=> $cedulaSesion,); 
$usuario = $db->getRows('matrizaprobacion',$condition);


if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>

<?php require('../../cabeza.php'); 
$embebida = "";
if(isset($_REQUEST['url'])){
	$embebida = $_REQUEST['url'];	
}


if(!isset($_SESSION["session_username"])) {	
  header("location:../../seguridad/index.php");  
} 
else {?>
<!---->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script type="text/javascript" src="assets/popcalendar.js"></script>
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


<!--AJAX-->
        <script>
            $(document).ready(function() {
                <!--#my-form grabs the form id-->
                $("#valida").hide();	
				$('#seleccion').hide();
				$('#aprobadores').hide();
                $("#info").hide();
				$("#info1").hide();
                $("#my-form").submit(function(e) {
                
                
                	var isChecked1 = document.getElementById('cambioapr').checked;
					if(isChecked1)
					{    
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
									let aprobador = document.getElementById("listaapr").value;
									document.getElementById("ultimoinserted").value= strMessage; 									
									$("#seleccion").show();	
									$("#apro3").html('<h5>El aprobador de esta legalizacion es:<strong><div id="apr"></div></strong></h5>');
									$("#apr").html(aprobador);
									$("#apro1").hide();	
									$("#aprobadores").hide();	
									$("#checkaprobador").hide();
									$("#codedos").val('');	
									$("#code").val('');	
									$("#codesdos").val('');	
									$("#codes").val('');
									$("#valida").hide();	
									$("#listaapr").hide();	
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
									document.getElementById('cambioapr').checked;
									document.getElementById("TipoLegalizacion").disabled=true;
									document.getElementById("identificacion").disabled=true;									
									document.getElementById("buttonsave").disabled = false;
									
									traerDatos();
									$("#resultado").load('ajax-grid-lgi.php',{'varidentificadounico': strMessage});

							}
							});
					}
					else
					{
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
									$("#seleccion").show();
									$("#aprobadores").hide();	
									$("#valida").hide();	
									$("#listaapr").val('');
									$("#codedos").val('');	
									$("#code").val('');	
									$("#codesdos").val('');	
									$("#codes").val('');
									$('#checkaprobador').hide();
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
									document.getElementById("buttonsave").disabled = false;
									document.getElementById("cambioapr").checked = false;
									
									traerDatos();
									$("#resultado").load('ajax-grid-lgi.php',{'varidentificadounico': strMessage});

							}
							});
					    
					}
					
					
					
					
					
                });
            });
        </script>

<script type="text/javascript">


function eliminarsolicitud2(idempleado,idkey){
	//donde se mostrará el resultado de la eliminacion
	divResultado = document.getElementById('resultado');
	
	//usaremos un cuadro de confirmacion	
	var eliminar = confirm("De verdad desea eliminar la factura " + idkey + " este dato?")
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
				 $("#resultado").load('ajax-grid-lgi.php',{'varidentificadounico': idempleado});
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
					$("#info1").hide();				
					cambio();
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
		
	
	
function empleado() {
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
					$("#info").show();
					$("#seleccion").show();					
					cambio();
					dato();
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
		$("#info").show();
		cambio();
		dato();
		$("#txtobservaciones").focus();

    }).fail( function() {

    alert( 'Error!!, Identificacion ' + x + ' no encontrada ' );	
	$("#identificacion").val('');
	$("#identificacion").focus();

});
  });
};



$(function () {
	
	$('#identificacion').blur(function() {
		if($('#identificacion').val())
		{
			let identificacion = $('#identificacion').val();
			$.ajax({
				url:'info.php',
				type: 'POST',
				data: {identificacion},
				success: function (response) {
					let datos = JSON.parse(response);
					let template = '<option value=" ">Anticipo emitido por Axapta</option>	';
						datos.forEach(dato => {
						template += `					
						<option value="${dato.consecutivo}">${dato.consecutivo}, ${dato.descripcion}, ${dato.moneda}, $${dato.monto}, $${dato.total}</option>`
						
					
					});

					if(template === "")
					{
						document.getElementById("anticipoE").length=0;
						document.getElementById("anticipoE").disabled = true;
						
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
	})
	 
 });
	

</script>


<script>



 $(function () {
	
	$('#nit1').keyup(function() {
		if($('#nit1').val())
		{
			let nit = $('#nit1').val();
			let sesion = $('#useridl').val();
			$.ajax({
				url:'info2.php',
				type: 'POST',
				data: {nit, sesion},
				success: function (response) {
					let infor = JSON.parse(response);
					let template = '';
						infor.forEach(dato => {
						template += `					
						<option value="${dato.consecutivo}">${dato.consecutivo}, ${dato.descripcion}, ${dato.moneda}, ${dato.monto}, $${dato.total}</option>`
						
					
					});

					if(template === "")
					{
						document.getElementById("anticipoP").length=0;
						document.getElementById("anticipoP").disabled = true;
						
					}
					else
					{
						document.getElementById("anticipoP").disabled = false;
						$('#anticipoP').html(template);	
					}
					
				}
			})
		}
		else
		{
			
			$('#info1').hide();
		}
	})
	 
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
					let template = '';
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
						template += `<h5>El aprobador de esta legalizacion es: <strong>${dato.full_name}</strong><h5> <input type="hidden" name="nombreaprobador" id="aprobador" value="${dato.u_userid}">  <input type="hidden" name="cedulaAprobador" id="cedulaAprobador" value="${dato.cedulaAprobador}">`
						
					
					});
					
					$('#apro1').html(template);	
					$('#apro2').html("<div id='checkaprobador'><h5>Cambiar aprobador: <input type='hidden'><input type='checkbox' id='cambioapr' name='cambioaprobador' onchange='check1()'></h5></div> <br>");	
								
				}
			})	
}


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

function check1()
	{
		var resultado = confirm("¿Estas seguro que desea cambiar el aprobador de esta legalización?");
		
		if(resultado == true)
		{
			var isChecked1 = document.getElementById('cambioapr').checked;
			if(isChecked1)
			{
				$('#aprobadores').show(); 
				let campo = $('#listaapr').val();
				if(campo == '')
				{
				    document.getElementById("buttonsave").disabled=true;
				}
				else
				{
				    document.getElementById("buttonsave").disabled=false;
				}
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


	
function cambio()
		{			
			if(document.getElementById("TipoLegalizacion").value === "Legalizacion Anticipo")
			{ 
			  	document.getElementById("anticipoE").disabled=false;	
				document.getElementById("anticipoP").disabled=false;	
				
				$('#info').show();																					 				   										
				$('#info1').show();
			}
			else
			{
				$('#info').hide();	
				$('#info1').hide();	
				document.getElementById("anticipoE").disabled=true;	
				document.getElementById("anticipoP").disabled=true;	
			}
		}				

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
		'Manten y Rep. Vehiculos':'Manten y Rep. Vehiculos',
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
	$("#concepto" + k + " option[value='Manten y Rep. Vehiculos']").remove();
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

function pruebaDatos()
	{
		
				let codigo = $('#cinversion1').val();
					
					let dato = new String();

					dato = codigo;

					
					 var conversion = dato.substring(8,10);

				if(conversion != "")	
				{
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
									<input name='tipoCodigo' type='hidden' id='codes' value="${dato.tipo}"> <input name='codigoTipo' id='codesdos' type='hidden'  value='${dato.codigo}'>`
						
					
									});
									
										$('#tipo').html(template);
									
				 			}

				 });
				}
				else
				{
					$('#codes').val('');
					$('#codesdos').val('');
					$('#code').val('');
					$('#codedos').val('');
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
/* #60B983- color que tenia  */
/* #5FBA6C- opción1 */
/* #00965e - Pantone 340 C */
/* #43B02A - Pantone 361 C */
/* #00AB84 - Pantone GreenC */
.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
    color: white;
}
.input
{
	background-color:#00965e;
	color:white;
	margin-left:20px;
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
				<select class="form-control form-control-lg" name="TipoLegalizacion" id= "TipoLegalizacion" onchange="cambio();" style="height:32px;" required>
				<option value="">Seleccione una opción..</option>
				<option value="Reintegro Gastos">Reintegro Gastos</option>
				<option value="Legalizacion Anticipo">Legalización Anticipo</option>
				<option value="Caja Menor">Caja Menor</option>
				<option value="Tarjeta de Credito">Tarjeta de Crédito</option>
				</select>
					
			</div>
        </div>	    
	</div>     
	<div class="panel panel-default users-content">
    <div class="panel-body">
	<div class="panel" style="border:1px solid #00AB84;" >            
			<div class="panel-heading text-center form-control" >Información General</div>  
			
			<td >&nbsp;</td>
			<td >&nbsp;</td>
			<div class="row">
					<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control" />        
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									<label for="ex2">Fecha</label>
									<input name="fechamos" type='text' required class="form-control" id="fechamos" placeholder="Fecha" min="" value = "<?php echo date("d/m/Y");?>" readonly="readonly"/>
									<input name="fecha" id="fecha" type="hidden" value="<?php echo date("d/m/Y");?>" />
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									<label for="ex2">Identificación</label>
									<input name="identificacion" onBlur="empleado2(1)"  onKeyUp="empleado()" type="number" required="required" class="form-control mb-2 mr-sm-2 mb-sm-0" id="identificacion"  placeholder="Identificacion" autocomplete="off"/>
									</div>
						
					</div>
					<div class="col-md-3">
									<div class="form-group">
									<label for="ex2">Nombre</label>
									<input name="nombre" type="text" required="required" class="form-control" id="nombre"  placeholder="Nombres" value="" autocomplete="off"/>
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									<label for="ex2">Cargo</label>
									<input name="cargo" type="text" required="required" class="form-control" id="cargo"  placeholder="Cargo" autocomplete="off"/>
									</div>
					</div>
					<div class="col-md-1">
									<div class="form-group">
									<label for="ex2">Cto Cto</label>
									<input name="ctocto" type="text" required="required" class="form-control" id="ctocto"  autocomplete="off"/>
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
									<input name="Linea" type="text" required="required" class="form-control" id="Linea"  placeholder="Linea" autocomplete="off"/>
									</div>
					</div>
					<div class="col-md-3">
									<div class="form-group">
									<label for="ex2">Area Terapeutica</label>
									<input name="Area" type="text" required="required" class="form-control" id="Area"  placeholder="Area" autocomplete="off"/>        
									</div>
					</div>
					<div class="col-md-4">
						<label for="ex2">Observaciones</label>
						<div class="input-group">
							<textarea name="txtobservaciones" rows="3" class="form-control " id="txtobservaciones" placeholder="Observaciones" onclick="operaciones();" required autocomplete="off"></textarea>
						</div>
		</div>
				</div>
			
				
		
		<input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
		<div id="apro"></div>
                <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /></p>
	</div>
   
    <div class="panel panel-default users-content" id="seleccion">
    <div class="panel-body">
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
								  <input type="text" class="form-control inputstl" name="fechasiguiente[]" id="dateArrival1" placeholder="Seleccionar Fecha" required autocomplete="off">
								  </div>
					</div>                              
                                
                                
                    <div class="col-md-2">
			    			      <label for="ex2">Factura</label>
                                  <div class="input-group">			    			     
			    			      <input name="factura[]" class="form-control input-sm" id="factura1"  required="required" type="text" placeholder="Factura" autocomplete="off">
		    			          </div>
					</div>
                                

					<div class="col-md-2">
			    			      <label for="ex2">Nit</label>
                                  <div class="input-group">			    			     
			    			      <input name="nit[]" class="form-control" id="nit1" onKeyUp="valida(1)"  required="required" type="text" placeholder="NIT" autocomplete="off">
		    					  </div>
					</div>                                
                                               
                                               
                    <div class="col-md-3">
			    			      <label for="ex2">Establecimiento</label>
                                  <div class="input-group">			    			     
			    			      <input name="establecimiento[]" class="form-control input-sm" id="establecimiento1" style="text-transform:uppercase" required="required" type="text" placeholder="Establecimiento" autocomplete="off">
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
			    			     
			    			      <input name="ciudad[]" id="ciudad1" onKeyUp="ciudad(1)" class="form-control" style="text-transform:uppercase" required="required" type="text" placeholder="Ciudad" autocomplete="off">
		    			        </div></div>
                                
                    <div class="col-md-2">
			    			      <label for="ex2">Codigo Inversion</label>
                                  <div class="input-group">
			    			     
			    			     <input name="cinversion[]" class="form-control input-sm" id="cinversion1" style="text-transform:uppercase" type="text" placeholder="C. Inversion" value ="" onBlur="seleccionaselect(document.getElementById('cinversion1').value,1)" autocomplete="off">
		    			        </div></div>          
                                
                     
                    <div class="col-md-2">
			    			      <label for="ex2">Tipo de Gasto</label>
                                  <div class="input-group">
			    			     
			    			     <select name="TipoGasto[]" class="form-control input-sm" id="TipoGasto1" style="width: 180px;height:25px;"required><option value="Compras" autocomplete="off">Compras</option><option value="Otros Servicios">Otros Servicios</option><option value="Restaurante con Propina">Restaurante con Propina</option><option value="Restaurante sin Propina">Restaurante sin Propina</option><option value="Transportes Terrestres">Transportes Terrestres</option><option value="Transportes Aereos">Transportes Aereos</option><option value="Alojamiento">Alojamiento</option> <option value="Tramites Legales Cambio Imagen">Tramites Legales Cambio Imagen</option></select>
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
			    			      
			    			       <textarea name="descripcion[]" class="form-control input-sm" id="descripcion1"  rows="3" cols="45" required autocomplete="off"></textarea>	</div></div> 
                                   
                                   
                    <div class="col-md-3">
			    			      <label for="ex2">Moneda</label>
                                  <div class="input-group">
			    			     
			    			      <select name="Moneda[]" class="form-control input-sm" id="Moneda1" style="height:25px;"> <option value="COP">Peso Colombiano</option><option value="US">Dolares</option><option value="EUR">Euros</option> <option value="GBP">Libra esterlina</option></select> 
		    			        </div></div> 
                                
                              
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
									<input  type="hidden" name="modulo"  class="form-control" value="<?=$modulo?>"/>        
									</div>
					</div>
                  <div class="col-md-3">
			    			      <label for="ex2">Soporte</label>
                                  <div class="input-group">			    			     
			    			      <input name="file[]" required="required" type="file" id="file1">
		    			        </div>
		    			        </div>
		    	<div class="col-md-1"></div>		        
		    	<div class="col-md-3" id="info1" >
		    	    <br>
				<label for="ex2">Seleccione el anticipo por Proveedor: </label>	
				<select id="anticipoP" name="anticipoP1" class="form-control form-control-lg" disabled>
				<option value=''>Seleccione una opción</option>	
					

				</select>	
						
				</div>			
				
				<div class="col-md-3" id="info">
				    <br>
				<label for="ex2">Seleccione el anticipo por Empleado: </label>	
				<select id="anticipoE" name="anticipoE1" class="form-control form-control-lg" disabled style="height:32px;">
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
				
						
				
					
					<input name="input" type="submit" id="buttonsave" class="btn input" value="Añadir" /> 
				
				<br>
				<br>
				
			</div>
           
			<div class="table-responsive table-bordered">  
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
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



		
				
