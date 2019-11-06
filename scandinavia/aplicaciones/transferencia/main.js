$(document).ready(function() {
	$('#cumple').hide();
	$('#nocumple').hide();
	$('#aprobar').hide();
	$('#cosa1').hide();
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
	$('#panelg').hide();
	$('#val').hide();
	$('#val1').hide();
	$('#val2').hide();
	$('#val3').hide();
	$('val4').hide();
	listadoDescripciones();
	listadoDescripciones3();
	listadoDescripciones4();
	
    
    $("#my-form").submit(function(e) {
        e.preventDefault();
        $.ajax( {
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
                $("#buttonsave").hide();
                
                $("#resultadotemporal").hide();
                $("#resultado1").load('ajax-grid-lgi.php',{'varidentificadounico': strMessage});
                
                 
                 

            }
        });
    });

});

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
     $("#resultado1").load('ajax-grid-lgi.php',{'varidentificadounico': idempleado});
}
}
//como hacemos uso del metodo GET
//colocamos null
ajax.send(null)
}
}

 function actualizar(){location.reload(true);}
//Función para actualizar cada 4 segundos(4000 milisegundos)


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




function date()
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
prueba2();	
validaApr();
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
        prueba2();
    }).fail(function (data) {
        
        $('#listaapr2').val('');
        $("#listaapr1").val('');
        prueba2();
    })
    

});

};


function prueba2() {



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
				swal ( "Cambio aprobador" ,  "Se realizó el cambio del aprobador correctamente." ,  "success").then((success)=>{actualizar();});		
				
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
    
        $('#s').datepicker({
            dateFormat : 'dd/mm/yy',
                changeMonth : true,
                changeYear : true,
                yearRange: '-100y:c+nn',
                maxDate: '0d' 
    });
    });     

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
	if(campo != ""){					
        select.options[select.options.length] = new Option('Inv. Comercial', 'Inv. Comercial');										
		$("#concepto"+k).val('Inv. Comercial');
		pruebaDatos();
	}
	else{	
		for(index in myobject) {
		select.options[select.options.length] = new Option(myobject[index], index);
}
	
		$("#concepto"+k).val('Taxis')

	}
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
		$('#val').show();
	}
	else
	{
		document.getElementById("nopanel").disabled=false;	
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;
		$('#val').hide();
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
		$('#val2').show();
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
		$('#val2').hide();
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
		$('#val3').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#empleados1').hide();
		$('#val3').hide();
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
				$('#val1').show();
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
		$('#val1').hide();
		
		
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
								});
								window.location.href='http://localhost:82/scandinavia/aplicaciones/legalizaciones/listadolegalizacionesproceso.php?op=Abiertas';
								
								
								
								
							}
							else
							{
								swal("Error al dar de baja!", {
								icon: "Error",
								}).then((success)=>{
									actualizar();
								});
								
							}
							
						}
					});
					
				} else {
					swal("Cancelado!",{ icon:'error'}).then((success)=>{
						actualizar();
					});;
					
				}
				});
		
}


function validaApr()
{
     let campo = $('#listaapr').val();
    if(campo == '')
    {
        
    }
    else
    {
        $('#valida').html("<div class='alert alert-danger'><h5>Ingrese un aprobador válido</h5></div>");
    }
}

function enviar()
{
   
    	 let documento = $('#docupdate').val();
    	 let id = $('#aproba').val();
    	$.ajax({
    		url:'cambioEstado.php',
    		data:{documento, id},
    		type:'POST',
    		success:function (response) 
    		{
    		    if(response == "OK")
    		    {
    		        swal('INFORMACION','Se realizo la distribucion correctamente.','success').then((success)=>{
    					window.location = "https://appmegalabs.com/scandinavia/aplicaciones/transferencia/listados/distribucion/index.php";
    				});
    		    }
    		    else
    		    {
    		        swal('INFORMACION','No se registro la información','error').then((success)=>{
    					actualizar();
    				});
    		    }
    		}
    	
      	});
    
}



function traer(id)
{
 $.ajax({
		 type: 'POST',
		 url: 'traerAsistentes.php',
		 data:{id},
		 success:function(r)
		{
				
				let datos = JSON.parse(r);
				
				let template = '';
				
                datos.forEach(date => { 
                        template += `
                            <tr>
                            <td>${date.id_asistencia}</td>
                            <td>${date.tipo}</td>
                            <td>${date.cantidad}</td>
                            <td>${date.nombreAsistente}</td>
                            <td>${date.cedulaAsistente}</td>
                            <td>${date.valor}</td>
                            <td width="30%">${date.transferenciaValor}</td>
                            <td><a href="#" class="btn btn-danger" onclick="eliminarAsistentes(${date.id_asistencia}, ${date.consecutivo})"><i class="glyphicon glyphicon-trash"></i></a></td>
                            </tr>`;
                        
                    
                    });
				
				$('#columna').html(template);
				
				
			}
	});   
}

function porcent()
{
    let porce = document.getElementById("porcentaje").value;
    let por =  porce.replace(",", "",porce);
    let pir = por.replace(".", "",por);
    let pirs = pir.replace(",", ",",",","",pir);
     
    
    
    
    document.getElementById("porce").value = pirs;
}


function pruebaaa()
{
    let valor = $('#val').val();
    let pe = valor.replace(".",",",valor);
    let num = parseInt(pe);
    
    $('#prus1').val(num);
}
function pruebaaa3()
{
    
    let valor3 = $('#val3').val();
    let pe3 = valor3.replace(",","",valor3);
    
    
    $('#prus3').val(pe3);
}
function pruebaaa2()
{
    let valor2 = $('#val2').val();
    
    let pe2 = valor2.replace(",","",valor2);
    
    
    
    $('#prus2').val(pe2);
}
function pruebaaa1()
{
    
    let valor1 = $('#val1').val();
    
    let pe1 = valor1.replace(",","",valor1);
    
    
    $('#prus').val(pe1);
}



function pruebas2(id)
{
	$.ajax({
		 type: 'POST',
		 url: 'traerAsistentes.php',
		 data:{id},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<tr>
					<td>${dato.id_asistencia}</td>
					<td>${dato.tipo}</td>
					<td>${dato.cantidad}</td>
					<td>${dato.nombreAsistente}</td>
					<td>${dato.cedulaAsistente}</td>
					<td width="30%">${dato.transferenciaValor}</td>
					
					</tr>`;
 				});
				
				$('#columna2').html(template);
				
			}
	});
}

$(".monohp").click(function(){
	let id = $(this).data('id');
	$(".modal-body #idhp").val(id);
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
    		}).then((success)=>{
				actualizar();
				//console.log(asistencia, consecutivo);
			});
				
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
	let cedulaempleado = $('#panel4e').val();
	let cantidad = $('#num').val();
	let panel2 = $('#pan2').val();
	let val = $('#prus1').val();
	let val1 = $('#prus').val();
	let val2 = $('#prus2').val();
	let val3 = $('#prus3').val();
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
			data:{lgcabeza, id, cantidad, panel, nopanel, nopanelcedula, empleado, primercheck, segundocheck, tercercheck, quintocheck,sextocheck, cedulapanel, cedulaempleado,panel2, panel10, val, val1, val2, val3},
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
                	$('#panel4e').val('');
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


function prueba()
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


function buscar() {
	let id_factura = $('#idd').val();
	$.ajax({
		url:'buscarCodigos.php',
		type: 'POST',
		data:{id_factura},
		success: function (response) {
			let respuesta = JSON.parse(response);
			if(respuesta == "si")
			{
				swal('Codigos Inversion','Los valores son equivalentes a la base.','success').then((success)=>{
					actualizar();
				});

			}else if(respuesta == "Mal"){
				
					actualizar();
				
			}
			
		}
	})
}

function pruebaTexto()
{
    let test = $('#test1').val();
    if(test == '')
    {
        swal('Error','Por favor ingrese la novedad','error');
    }
    else
    {
        let id_factura = $('#ides').val();
        let test1 = $('#test1').val();
        $.ajax({
    		url:'ingresarNov.php',
    		type: 'POST',
    		data:{id_factura, test1},
    		success: function (response) 
    		{
    			if(response == "OK")
    			{
    				swal('INFORMACION','Se agrego la novedad correctamente','success').then((success)=>{
    					actualizar();
    				});
    
    			}
    		}
    	});
    }
}


function checkeadoDeposito()
{
    if($('#fDeposito').prop('checked'))
    {
            let id_factura = $('#id_tr').val();
            $.ajax({
    		url:'actualizarTipoCode.php',
    		type: 'POST',
    		data:{id_factura},
    		success: function (response) {
    			
    			if(response == "OK")
    			{
    				swal('Asistentes','Es necesario colocar los asistentes.','success').then((success)=>{
    					actualizar();
    				});
    
    			}else if(respuesta == "Mal"){
    				swal('INFORMACIÓN','No se pudo actualizar el dato.','warning').then((success)=>{
    					actualizar();
    				});
    			}
    			
    		}
    	});
    }
    else
    {
        console.log("NO checkeado");
    }
    
}


function checkeadoNoInv()
{
    if($('#noInv').prop('checked'))
    {
            let id_factura = $('#id_tr').val();
            $.ajax({
    		url:'actualizarNoInv.php',
    		type: 'POST',
    		data:{id_factura},
    		success: function (response) {
    			
    			if(response == "OK")
    			{
    				swal('NO INVERSION COMERCIAL','Se actualizo el dato correctamente','success').then((success)=>{
    					actualizar();
    				});
    
    			}else if(respuesta == "Mal"){
    			    swal('NO INVERSION COMERCIAL','No se pudo actualizar el dato.','warning').then((success)=>{
    					actualizar();
    				});
    			}
    			
    		}
    	});
    }
    else
    {
        console.log("NO checkeado");
    }
    
}

function checkeadoPago()
{
    if($('#pEspecial').prop('checked'))
    {
            let id_factura = $('#id_tr').val();
            $.ajax({
    		url:'actualizarTipoPago.php',
    		type: 'POST',
    		data:{id_factura},
    		success: function (response) {
    			
    			if(response == "OK")
    			{
    				swal('PAGO ESPECIAL','','success').then((success)=>{
    					actualizar();
    				});
    
    			}else if(respuesta == "Mal"){
    				swal('PAGO ESPECIAL','No se pudo actualizar el dato.','warning').then((success)=>{
    					actualizar();
    				});
    			}
    			
    		}
    	});
    }
    else
    {
        console.log("NO checkeado");
    }
    
}


function Apr()
{
    console.log("asda");
}





function procesar(aprContabilidad, estado, observacion, sesionn){
    var aprContabilidad = document.getElementById("aprContabilidad").value;
    var docs = document.getElementById('docs').value;
    var estado=document.getElementById("estadosTrans").value;
	var ObservacionN = document.getElementById("ObservacionN").value;
	var observacion=document.getElementById("ObservacionP").value;
	var sesion = document.getElementById("sesionAprobador").value;
    var isChecked1 = $('#success').prop('checked');
	if(isChecked1 == true && ObservacionN == '' )
	{	
	
		swal('Error','Por favor ingrese la novedad','error');
		
	}
	else{
	$.ajax({
	
		url:'procesar.php',
		type: 'POST',
		data:{docs, estado, observacion, isChecked1, ObservacionN, aprContabilidad, sesionn},
		success: function (response) {
			if (response == "Exito") {
				swal('Documento Procesado','Se ha procesado el documento exitosamente :)','success').then((success)=>{
				window.location = "https://appmegalabs.com/scandinavia/aplicaciones/transferencia/listados/aprobador/index.php?op=Aprobacion";
				});
				
			}
			else{
				swal('Error','Se ha producido un error al procesar','error');
				
			}
		}
	})
	

	}




}

function procesarContabilidad(estadoProceso, observacion, id, numApr){
	var isChecked1 = $('#success').prop('checked');
	var estado=document.getElementById("estadoProceso").value;
	var numApr=document.getElementById("numApr").value;
	var observacion=document.getElementById("ObservacionP").value;
	$.ajax({
		url:'procesarC.php',
		type: 'POST',
		data:{id, estado, observacion, numApr},
		success: function (response) {
			if (response) 
			{
				swal('Documento Procesado','Se ha procesado el documento exitosamente :)','success').then((success)=>{
					window.location = "listado.php";
				});
				
			}
			else{
				swal('Error','Se ha producido un error al procesar','error');
					
			}
		}
	})


}


function checkapr(){
	var isChecked1 = $('#success').prop('checked');
	if(isChecked1)
	{	
		$('#aprobar').show();
		
		
	}
	else
	{
		$('#aprobar').hide();
		$('#success').disabled('true');

	}
}

function aceptarContabilidad(obser, user, id)
{
       
	swal({
		title: "Estas seguro?",
		text: "Aceptar el documento",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	  })
	  .then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url:'aceptaDocumentoC.php',
				type: 'POST',
				data:{id, user, obser},
				success: function (response) {
				   
					if (response == "Exito") {
					    swal('Documento Procesado','Has aceptado el documento :)','success').then((success)=>{
							actualizar();
						});
					}
					else{
						swal('Error','Se ha producido un error al aceptar','error');
					}
				}
			})		

		} else {
		  swal("Porfavor acepta o rechaza el documento para continuar");
		}
	  });
    
}

function cancelarContabilidad(obser, user, id)
{
    
 if(obser == null || obser == ''){
        swal({
		title: "Debes llenar",
		text: "todos los campos",
		icon: "error",
		buttons: true,
		dangerMode: true,
	  })
    }
    else{
	swal({
		title: "Estas seguro?",
		text: "Rechazar el documento",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	  })
	  .then((willDelete) => {
		if (willDelete) {			 
				$.ajax({
					url:'rechazaDocumentoC.php',
					type: 'POST',
					data:{id, user, obser},
					success: function (response) {
						if (response == "bien") {
							swal('Documento Procesado','Has Rechazado el documento :)','success').then((success)=>{
								actualizar();
							});
						}
						else{
							swal('Error','Se ha producido un error al rechazar','error');
						}
					}
				})

		} else {
			swal("Porfavor acepta o rechaza el documento para continuar");
		}
	  });
    }
}



function aceptar(id, user, obser) {

    
	swal({
		title: "Estas seguro?",
		text: "Aceptar el documento",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	  })
	  .then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url:'aceptaDocumento.php',
				type: 'POST',
				data:{id, user, obser},
				success: function (response) {
					if (response == "Exito") {
						swal('Documento Procesado','Has aceptado el documento :)','success').then((success)=>{
							actualizar();
						});
					}
					else{
						swal('Error','Se ha producido un error al aceptar','error');
					}
				}
			})		

		} else {
		  swal("Porfavor acepta o rechaza el documento para continuar");
		}
	  });
    
	
}

function rechazar(id, user, obser) {

 if(obser == null || obser == ''){
        swal({
		title: "Debes llenar",
		text: "todos los campos",
		icon: "error",
		buttons: true,
		dangerMode: true,
	  })
    }
    else{
	swal({
		title: "Estas seguro?",
		text: "Rechazar el documento",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	  })
	  .then((willDelete) => {
		if (willDelete) {			 
				$.ajax({
					url:'rechazaDocumento.php',
					type: 'POST',
					data:{id, user, obser},
					success: function (response) {
						if (response == "bien") {
							swal('Documento Procesado','Has Rechazado el documento :)','success').then((success)=>{
								actualizar();
							});
						}
						else{
							swal('Error','Se ha producido un error al rechazar','error');
						}
					}
				})

		} else {
			swal("Por favor acepta o rechaza el documento para continuar");
		}
	  });
    }
}


function ingresoCod() {
	
	let codigo= document.getElementById("codigo_inversion").value;
	let porcentual = document.getElementById("porce").value;
	let id = document.getElementById("idd").value;

	$.ajax({
		url:'registraUnCodigo.php',
		type: 'POST',
		data:{codigo, porcentual, id},
		success: function (response) {
			if (response == "bien") {
				swal('Codigo Registrado','Codigo Ingresado Correctamente','success').then((success)=>{
					document.getElementById("codigo_inversion").value = '';
					document.getElementById("porcentaje").value = '';
					document.getElementById("porce").value = '';
					
					buscar();
				});
			}
			else{
				swal('Error','Se ha producido un error','error');
			}
		}
	})


}

function traecodigos(id)
{
	$.ajax({
		 type: 'POST',
		 url: 'traeCodigos.php',
		 data:{id},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<tr>
					<td>${dato.id_factura}</td>
					<td>${dato.codigo}</td>
					<td>$${dato.porcentual} </td>
					<td>${dato.tipo}</td>
					<td><a href="#" class="btn btn-danger" onclick="eliminarCodigos(${dato.id})"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>
			`;
 				});
				
				$('#trans_v').html(template);
				
			}
	});
}


function traecodigos2(id)
{
	$.ajax({
		 type: 'POST',
		 url: 'traeCodigos.php',
		 data:{id},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<tr>
					<td>${dato.id_factura}</td>
					<td>${dato.codigo}</td>
					<td>$${dato.porcentual}</td>
					
			</tr>
			`;
 				});
				
				$('#trans_v1').html(template);
				
			}
	});
}

function eliminarCodigos(id){
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
			  url:'eliminarCodigos.php',
			  type:'POST',
			  data:{id},
			  success: function (response)
			  {
				  if(response == "true")
				  {
					  swal("Bien", {
						icon: "success",
				  }).then((succes)=>{
					  actualizar();
				  });
					  
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

function porcentual() {
	let porcentual = $('#porcentual').val();
	if (porcentual == 100) {
		$('#Aprobar').attr("disabled", false);
		$('#cumple').show();
		$('#nocumple').hide();
	}
	else{
		$('#Aprobar').attr("disabled", true);;
		$('#cumple').hide();
		$('#nocumple').show();
	}
}


function justificacion(identificacionFactura)
{
   let descripcion = $('#ObservacionP').val();
    
   swal({
  title: "Estas seguro ?",
  text: "se cambiara el estado.",
  icon: "info",
  buttons: true,
  dangerMode: true,
    }).then((willDelete)=>{
        if (willDelete) {
       $.ajax({
        	url: 'enviojustificacion.php',
        	type:'POST',
        	data:{identificacionFactura , descripcion},
        	success: function(respuesta) {
            	swal ( "Se realizo el Cambio" ,  "Exitosamente." ,  "success");
        	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");
            }
        });
    }else{
            swal ( "Accion cancelada!" ,  "" ,  "error");
        }
        
});

}

function revisiones(identificacionFactura)
{
    let descripcion1 = $('#ObservacionP').val();
          swal({
              title: "Estas seguro ?",
              text: "se cambiara el estado.",
              icon: "info",
              buttons: true,
              dangerMode: true,
            }).then((willDelete)=>{
                 if (willDelete) {
            $.ajax({
        	url: 'envioRevision.php',
        	type:'POST',
        	data:{identificacionFactura , descripcion1},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success");
        	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");
            }
        });
                 }else{
            swal ( "Accion cancelada!" ,  "" ,  "error");
        }
    });
    
}

function cruce(identificacionFactura)
{
    let descripcion2 = $('#ObservacionP').val();
   
        
   
       swal({
          title: "Estas seguro ?",
          text: "se cambiara el estado.",
          icon: "info",
          buttons: true,
          dangerMode: true,
        }).then((willDelete)=>{
        if (willDelete) {
            $.ajax({
        	url: 'envioCruce.php',
        	type:'POST',
        	data:{identificacionFactura , descripcion2},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success");
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");            }
        });
        }else{
            swal ( "Accion cancelada!" ,  "" ,  "error");
        }
    });
    
}


function enviarTesoreria(id)
{
    
    
    let des = $('#ObservacionP').val();
        if(des == ''){
    	swal ( "Error" ,  "Por favor llena el campo descripcion" ,  "error");
    }
    else
    {
         swal({
          title: "Estas seguro ?",
          text: "Se cambiara el estado.",
          icon: "info",
          buttons: true,
          dangerMode: true,
        }).then((willDelete)=>{
        if (willDelete) {
            $.ajax({
        	url: 'envioTesoreria.php',
        	type:'POST',
        	data:{id , des},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success").then((success)=>{
            	    actualizar();
            	});
            	    
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");    
            	actualizar();
            	}
        });
        }else{
            swal ( "Accion cancelada!" ,  "" ,  "error");
        }
    });      
    }
}

function enviarCartera(id)
{
    let des1 = $('#ObservacionP').val();
    
    
    
    
        if(des1 == ''){
    	swal ( "Error" ,  "Por favor llena el campo descripcion" ,  "error");
    }
    else
    {
         swal({
          title: "Estas seguro ?",
          text: "Se cambiara el estado.",
          icon: "info",
          buttons: true,
          dangerMode: true,
        }).then((willDelete)=>{
        if (willDelete) {
            $.ajax({
        	url: 'envioCartera.php',
        	type:'POST',
        	data:{id , des1},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success").then((success)=>{
            	    actualizar();
            	});
            	    
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");    
            	actualizar();
            	}
        });
        }else{
            swal ( "Accion cancelada!" ,  "" ,  "error");
        }
    });      
    }
}

function cruzarContabilidad(id)
{
    let des2 = $('#ObservacionP').val();
    
    
        if(des2 == ''){
    	swal ( "Error" ,  "Por favor llena el campo descripcion" ,  "error");
    }
    else
    {
         swal({
          title: "Estas seguro ?",
          text: "Se cambiara el estado.",
          icon: "info",
          buttons: true,
          dangerMode: true,
        }).then((willDelete)=>{
        if (willDelete) {
            $.ajax({
        	url: 'envioConta.php',
        	type:'POST',
        	data:{id , des2},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success").then((success)=>{
            	    actualizar();
            	});
            	    
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");    
            	actualizar();
            	}
        });
        }else{
            swal ( "Accion cancelada!" ,  "" ,  "error");
        }
    });      
    }
}

function pendienteNota(id)
{
    let des3 = $('#ObservacionP').val();
    
        if(des3 == ''){
    	swal ( "Error" ,  "Por favor llena el campo descripcion" ,  "error");
    }
    else
    {
         swal({
          title: "Estas seguro ?",
          text: "Se cambiara el estado.",
          icon: "info",
          buttons: true,
          dangerMode: true,
        }).then((willDelete)=>{
        if (willDelete) {
            $.ajax({
        	url: 'pendienteNota.php',
        	type:'POST',
        	data:{id , des3},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success").then((success)=>{
            	    actualizar();
            	});
            	    
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");    
            	actualizar();
            	}
        });
        }else{
            swal ( "Accion cancelada!" ,  "" ,  "error");
        }
    });      
    }
}

function sinFinalizar(id)
{
    let des4 = $('#ObservacionP').val();
    
  
         swal({
          title: "Estas seguro ?",
          text: "Se cambiara el estado.",
          icon: "info",
          buttons: true,
          dangerMode: true,
        }).then((willDelete)=>{
        if (willDelete) {
            $.ajax({
        	url: 'facturaSin.php',
        	type:'POST',
        	data:{id , des4},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success").then((success)=>{
            	    actualizar();
            	});
            	    
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");    
            	actualizar();
            	}
        });
        }else{
            swal ( "Accion cancelada!" ,  "" ,  "error");
        }
    });      
    
}







function listadoDescripciones()
{
    $(".tablaHistorial").click(function(){
	let ide = $(this).data('id');	
	$(".modal-body1 #ide").val(ide);
	let lgcabeza = $('#lgcabeza').val();
	$.ajax({
		 type: 'POST',
		 url: 'traerDescripciones.php',
		 data:{ide, lgcabeza},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<tr>
					  <td scope="row">${dato.fecha}</td>
                      <td scope="row">${dato.full_name}</td>
                      <td>${dato.nuevo_estado}</td>
                      <td>${dato.observacion}</td>
                    </tr>
					
				`;
 				});
				
				$('#columna').html(template);
				
			}
	});



})
}

function devolverFactura(id){
    swal({
  title: "Estas seguro?",
  text: "Vas a devolver esta factura",
  icon: "warning",
  content: "input",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      let obs = willDelete;
            $.ajax({
        	url: 'devolverFactura.php',
        	type:'POST',
        	data:{id, obs},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success").then((success)=>{
            	    actualizar();
            	});
            	    
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");    
            	actualizar();
            	}
        });

  } else {
    swal("Operacion Cancelada!");
  }
});
}

function enviaPago(id){
    swal({
  title: "Estas seguro?",
  text: "Vas a enviar esta  Factura a Pago",
  icon: "warning",
  content: "input",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      let obs = willDelete;
            $.ajax({
        	url: 'enviaPagoCartera.php',
        	type:'POST',
        	data:{id, obs},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success").then((success)=>{
            	    actualizar();
            	});
            	    
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");    
            	actualizar();
            	}
        });

  } else {
    swal("Operacion Cancelada!");
  }
});
    
}
function enviaCruce(id){
       swal({
  title: "Estas seguro?",
  text: "Vas cambiar esta factura para Cruce Cartera",
  icon: "warning",
  content: "input",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      let obs = willDelete;
            $.ajax({
        	url: 'enviaCruceCartera.php',
        	type:'POST',
        	data:{id, obs},
        	success: function(respuesta) {
            	swal ( "Exito" ,  "Cambio Realizado" ,  "success").then((success)=>{
            	    actualizar();
            	});
            	    
            	},
        	error: function() {
            	swal ( "Error" ,  "Fallo en el server" ,  "error");    
            	actualizar();
            	}
        });

  } else {
    swal("Operacion Cancelada!");
  }
});
 
}


function listadoDescripciones3()
{
    $(".tablaHistoricos").click(function(){
	let ide = $(this).data('id');	
	$(".modal-body1 #ide").val(ide);
	let lgcabeza = $('#lgcabeza').val();
	$.ajax({
		 type: 'POST',
		 url: 'traerDescripciones.php',
		 data:{ide, lgcabeza},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<tr>
					  <td>${dato.fecha}</td>
                      <td scope="row">${dato.full_name}</td>
                      <td>${dato.nuevo_estado}</td>
                      <td>${dato.observacion}</td>
                   
                      
                    </tr>
					
				`;
 				});
				
				$('#columna').html(template);
				
			}
	});



})
}

function listadoDescripciones4()
{
    $(".tablaGestion").click(function(){
	let ide = $(this).data('id');	
	$(".modal-body1 #ide").val(ide);
	let lgcabeza = $('#lgcabeza').val();
	$.ajax({
		 type: 'POST',
		 url: 'traerDescripciones.php',
		 data:{ide, lgcabeza},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<tr>
                      <td>${dato.fecha}</td>
                      <td scope="row">${dato.full_name}</td>
                      <td>${dato.nuevo_estado}</td>
                      <td>${dato.observacion}</td>
                      
                      
                    </tr>
					
				`;
 				});
				
				$('#columna').html(template);
				
			}
	});



})
}

function listadoDescripciones()
{
    $(".contabilidad2").click(function(){
	let ide = $(this).data('id');	
	$(".modal-body1 #ide").val(ide);
	let lgcabeza = $('#lgcabeza').val();
	$.ajax({
		 type: 'POST',
		 url: 'traerDescripciones.php',
		 data:{ide, lgcabeza},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<tr>
                      <td>${dato.fecha}</td>
                      <td scope="row">${dato.full_name}</td>
                      <td>${dato.nuevo_estado}</td>
                      <td>${dato.observacion}</td>
                      
                    </tr>
					
				`;
 				});
				
				$('#columna').html(template);
				
			}
	});



})
}



