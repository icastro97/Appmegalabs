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


$id = $_SESSION['id'];
$cedulalogueada = $_SESSION['identificacion'];

 $conditions['where'] = array('u_userid'=> $id,); 
$users = $db->getRows('system_users',$conditions); //ojo se pone tabla a consultar


$condition1['where'] = array('documento'=> $users[0]['cedula'],); 
$medico = $db->getRows('medico',$condition1);

$condition['where'] = array('cedulaMedico'=> $users[0]['cedula'],); 
$pacientes = $db->getRows('pacientes',$condition);

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
<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>


       



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

// Metodos dónde se deshabilitan y habilitan los check, los input y el boton

function disableCheck(field, causer) {
    if (causer.checked) {
    field.checked = false;
    field.disabled = true;

    }
    else {
        field.disabled = false;
    }
}


function des1(field) {
disableCheck(formulario.siro, field);
}

function des2(field) {
disableCheck(formulario.noro, field);
}

function des3(field) {
disableCheck(formulario.sica, field);
}

function des4(field) {
disableCheck(formulario.noca, field);
}

function des5(field) {
disableCheck(formulario.siman, field);
}
function des6(field) {
disableCheck(formulario.noman, field);
}
function des7(field) {
disableCheck(formulario.noH, field);
}
function des8(field) {
disableCheck(formulario.siH, field);
}


function deshabilitarFem(field) {
disableCheck(formulario.fem, field);
}

function deshabilitarMas(field) {
   
disableCheck(formulario.mas, field);
}

function noacepto(field)
{
        swal ( "Advertencia" ,  "Usted ha marcado la opción “NO ACEPTO”. Lo invitamos a reconsiderar y revisar su decisión. En caso de persistir en con la misma decisión, le informamos que por razones de seguridad del paciente y del estudio, NO es posible incluir a este paciente en el estudio. En este caso, por favor NOTIFICAR O COMUNICARSE INMEDIATAMENTE CON EL PATROCINADOR del estudio al respecto de esta situación." ,  "warning");
       
        document.getElementById("boton").disabled = true;
}

function acepto(field)
{
        disableCheck(formulario.noacep, field);   
        
        document.getElementById("boton").disabled = false;
       let aceptocheck = $('acep').prop('checked');
       if(aceptocheck == true)
       {
           
       }
       else
       {
         $('#alerta').hide();
         $('#alerta1').hide();
       }
       
       
}


function deshabilitarsi(field) {
    if(!disableCheck(formulario.no1, field))
    {
        document.getElementById("si2").disabled = false;
        document.getElementById("no2").disabled = false;
        document.getElementById("fem").disabled = false;        
        document.getElementById("mas").disabled = false;
        document.getElementById("peso").disabled = false;
        document.getElementById("talla").disabled = false;        
        document.getElementById("sistolica").disabled = false;
        document.getElementById("diastolica").disabled = false;            
        document.getElementById("siro").disabled = false;
        document.getElementById("noro").disabled = false;                    
        document.getElementById("sica").disabled = false;
        document.getElementById("noca").disabled = false;
        document.getElementById("siman").disabled = false;
        document.getElementById("noman").disabled = false;
        document.getElementById("siH").disabled = false;
        document.getElementById("noH").disabled = false;
        document.getElementById("boton").disabled = false;


    }
}   

function desahibilitarno(field) 
{    
    if(!disableCheck(formulario.no1, field))
    {
        swal ( "Advertencia" ,  "De acuerdo con la respuesta seleccionada este paciente NO puede ingresar al estudio." ,  "warning");
        document.getElementById("si2").disabled = true;
        document.getElementById("no2").disabled = true;
        document.getElementById("fem").disabled = true;        
        document.getElementById("mas").disabled = true;
        document.getElementById("peso").disabled = true;
        document.getElementById("talla").disabled = true;        
        document.getElementById("sistolica").disabled = true;
        document.getElementById("diastolica").disabled = true;            
        document.getElementById("siro").disabled = true;
        document.getElementById("noro").disabled = true;                    
        document.getElementById("sica").disabled = true;
        document.getElementById("noca").disabled = true;
        document.getElementById("siman").disabled = true;
        document.getElementById("noman").disabled = true;
        document.getElementById("siH").disabled = true;
        document.getElementById("noH").disabled = true;
        document.getElementById("boton").disabled = true;
         
    }  
      
    
}

function disableDos(field) {
;
if(!disableCheck(formulario.si2, field))
    {
        document.getElementById("si1").disabled = false;
        
        document.getElementById("fem").disabled = false;        
        document.getElementById("mas").disabled = false;
        document.getElementById("peso").disabled = false;
        document.getElementById("talla").disabled = false;        
        document.getElementById("sistolica").disabled = false;
        document.getElementById("diastolica").disabled = false;            
        document.getElementById("siro").disabled = false;
        document.getElementById("noro").disabled = false;                    
        document.getElementById("sica").disabled = false;
        document.getElementById("noca").disabled = false;
        document.getElementById("siman").disabled = false;
        document.getElementById("noman").disabled = false;
        document.getElementById("siH").disabled = false;
        document.getElementById("noH").disabled = false;
        document.getElementById("boton").disabled = false;


    }
}



function disableUno(field) 
{    
    if(!disableCheck(formulario.si2, field))
    {
        swal ( "Advertencia" ,  "De acuerdo con la respuesta seleccionada este paciente NO puede ingresar al estudio." ,  "warning");
        document.getElementById("si1").disabled = true;
        document.getElementById("no1").disabled = true;
        document.getElementById("fem").disabled = true;        
        document.getElementById("mas").disabled = true;
        document.getElementById("peso").disabled = true;
        document.getElementById("talla").disabled = true;        
        document.getElementById("sistolica").disabled = true;
        document.getElementById("diastolica").disabled = true;            
        document.getElementById("siro").disabled = true;
        document.getElementById("noro").disabled = true;                    
        document.getElementById("sica").disabled = true;
        document.getElementById("noca").disabled = true;
        document.getElementById("siman").disabled = true;
        document.getElementById("noman").disabled = true;
        document.getElementById("siH").disabled = true;
        document.getElementById("noH").disabled = true;
        document.getElementById("boton").disabled = true;
        
    }    
    
}

function validacionMedico()
{
    let cedulaingresada = $('#campoce').val();
    let cedulalogueada = $('#campolog').val();
    if(cedulaingresada == cedulalogueada)
    {
        $('#alerta').show();
         $('#alerta1').hide();
         document.getElementById("boton").disabled = false;
    }
    else
    {
        $('#alerta1').show();
         $('#alerta').hide();
         document.getElementById("boton").disabled = true;
         
    }
    
}

</script>

		


<script type="text/javascript">
  $(document).ready(function() {
      paciente();
      $('#divcedula').hide();
       $('#alerta').hide();
        $('#alerta1').hide();
          $("#texto").hide(); 
            $("#nombreEvento").hide();
  });
    
  function paciente()
{
	let cedulaMedico = $('#cedulaMedico').val();
	$.ajax({
				url:'pacientes.php',
				type: 'POST',
				data: {cedulaMedico},
				success: function (response) {
					let infor = JSON.parse(response);
					let template = '';
						infor.forEach(dato => {
						template += `<option  value="${dato.codigoPaciente}">${dato.codigoPaciente}</option>`
						
					
					});
					$('#selector').html(template);	
					
										
				}
			})	
}
$(document).ready(function(){
    $("#siH").change(function(){
        var siH = $(this).val();
        if($("#siH").prop('checked')){
        
           $("#texto").show(); 
            $("#nombreEvento").show(); 
            	
        }else{
            $("#texto").hide(); 
            $("#nombreEvento").hide(); 
           

        }
    });
    
    $("#acep").change(function(){
        var acep = $(this).val();
        if($("#acep").prop('checked')){
        if($("#campoce").length === 0){
            $('#divcedula').show();
            $("#divcedula").append("<label id='cedula'>Cedula:<label>");
            $("#divcedula").append("<input name='campoc' class='form-control' id='campoce' onkeyUp='validacionMedico()' onKeypress='return justNumbers(event);'>");
          ;
        }    	
        }else{
            $('#divcedula').hide();
            $("#campoce").remove(); 
            $("#cedula").remove(); 
           

        }
    });
    
});

function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
        }
 
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
    margin-top:4px;
    color:black;
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
        margin-top:-20px;
        
    }
    
}

.panel > .panel-heading {
    background-image: none;
    background-color: #337ab7;
    color: white;
}

.titulo
{
    margin-left:480px;
    margin-top:-15px;
    font-size: 20px;
}

.antro
{
    margin-left:-50px;
}
.titulo1
{
    margin-left:50px;
}
.titulo2
{
    margin-left:50px;
}
.titulos 
{
    margin-right:250px;
}
.confidencial
{
    margin-left:100px;
}
.antro1
{
    margin-left:-50px;
    margin-top:47px;
}
</style>

    <table width="100%" border="0">
        
                    <tr>

                    <td colspan="2" align="center" valign="top"><img src="/scandinavia/assets/img/logobig.png" alt="" width="186" height="117"  /></td>
                    <td colspan="2" align="center"><h3 class="titulos"><strong>CRF</strong></h3></td>
                    </tr>
            	  <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                    
            	    <td colspan="2" align="center"><h3 class="titulos"><strong>Formato ELECTRÓNICO de Recolección de Datos</strong></h3></td>
            	    </tr>
            	  <tr>
                      <tr>
                      <td colspan="3" align="center"><h3 ><strong>Estudio ORCA – 2018 - V01 </strong></h3></td> 
                      
                      </tr>
                         
                      <tr>
                          <td colspan="3" align="center"><h4>“Estudio <strong>ORCA</strong>: <strong>O</strong>steoartritis y <strong>R</strong>iesgos asociados al <strong>C</strong>onsumo de <strong>A</strong>INEs” </h4></td> 
                      
                      </tr>
                      <tr >
                    <td colspan="3" align="center"><h3><strong>AVISO DE CONFIDENCIALIDAD </strong></h3></td>     
                       
                      
                    
                      </tr>
                      
                      
                      </tr>
                      
                      
                     
                  </tr> 
                      
    </table>
    <div class="row"></div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
            <h6 class="confidencial" align="justify">La información contenida en este documento es propiedad de SCANDINAVIA PHARMA LTDA, salvo que se haya concertado por escrito otro tipo de acuerdo. Al aceptar o revisar este documento, queda usted obligado a respetar su CARÁCTER CONFIDENCIAL, a no revelar esta información a terceros (salvo que la Legislación vigente así lo exija) y a no utilizarla para fines distintos de los autorizados. Si se produce o se sospecha un incumplimiento de esta obligación, debe informarse al DEPARTAMENTO MÉDICO de SCANDINAVIA PHARMA LTDA lo antes posible.</h6>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row"></div>
<?php
    date_default_timezone_set('America/Bogota');
    $fechaActual=date("d-m-Y");
?>       
    
<?php

?>
<div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-3">
        <label for="ex2">Fecha Actual</label>
        <h6><?php echo date("d/m/Y");?><h6>
    </div>
    <div class="col-md-3">
    <label for="ex2">Nombre Médico</label>
    <h6><?= $users[0]['full_name'];?><h6>
    </div>
    <div class="col-md-3">
    <label for="ex2">Ciudad</label>
    <h6><?= $medico[0]['distrito'];?><h6>
    </div>
    <div class="col-md-2">
    <label for="ex2">Codigo Paciente</label>
    <form name="formulario" action="index2.php" method="post"  enctype="multipart/form-data">
     <select class="form-control form-control-lg" style="color:red;" name="selector1" id="selector" required>
        
    </select>
    </div>

</div>
<br>



    <div class="panel" style="border:1px solid #337ab7;" >
                                   <div class="panel-heading text-center form-control" >Criterios Inclusión y Exclusión</div>
                <input type="hidden" name="fechaActual" value="<?php echo date("d/m/Y");?>">                                   
                <input type="hidden" name="nombreMedico" value="<?= $users[0]['full_name'];?>">
                <input type="hidden" name="ciudad" value="Bogota D.C.">
                <input type="hidden" name="estudio" value="ORCA">
                <input type="hidden" id="cedulaMedico" name="cedulaMedico" value="<?= $users[0]['cedula'];?>">
                <input type="hidden" id="campolog" name="cedulalogueada" value="<?=$cedulalogueada?>">
                                            <div class="panel-body" > 
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="card">
                                                        <div class="card-body" >
                                                            <h5 ><strong>Criterios de inclusión</strong></h5>                                                         
                                                            <p class="card-text">
                                                            <ol>
                                                             <li value="1"><h6>Edad ≥18 años </h6></li>
                                                             <li value="2"><h6>Diagnóstico previo de OSTEOARTRITIS (primaria o secundaria) mínimo 30 días antes o más, en al menos una o más de las siguientes localizaciones: Rodilla y/o Cadera y/o Mano, según criterios del American College of Rheumatology (ACR)</h6></li>
                                                             <h5><strong>¿Cumple el paciente con los anteriores criterios de inclusión?</strong></h5>
                                                            </ol>
                                                            <br>
                                                            <div class="col-md-1"></div>                                                            
                                                            <div class="col-md-2">
                                                                <input type="checkbox" value="Si" name="siI" id="si1" onClick="deshabilitarsi(this)">                                                                
                                                            </div>    
                                                            <h6 class="texto">Si</h6>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-2">
                                                                <input type="checkbox" value="No" name="noI" id="no1" onClick="desahibilitarno(this)">                                                                
                                                            </div>    
                                                            <h6 class="texto">No</h6>
                                                            </p>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="card">
                                                        <div class="card-body">
                                                            <h5><strong>Criterios de exclusión</strong></h5>
                                                            <p class="card-text">


                                                            <ol>
                                                             <li value="1"><h6>El paciente HA RECHAZADO la participación en el estudio. </h6></li>
                                                             <li value="2"><h6>Pacientes quienes a juicio del Investigador no comprendan o no estén dispuestos a contestar adecuadamente las preguntas.</h6></li>
                                                             <li value="3"><h6>Enfermedad mental o psiquiátrica que a juicio del investigador impida una adecuada obtención de la información.</h6></li>
                                                             <h5><strong>¿Tiene el paciente alguno de los anteriores criterios de exclusión?</strong></h5>
                                                            </ol>
                                                            <br>
                                                            <div class="col-md-1"></div>                                                            
                                                            <div class="col-md-2">
                                                                <input type="checkbox" value="Si" name="siE" id="si2" onClick="disableUno(this)">                                                                
                                                            </div>    
                                                            <h5 class="texto">Si</h5>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-2">
                                                                <input type="checkbox" value="No" name="noE" id="no2" onClick="disableDos(this)">                                                                
                                                            </div>    
                                                            <h5 class="texto">No</h5>    

                                                            </p>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>           
                                            </div>                          

                                                  
                                          
    </div>

    <div class="panel panel-primary">
                                <div class="panel-heading text-center form-control" >Historia clínica</div>
                                                
                                            <div class="panel-body"> 
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label class="titulo">Datos generales</label>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                                            <div class="col-md-1">
                                                                                <div class="form-group">
                                                                                                    
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-3 ">
                                                                                <div class="form-group">
                                                                                    <label for="ex2">Genero</label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                            <input type="checkbox" required value="Femenino" name="fem" id="fem" onClick="deshabilitarMas(this)"> 
                                                                                        </div>
                                                                                        <h6 class="texto">Femenino</h6>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                            <input type="checkbox" required name="mas" value="Masculino" id="mas"  onClick="deshabilitarFem(this)">
                                                                                        </div>
                                                                                        <h6 class="texto">Masculino</h6>
                                                                                    </div>                                                                                
                                                                                    
                                                                                </div>
                                                                            </div>    
                                                                            
                                                                            <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="ex2" class="titulo1">Antropométricos</label>                                                                                                                         			    			        
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <h6 class="antro"> Peso <strong> (KILOS)</strong></h6>   
                                                                                                <h6 class="antro1">Talla <strong> (CENTÍMETROS)</strong></h6>   
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                <input name="peso"   type="number" required="required" class="form-control" id="peso" min="20" max="300" value=""  minlength="3" />
                                                                                                <br>
                                                                                                <input name="talla"   type="number" required="required" class="form-control" id="talla"  min="100" max="300" value=""  minlength="3"/>
                                                                                                </div>  
                                                                                
                                                                            </div>

                                                                           

                                                                        
                                                                            <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label for="ex2" class="titulo2">Signos vitales</label>                                                                                                                         			    			        
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <h6 class="antro">P.A.Sistólica<br><strong>(mmHg)</strong></h6>   
                                                                                                
                                                                                                <h6 class="antro">P.A.Diastólica<br><strong>(mmHg)</strong></h6>   
                                                                                                </div>
                                                                                                <div class="col-md-5">
                                                                                                <input name="sistolica"   type="number" required="required" class="form-control" id="sistolica"  min="40" max="250" value=""  minlength="3" />
                                                                                                <input name="diastolica"   type="number" required="required" class="form-control" id="diastolica" min="40" max="250" value=""  minlength="3" />
                                                                                                </div>  
                                                                                
                                                                            </div>
                                                                            
                                                                            
                                                </div>                                                            
                                               <br>                         
                                                                                
                                            </div>                          

                                            
                                          
    </div>           
    <div class="panel panel-primary">
                                <div class="panel-heading text-center form-control" >Otros hallazgos</div>
                                                
                                            <div class="panel-body"> 
                                                
                                                <div class="row">
                                                 
                                                    <div class="col-md-12">
                                                     <ul>
                                                         <li >SITIOS CON EVIDENCIA CLÍNICA O PARACLÍNICA de OA según criterios del American College of Rheumatology (ACR):</li>
                                                     </ul>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                                <label for="ex2">Rodilla</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="siro" id="siro" onClick="des2(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="noro" id="noro"  onClick="des1(this)">
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                    <div class="form-group">
                                                                <label for="ex2">Cadera</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="sica" id="sica" onClick="des4(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="noca" id="noca"  onClick="des3(this)">
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                    <div class="form-group">
                                                                <label for="ex2">Mano</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="siman" id="siman" onClick="des6(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="noman" id="noman"  onClick="des5(this)">
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>                       
                                                </div>    
                                                <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                    <ul>
                                                        <li value="-"><h5>¿Alguna OTRA ENFERMEDAD o FACTOR DE RIESGO que tenga el paciente  (DIFERENTE A LO CONTEMPLADO EN EL FORMATO <strong>CUESTIONARIO IMPRESO</strong>)?</h5></li>
                                                    </ul>
                                                    </div>            
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="noH" id="noH" onClick="des8(this)" > 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="siH" id="siH" onClick="des7(this)" >
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>                                                        
                                                </div>    
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <label id='nombreEvento'>Descripción<label>
                                                    </div>
                                                <div class="col-md-6" id="info">
                                                     
                                                     <textarea name='descripcion' class='form-control' id='texto'  style='text-transform:uppercase' rows='4' ></textarea>
          
                                                </div>
                                                </div>
                                                
                                               <br>                         
                                                                                
                                            </div>                          
                                           
                                            
                                          
    </div>   
         <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                    
                                                        <h6>Certifico que tengo conocimiento que mi usuario y contraseña empleados para el diligenciamiento del presente formato y/o archivo son de uso absolutamente personal e intransferible y que he cumplido con los protocolos de seguridad. Al completar el diligenciamiento del presente formato y/o archivo, entiendo, autorizo y certifico su equivalencia con la firma autógrafa para todos los efectos éticos y legales. Igualmente certifico que la información aquí consignada ha sido tomada de los datos de la historia clínica del paciente.</h6>
                                                    
                                                    </div>            
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                                
                                                                                                                                     
                                                                
                                                                                    
                                                        </div>
                                                    </div>                                                        
                                                </div>   
                                                <div class="row">
        <div class="col-md-3" ></div>
        <div class="col-md-1" ></div>
         ACEPTO
        <div class="col-md-1" >
            <input type="checkbox" value="acepto" required name="acep" id="acep" onClick="acepto(this);" >
        </div>
      NO ACEPTO
         <div class="col-md-1">
            <input type="checkbox" value="noacepto" required name="noacep" id="noacep" onClick="noacepto(this);" >
        </div>
          
        <div class="col-md-1"></div>
        
    </div>
   
    <div>
        <div class="col-md-4"></div>
        <div class="col-md-3" id="divcedula">

        </div>
        <div class="col-md-4">
            <div id="alerta">
            <div class="alert alert-success" role="alert" id="alertacedula">
                <h6> Médico válido!</h6>
            </div>
            </div>
            
            <div id="alerta1">
            <div class="alert alert-danger" role="alert" id="alertacedula1">
               <h6> Médico no válido!</h6>
            </div>
            </div>
            
        </div>
        
    </div>
    </div>
     
    
    
    
    
    
    <div class="col-md-9">
            <div class="col-md-7">           
            </div>
    
        <input class="btn btn-primary" id="boton" type="submit" value="Enviar información">
    </div>
    <br>
    <br>

</form> 
                        
            
                        
                  
                  

      

<?php require_once('../../pie.php'); }?>



		
				
