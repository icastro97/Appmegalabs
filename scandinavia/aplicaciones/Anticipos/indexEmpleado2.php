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
	$sid = $_REQUEST['documento'];  		
}


//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from database
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar


$bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar

$conditions['where'] = array('consecutivo'=> $sid,); 
$users = $db->getRows('anticipo',$conditions); //ojo se pone tabla a consultar

$condicion['where'] = array('u_userid'=> $users[0]['aprobador'],); 
$apr = $db->getRows('system_users',$condicion); //ojo se pone tabla a consultar


if(isset($_GET['monto']))
{
    $monto = $_GET['monto'];
}

if($users > 0){
    $sql = "select identificacion,consecutivo, moneda,sum(monto) as sumas from anticipo  where consecutivo = $sid  group by consecutivo, moneda	";
    $query2=mysqli_query($mysqli, $sql); 
    $totalData2 = mysqli_num_rows($query2);	


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
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">


<script src="assets/jquery.maskMoney.js" type="text/javascript"></script>


    
<!--AJAX-->
        <script>
            $(document).ready(function() {
                
                dato();
                $('aprotrue').show();
                $('#aprobadores').hide();
                $('#apro1').hide();
                        
                $('#alerta').hide();
                <!--#my-form grabs the form id-->
                $("#my-form").submit(function(e) {
                    e.preventDefault();
					document.getElementById("buttonsave").disabled = true; 
                    $.ajax( {
                        <!--insert.php calls the PHP file-->
                        url: "guardarajaxEmpleado2.php",
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
							
							 $("#resultadotemporal").hide();
							 $("#resultado1").load('ajax-grid-antE.php',{'varidentificadounico': strMessage});     
                        }
                    });
                });
            });

        
                        
        </script>
       


       



    <script type="text/javascript">

function eliminarsolicitud2(idanticipo, consecutivo ){
	//donde se mostrará el resultado de la eliminacion
	divResultado = document.getElementById('resultado1');
	
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
				 $("#resultado1").load('ajax-grid-antE.php',{'varidentificadounico': consecutivo});
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
disableCheck(insertregistro.cheque1, field);
}

function disableUno(field) {
disableCheck(insertregistro.efectivo1, field);
disableCheck(insertregistro.cheque1, field);

}
function disableTres(field) {
disableCheck(insertregistro.efectivo1, field);
disableCheck(insertregistro.transferencia1, field);
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
            $("#info").append("<label id='nombre'>Nombre del Evento<label>");
            $("#info").append("<input class='form-control' name='evento' id='texto' type='text' placeholder='Nombre' required>");
            $("#info2").append("<label id='inver'>C. inversión<label>");
            $("#info2").append("<input class='form-control' name='cinversion' style='text-transform:uppercase' id='texto1' type='text'placeholder='C.inversión' required>");
            $("#info3").append("<label for='ex2' id='fec'>Fecha Inicial</label>");
            $("#info3").append("<input type='date' class='form-control inputstl' name='fechaini' id='fechaini' required>");
            $("#info4").append("<label for='ex2' id='fech'>Fecha Final</label>");
            $("#info4").append("<input type='date' class='form-control inputstl' name='fechafin' id='fechafin' required>");
            $("#info5").append("<label for='ex2' id='des'>Descripcion</label>");
            $("#info5").append("<textarea name='descripcion' class='form-control input-sm' required id='descripcion1'   rows='3' cols='45' ></textarea>");
        }    	
        }else{
            $("#texto").remove(); 
            $("#texto1").remove(); 
            $("#nombre").remove(); 
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
            $("#info5").append("<textarea name='descripcion' class='form-control input-sm' required id='descripcion1'  style='text-transform:uppercase' rows='3' cols='45'></textarea>");
        }    	
        }else{
             
            $("#des").remove(); 
            $("#descripcion1").remove(); 

        }
    });
});




function actualizacionFecha() 
{
    let fechaDesembolso = $('#dateArrival1').val();    
    let id_anticipo = $('#id_anticipo').val();
    $.ajax({
        type:'POST',
        url: 'actualizacion.php',
        data:{fechaDesembolso, id_anticipo},
        success:function(response) 
        {
           $('#alerta').show(); 
           $('#alertaActualizacion').html(response);
           
        }
    });
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
						template += `${dato.Aprobador} <input type="hidden" name="nombreaprobador" id="aprobador" value="${dato.idAprobador}">`
						
					
                    });

					$('#apro1').html("El aprobador de este Anticipo es: <strong>"+template+"</strong></h5> ");	
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
            actualizarAprobador();
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


 if(id == cedulaIngresada)
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




    function actualizarAprobador() 
    {
        let aprobador = $('#listaapr1').val();
        let consecutivo = $('#docupdate').val();

        $.ajax({
            data: {aprobador, consecutivo},
            type:'POST',
            url: 'info6.php',
            success:function(response)
            {
                
                if(response)
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
            

    }

    function actualizar(){location.reload(true);}
//Función para actualizar cada 4 segundos(4000 milisegundos)


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



<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6"></div>
	<div class="col-md-3"><a href="baja.php?dato=<?php echo $users[0]['consecutivo']; ?>" class="btn btn-danger" >Dar baja </a></div>

</div>

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
            	    <td colspan="3" align="center"><h3>Solicitud de Anticipo Empleado</h3></td>
            	    </tr>
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    <td colspan="4" align="right">&nbsp;</td>
            	    <td align="center" valign="top">&nbsp;</td>
            	  </tr>        
            	  </table>	
            	
    <!--<form id="my-form" method="post" action="guardar.php?inserted=1" name="insertregistro" enctype="multipart/form-data">-->
   <div class="panel" style="border: 1px solid #00AB84;">
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
            			    			                                    <input class="form-control" type="text" name="fechaActual" id="fecha" readonly="readonly" value="<?php echo $users[0]['fechaActual']?>"/> 
                                                                            </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Identificación</label>
                                                                            <input name="identificacion" type="text"  class="form-control" id="identificacion" value="<?php echo $users[0]['identificacion']?>" readonly="readonly"> 
                                                                            </div>
                                                                
                                                            </div>
                                                           
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Nombre</label>
                                        			    			        <input name="nombre" type="text" class="form-control"   value="<?php echo $users[0]['nombre']?>" readonly="readonly"/>
                                                                            
                                                                            </div>
                                                                
                                                            </div>

                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                <label for="ex2">Moneda</label>
                                                                                <select name="Moneda[]" class="form-control input-sm" id="Moneda1"> <option value="COP">Peso Colombiano</option><option value="USD">Dolares</option><option value="EUR">Euros</option> <option value="GBP">Libra esterlina</option></select>
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
                                                                                        <input type="checkbox" name="efectivo" id="efectivo1"  onClick="disableDos(this)" required>
                                                                                     </div>   
                                                                                     <h5 class="texto"> Efectivo</h5>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <input type="checkbox" name="transferencia" id="transferencia1"  onClick="disableUno(this)"required>
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
                                                                                        <input type="checkbox" name="inversioncom" id="inversioncom1" onClick="deshabilitarOtros(this)"required>
                                                                                     </div>   
                                                                                     <h5 class="texto"> Inversión Comercial</h5>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <input type="checkbox" name="otros" id="otros1" onClick="deshabilitarInversion(this)"required>
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
                                                                                    <input type="text" class="form-control form-control-lg" name="fechadesembolso" id="dateArrival1"  value="<?php echo $users[0]['fechadesembolso']?>" onchange="actualizacionFecha()">
                                                                                    <div id="alerta" class="alert alert-success"><h5 id="alertaActualizacion"></h5></div>
                                                                                    <input type="hidden" id="id_anticipo" value="<?php echo $users[0]['id_anticipo']?>">
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
            <input name="docupdate" type="hidden" id="docupdate" value="<?=$sid?>" />
                                <div class="panel-body" id="seleccion">
	<div class="panel" style="border:1px solid #00AB84;" >            
			<div class="panel-heading text-center form-control" >Seleccion Aprobador</div>  
			
			<td >&nbsp;</td>
			<td >&nbsp;</td>
			<div class="row">
				<div class="col-md-4" id=""></div>
				<div class="col-md-6" id="aprotrue"><h5>El aprobador de este anticipo es: <strong><?php echo $apr[0]['full_name']; ?></strong><h5></div>		
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
            <br>
			<div class="row">
            <div class="col-md-4" id=""></div>	
            
			<div class="col-md-5" id="aprobadores">
				<input type="text" class="form-control" id="listaapr"  name="aprobador" onKeyUp="listadoAprobadores()" onBlur="aprobador2(1)"  >
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
            
            <div class="row">
                <div class="row">
                    <div class="col-md-2">
                    <input type="hidden" name="ultimoinserted" id="ultimoinserted" value="" /> 
            <input type="hidden" name="tp" id="tp" value="Empleado">
            <input name="docupdate" type="hidden" id="docupdate" value="<?=$_REQUEST['documento'];?>" />
            <input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
                <input name="username" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" />
                <div id="apro"></div>
                    </div>
                <div class="col-md-10">

                    <input name="input" type="submit" id="buttonsave" class=" btn" style="background-color:#00AB84; color:white;" value="Enviar Información" /> 
                    
                </div>
                <br>
                <br>
             </div>   
            
            
            
            
            
            </td>
                            </tr>
                          
                          
                        </div>
                       
                        
            <div class="table-responsive">  
            <table width="100%"  cellspacing="1" cellpadding="1">
              <tr>
              
                <td colspan="2"><div id="resultado1">
                 
                </div></td>
              </tr>
              <tr>
              </form> 
                <td><div id="resultadotemporal">

						 
								<table class="table table-striped table-bordered">
								
								<tbody id="userData">
									<tr></tr>
								</tbody>
								<thead>
									<tr>
										<th rowspan="2">No</th>									
										<th rowspan="2" valign="bottom"><div align="center">Fecha</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Tipo</div></th>
										<th rowspan="2" align="center" ><div align="center">Identificación</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Nombre </div></th>										
										<th rowspan="2" valign="bottom"><div align="center">Valor</div></th>
										<th rowspan="2" valign="bottom"><div >Accion</div></th>
									</tr>
									<tr></tr>
								</thead>
								<tbody id="userData2">
                                
                                        <?php $sumaneto = 0;
                                                if(!empty($users)): $count = 0; foreach($users as $user): $count++; ?> 
                                        <tr>
                                        <td><?php echo $user['consecutivo']; ?></td>
                                        
                                            <td align="center"><?php echo $user['fechaActual']; ?></td>
                                            <td align="center">
                                            <?=($user['tipo']) ?></td> 
                                            <td align="center">
                                            <?=($user['identificacion']) ?></td>
                                            <td align="center">
                                            <?=($user['nombre']) ?></td>                                            
                                            <td align="center"><?=$user['moneda']?> $<?=number_format($user['monto'],2); ?></td> 
                                           

                                             
                                            <td ><a class="btn btn-danger" href="eliminadetallef.php?documento=<?=$user['id_anticipo']?>&amp;consecutivo=<?=$user['consecutivo']?>&amp;op=LISTADO ANTICIPOS">Eliminar</a>
                                            
                                            </td>
                                           

                                        </tr>
                                        
                                        
                                        <?php endforeach; else: ?>
                                        <tr>
                                            <td colspan="5">No existen documentos para mostrar......</td>
                                        </tr>
                                        
                                        <?php endif; ?>
                                        
                                        <tr>
                                        <table align="right" width="15%" table table-striped>
 
                                <tr>
                                <td><strong>Moneda</strong></td>
                                    <td><strong>Valor</strong></td>
                                
                                </tr>



                                <?php

                                while( $row_Transacciones2=mysqli_fetch_array($query2) ) {  // preparing an array

                                    echo "	<tr>";
                                    echo " 		<td>".$row_Transacciones2['moneda']."</td>";
                                    echo " 		<td align=\"right\" id=\"total\">$".number_format($row_Transacciones2['sumas'], 2) . "</td>";
                                    
                                    echo "	</tr>"; 
                                    
                                    $total = floatval($row_Transacciones2['sumas']);

                                    
                                    

                                
                                
                                    $sqlx = "SELECT * FROM system_users WHERE cedula=". $row_Transacciones2['identificacion'];
                                    $consults = mysqli_query($mysqli, $sqlx);
                                    while ($fila = mysqli_fetch_array($consults)) 
                                    {
                                        $cedula = $fila['cedula'];
                                        $imagen = $fila['ubicacionFirma'];

                                        if($imagen == null)
                                        {
                                            
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                                No cuenta con una firma, por favor presione el botón CREAR FIRMA para contar con una.		
                                            </div>
                                            <div class="col-md-6">
                                                <a class="btn" style="background-color:#00AB84;color:white;" href="firmar.php?documento=<?=$user['consecutivo']?>" role="button">Crear firma</a>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            
                                            ?><div class="alert alert-success" role="alert">
                                            Ya cuenta una firma, por favor presione el botón FINALIZAR DOCUMENTO para enviar el anticipo.		
                                            </div>
                                            <input  name="imagen" type="hidden" value="<?=$imagen?>">
                                            <a class="btn"style="background-color:#00AB84;color:white;"  href="finalizadocEmp2.php?op=Listado Anticipos&imagen=<?=$imagen?>&identificacion=<?=$cedula?>&documento=<?=$user['consecutivo']?>" role="button">Finalizar documento</a>		
                                            <?php		
                                            
                                        }
                                        
                                    }
                                }    

                                }
                                ?>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                <script type="text/javascript">
                                $("#file").change(function(){
                                $("button").prop("disabled", this.files.length == 0);

                                });
                                </script> 
                                </table>
                            
                                        
                                        </td>
                        
                            </tr>
                            
                     


                                </table>
                                
                                        </tbody>
                                        <tbody>
                                       

                                      
                            </tbody>
									
								</table>
							
								</div> 
                </div>
								</td>
              </tr>
						
              
             
              
            </table>
            
    
            
            
             
          
            
            
         
            
                      
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


				
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
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
		
				
