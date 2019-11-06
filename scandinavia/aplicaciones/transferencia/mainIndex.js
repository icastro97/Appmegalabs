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
  $('#panelg').hide();
  
  
  $("#my-form").submit(function(e) {
      
      let vas = $('#vas').val();
      if(vas == "1")
      {
           swal("Información no registrada!", "Esta factura ya esta ingresada en el sistema", "error").then((success)=>{
                        window.location = "index.php";
                        document.getElementById("dateArrival1").focus();
                    });
         
      }
      else
      {
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
                  
                  if(strMessage > 0)
                  {
                    $("#buttonsave").hide();
                    swal("Información ingresada!", "Se agrego la información correctamente", "success").then((success)=>{
                        window.location = "index.php";
                        document.getElementById("dateArrival1").focus();
                    });
                    document.getElementById("dateArrival1").value = "";
                    document.getElementById("factura1").value = "";
                    document.getElementById("nit1").value =  "";
                    document.getElementById("establecimiento1").value  = "";
                    document.getElementById("ciudad1").value =  "";                
                    document.getElementById("TipoGasto1").value = "";
                    document.getElementById("concepto1").value = "";
                    document.getElementById("descripcion1").value = "";                
                    document.getElementById("valor1").value = "";
                    document.getElementById("file1").value = ""; 
                    document.getElementById("dateArrival1").focus();
                    $("#buttonsave").hide();
              
                    document.getElementById("valor2").value = "";
                    document.getElementById("valor3").value = "";
                    document.getElementById("file1").value = "";
                    document.getElementById("listaapr").disabled = false;
                    $('#listaapr').val('');
                    document.getElementById('total').innerHTML = "0";
                    $("#valida").hide();		
                    
                    
                    
                  } 
                  else
                  {
                    $("#buttonsave").hide();
                    swal("Información no registrada!", "No se agrego la información.", "error").then((success)=>{
                        window.location = "index.php";
                        document.getElementById("dateArrival1").focus();
                    });
                  }
                  
                  
                  
                   
                   
    
              }         
    
    
          });
      }
  });

});

function beforeInsert()
{
      let nit = $('#nit1').val();
      let factura = $('#factura1').val();
    
    $.ajax({
        url:'validaciones.php',
        data:{nit, factura},
        method:'POST',
        success:function(response) 
        {
            $('#vas').val(response);
    	}
    });

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
        beforeInsert();
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












function sumar() {


	patron = "";

	var total = 0;
  
	$(".monto").each(function() {
  
	  if (isNaN(parseFloat($(this).val()))) {
  
		total += 0;
  
	  } else {
  
		
		total += parseFloat($(this).val());;
		
  
	  }
  
	});
  

	document.getElementById('total').innerHTML = total;
  
  }




 function actualizar(){location.reload(true);}
//Función para actualizar cada 4 segundos(4000 milisegundos)


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
					
				})
				

		});

};





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
            
        



function validacionFact()
{
    let numeroFactura = $('#factura1').val();    
    let nit = $('#nit1').val();    
    
    var botonEnviar = document.getElementById('buttonsave');
 
    // console.log(numeroFactura);
   //console.log(nit);
    // console.log(radicado);
    // console.log(opciones);   
    $.ajax({
         type: 'POST',
         url: 'validacionFact.php',
         data:{numeroFactura, nit},
         success:function(r)
            {
                if(r == 1)
                {
                    swal("Información!", "Esta factura ya se encuentra en el sistema", "error");
                    botonEnviar.disabled = true;
                }
                else
                {
                    //swal("Información!", "Esta factura no se encuentra en el sistema", "success");
                     botonEnviar.disabled = false;
                }
                
            }
    });
    
    
}

function prs123()
{
    let  user = $('#usuario').val();
    $.ajax({
        type:'POST',
        url: 'traeUltimo.php',
        data:{user},
        success:function(r)
        {
            let json = JSON.parse(r);
            json.forEach(function(campo, index) {
            
            if(campo.tipoFactura == 'Fisica' || campo.tipoFactura == 'ClienteF' || campo.tipoFactura == 'Cobro' || campo.factura == 'Importacion'){
                        $('#cambio').show();
            }
            else{
                $('#cambio').val('NO');
            }
                $('#opciones').val(campo.tipoFactura);
                $('#nit1').val(campo.nit);
                $('#dateArrival1').val(campo.fecfact);
                $('#establecimiento1').val(campo.establecimiento);
                $('#descripcion1').val(campo.descripcion);
            });
        }
    });
}


function validaRadicado(){
    var botonEnviar = document.getElementById('buttonsave');
    let radicado =  $('#cambio').val();
   // console.log(radicado);
    $.ajax({
		 type: 'POST',
		 url: 'vaiidaRadicado.php',
		 data:{radicado},
		 success:function(r)
			{
				if(r == 1)
				{
				    	    swal("Información!", "Este radicado ya se encuentra en el sistema", "error");
				            botonEnviar.disabled = true;
				}
				else
				{
				      console.log("bien");
				     botonEnviar.disabled = false;
				}
				
			}
	});
    
}