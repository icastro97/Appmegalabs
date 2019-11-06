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



<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>


       

		

<script type="text/javascript">
$(document).ready(function(){
     $('#valor1').hide();
     $('#valor2').hide();
     $('#valor3').hide();       
     $('#valor4').hide();
     $('#valor5').hide();       
     $('#valor6').hide();
     $('#valor7').hide();       
     $('#valor8').hide();
     $('#valor9').hide();
     $('#valor10').hide();
     $('#valor11').hide();
     $('#valor12').hide();
     $('#valor13').hide();
     $('#valor14').hide();
     $('#valor15').hide();
     $('#valor16').hide();
     $('#info').hide();
     $('#info2').hide();
       $('#divcedula').hide();
       $('#alerta').hide();
        $('#alerta1').hide();
   
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


function colesterol()
{
    if($("#sicol").prop('checked')){
        $('#valor1').show();
        $('#valor2').show();
    }
    else
    {
        $('#valor1').hide();
        $('#valor2').hide();
    }
}


function colesterolh()
{
    if($("#sicolh").prop('checked')){
        $('#valor3').show();
        $('#valor4').show();
    }
    else
    {
        $('#valor3').hide();
        $('#valor4').hide();
    }
}


function tri()
{
    if($("#sitri").prop('checked')){
        $('#valor5').show();
        $('#valor6').show();
    }
    else
    {
        $('#valor5').hide();
        $('#valor6').hide();
    }
}

function gli()
{
    if($("#sigli").prop('checked')){
        $('#valor7').show();
        $('#valor8').show();
    }
    else
    {
        $('#valor7').hide();
        $('#valor8').hide();
    }
}

function hemo()
{
    if($("#sihe").prop('checked')){
        $('#valor9').show();
        $('#valor10').show();
    }
    else
    {
        $('#valor9').hide();
        $('#valor10').hide();
    }
}

function cre()
{
    if($("#sicre").prop('checked')){
        $('#valor11').show();
        $('#valor12').show();
    }
    else
    {
        $('#valor11').hide();
        $('#valor12').hide();
    }
}


function aci()
{
    if($("#siac").prop('checked')){
        $('#valor13').show();
        $('#valor14').show();
    }
    else
    {
        $('#valor13').hide();
        $('#valor14').hide();
    }
}

function alb()
{
    if($("#sial").prop('checked')){
        $('#valor15').show();
        $('#valor16').show();
    }
    else
    {
        $('#valor15').hide();
        $('#valor16').hide();
    }
}


function des()
{
    if($("#siH").prop('checked')){
        $('#info').show();
        $('#info2').show();
    }
    else
    {
        $('#info').hide();
        $('#info2').hide();
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






<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



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
disableCheck(formulario.nocol, field);
colesterol();
}

function des2(field) {
disableCheck(formulario.sicol, field);
$('#valor1').hide();
$('#valor2').hide();
}

function des3(field) {
disableCheck(formulario.nocolh, field);
 colesterolh();
}

function des4(field) {
disableCheck(formulario.sicolh, field);
$('#valor3').hide();
$('#valor4').hide();
}

function des5(field) {
disableCheck(formulario.notri, field);
tri();
}
function des6(field) {
disableCheck(formulario.sitri, field);
$('#valor5').hide();
$('#valor6').hide();
}
function des7(field) {
disableCheck(formulario.nogli, field);
gli();
}
function des8(field) {
disableCheck(formulario.sigli, field);
$('#valor7').hide();
$('#valor8').hide();
}
function des9(field) {
disableCheck(formulario.nohe, field);
hemo();
}


function des10(field) {
   
disableCheck(formulario.sihe, field);
$('#valor9').hide();
$('#valor10').hide();
}

function des11(field) {
disableCheck(formulario.nocre, field);
cre();
}


function des12(field) {
   
disableCheck(formulario.sicre, field);
$('#valor11').hide();
$('#valor12').hide();
}

function des13(field) {
disableCheck(formulario.noac, field);
aci();
}


function des14(field) {
   
disableCheck(formulario.siac, field);
$('#valor13').hide();
$('#valor14').hide();
}

function des15(field) {
disableCheck(formulario.noal, field);
alb();
}


function des16(field) {
   
disableCheck(formulario.sial, field);
$('#valor14').hide();
$('#valor15').hide();
}

function des17(field) {
disableCheck(formulario.noH, field);
des();
}


function des18(field) {
   
disableCheck(formulario.siH, field);
$('#info').hide();
$('#info2').hide();
}

function deshabilitarFem(field) {
disableCheck(formulario.fem, field);
}

function deshabilitarMas(field) {
   
disableCheck(formulario.mas, field);
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
           document.getElementById("nocol").disabled = false;
        document.getElementById("sicol").disabled = false;                    
        document.getElementById("sicolh").disabled = false;
        document.getElementById("nocolh").disabled = false;
        document.getElementById("notri").disabled = false;
        document.getElementById("sitri").disabled = false;
        document.getElementById("nogli").disabled = false;
        document.getElementById("sigli").disabled =false;
        document.getElementById("nohe").disabled = false;
        document.getElementById("sihe").disabled = false;
        document.getElementById("nocre").disabled = false;
        document.getElementById("sicre").disabled = false;
        document.getElementById("noac").disabled = false;
        document.getElementById("siac").disabled = false;
        document.getElementById("noal").disabled = false;
        document.getElementById("sial").disabled = false;
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
           document.getElementById("nocol").disabled = true;
        document.getElementById("sicol").disabled = true;                    
        document.getElementById("sicolh").disabled = true;
        document.getElementById("nocolh").disabled = true;
        document.getElementById("notri").disabled = true;
        document.getElementById("sitri").disabled = true;
        document.getElementById("nogli").disabled = true;
        document.getElementById("sigli").disabled = true;
        document.getElementById("nohe").disabled = true;
        document.getElementById("sihe").disabled = true;
        document.getElementById("nocre").disabled = true;
        document.getElementById("sicre").disabled = true;
        document.getElementById("noac").disabled = true;
        document.getElementById("siac").disabled = true;
        document.getElementById("noal").disabled = true;
        document.getElementById("sial").disabled = true;
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
         
           document.getElementById("nocol").disabled = false;
        document.getElementById("sicol").disabled = false;                    
        document.getElementById("sicolh").disabled = false;
        document.getElementById("nocolh").disabled = false;
        document.getElementById("notri").disabled = false;
        document.getElementById("sitri").disabled = false;
        document.getElementById("nogli").disabled = false;
        document.getElementById("sigli").disabled =false;
        document.getElementById("nohe").disabled = false;
        document.getElementById("sihe").disabled = false;
        document.getElementById("nocre").disabled = false;
        document.getElementById("sicre").disabled = false;
        document.getElementById("noac").disabled = false;
        document.getElementById("siac").disabled = false;
        document.getElementById("noal").disabled = false;
        document.getElementById("sial").disabled = false;
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
        document.getElementById("nocol").disabled = true;
        document.getElementById("sicol").disabled = true;                    
        document.getElementById("sicolh").disabled = true;
        document.getElementById("nocolh").disabled = true;
        document.getElementById("notri").disabled = true;
        document.getElementById("sitri").disabled = true;
        document.getElementById("nogli").disabled = true;
        document.getElementById("sigli").disabled = true;
        document.getElementById("nohe").disabled = true;
        document.getElementById("sihe").disabled = true;
        document.getElementById("nocre").disabled = true;
        document.getElementById("sicre").disabled = true;
        document.getElementById("noac").disabled = true;
        document.getElementById("siac").disabled = true;
        document.getElementById("noal").disabled = true;
        document.getElementById("sial").disabled = true;
        document.getElementById("siH").disabled = true;
        document.getElementById("noH").disabled = true;
        document.getElementById("boton").disabled = true;
        
    }    
    
}



</script>

<script type="text/javascript">
  $(document).ready(function() {
      paciente();
      
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
    margin-left:2px;
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
                      <td colspan="3" align="center"><h3 ><strong>Estudio CHACO – 2018 - V01 </strong></h3></td> 
                      
                      </tr>
                         
                      <tr>
                          <td colspan="3" align="center"><h4>“Estudio <strong>CHACO</strong>: <strong>C</strong>ontrol de la <strong>H</strong>ipertensión <strong>A</strong>rterial en pacientes <strong>CO</strong>lombianos” </h4></td> 
                      
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
    <div class="col-md-2" id="cod">
    <label for="ex2">Codigo Paciente</label>
    <form name="formulario" action="index2.php" method="post"  enctype="multipart/form-data">
    <select class="form-control form-control-lg" style="color:red;" name="selector1" id="selector">
        
    </select>
    </div>

</div>
<br>



    <div class="panel" style="border:1px solid #337ab7;" >
                                   <div class="panel-heading text-center form-control" >Criterios Inclusión y Exclusión</div>
                <input type="hidden" name="fechaActual" value="<?php echo date("d/m/Y");?>">                                   
                <input type="hidden" name="nombreMedico" value="<?= $users[0]['full_name'];?>">
                <input type="hidden" name="ciudad" value="Bogota D.C.">
                <input type="hidden" name="estudio" value="CHACO">
                <input type="hidden" id="cedulaMedico" name="cedulaMedico" value="<?= $users[0]['cedula'];?>">
                <input type="hidden" id="campolog" name="cedulalogueada" value="<?=$cedulalogueada?>">
                                            <div class="panel-body" > 
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="card">
                                                        <div class="card-body" >
                                                            <h5 ><strong>Criterios de inclusión</strong></h5>                                                         
                                                            <p class="card-text">
                                                            <ul>
                                                             <li value="1"><h6>Edad mayor o igual a 18 años. </h6></li>
                                                             <li value="2"><h6>Diagnóstico PREVIO de Hipertensión Arterial:  Diagnóstico realizado ≥ 3 meses antes.</h6></li>
                                                             <li value="2"><h6>Pacientes que se encuentren bajo tratamiento farmacológico de la HTA ≥ 3 meses antes.</h6></li>
                                                             <h5><strong>¿Cumple el paciente con los anteriores criterios de inclusión?</strong></h5>
                                                            </ul>
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


                                                            <ul>
                                                             <li value="1"><h6>El paciente HA RECHAZADO la participación en el estudio. </h6></li>
                                                             <li value="2"><h6>Pacientes quienes a juicio del Investigador no comprendan o no estén dispuestos a contestar adecuadamente las preguntas.</h6></li>
                                                             <li value="3"><h6>Enfermedad mental o psiquiátrica que a juicio del investigador impida una adecuada obtención de la información.</h6></li>
                                                             <h5><strong>¿Tiene el paciente alguno de los anteriores criterios de exclusión?</strong></h5>
                                                            </ul>
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
                                                         <li >VALORES DE ÚLTIMOS PARACLÍNICOS (<font color="blue">Favor registrar SOLO los que haya disponibles.....</font><font color="red">EN CASO DE NO ESTAR DISPONIBLES,  COLOCAR  "NO"</font>):</li>
                                                     </ul>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4" >
                                                        <div class="form-group">
                                                                <label for="ex2">Colesterol Total(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="nocol" id="nocol" onClick="des2(this)"> 
                                                                        
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                             
                                                                 
                                                              
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="sicol" id="sicol"  onClick="des1(this)" onChange="colesterol()">
                                                                        
                                                                    </div>
                                                                    
                                                                    <h6 class="texto">Si</h6>
                                                                    
                                                                <div class="col-md-2"  id="valor1">
                                                                    <label id="valor23">Valor: </label>
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor2"><input type="number" id="colesterol" class="form-control" name="colesterol" step="any"></div>
                                                                   
                                                                   
                                                              
                                                                  
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4" >
                                                    <div class="form-group">
                                                                <label for="ex2">Colesterol HDL(md/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="nocolh" id="nocolh" onClick="des4(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                
                                                                
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="sicolh" id="sicolh"  onClick="des3(this)" onChange="colesterolh()">
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                      <div class="col-md-2"  id="valor3">
                                                                          <label id="valor23">Valor: </label>
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor4"><input type="number" id="colesterolh" class="form-control" name="colesterolh" step="any"></div>
                                                                   
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                        
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-md-12">
                                                    
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Triglicéridos (mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="notri" id="notri" onClick="des6(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="sitri" id="sitri"  onClick="des5(this)" onChange="tri()">
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                     <div class="col-md-2"  id="valor5">
                                                                         <label id='valores'>Valor: <label>
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor6"><input name='trigli' class='form-control' id='texto2' type='number' step='any'></div>
                                                                   
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>                       
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Glicemia ayunas(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="nogli" id="nogli" onClick="des8(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="sigli" id="sigli"  onClick="des7(this)" onChange="gli()">
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                     <div class="col-md-2"  id="valor7">
                                                                         <label id='valores1'>Valor: <label>
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor8"><input name='gli' class='form-control' id='texto3' type='number' step='any'></div>
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>     
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Hemoglobina glicosilada(%)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="nohe" id="nohe" onClick="des10(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="sihe" id="sihe"  onClick="des9(this)">
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                     <div class="col-md-2"  id="valor9">
                                                                         <label id='valores2'>Valor: <label>
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor10"><input name='hemo' class='form-control' id='texto4' type='number' step='any'></div>
                                                                   
                                                                   
                                                              
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Creatinina(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="nocre" id="nocre" onClick="des12(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="sicre" id="sicre"  onClick="des11(this)">
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                     <div class="col-md-2"  id="valor11">
                                                                         <label id='valores3'>Valor: <label>
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor12"><input name='cre' class='form-control' id='texto5' type='number' step='any'></div>
                                                               
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div> 
                                                    
                                               </div>
                                               <div class="row">
                                                    <div class="col-md-12">
                                                    
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Ácido Urico(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="noac" id="noac" onClick="des14(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="siac" id="siac"  onClick="des13(this)">
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                     <div class="col-md-2"  id="valor13">
                                                                         <label id='valores3'>Valor: <label>
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor14"><input name='aci' class='form-control' id='texto5' type='number' step='any'></div>
                                                                   
                                                                </div>                                           
                                                                
                                                                                    
                                                        </div>
                                                        
                                                    </div> 
                                                    
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Albuminuria/Proteinuria(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="No" required name="noal" id="noal" onClick="des16(this)"> 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="sial" id="sial"  onClick="des15(this)">
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                     <div class="col-md-2"  id="valor15">
                                                                         <label id='valores5'>Valor: <label>
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor16"><input name='alb' class='form-control' id='texto7' type='number' step='any'></div>
                                                                   
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
                                                                        <input type="checkbox" value="No" required name="noH" id="noH" onClick="des18(this)" > 
                                                                    </div>
                                                                    <h6 class="texto">No</h6>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <input type="checkbox" value="Si" required name="siH" id="siH" onClick="des17(this)" >
                                                                    </div>
                                                                    <h6 class="texto">Si</h6>
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>                                                        
                                                </div>  
                                                </div>
                                                <div class="col-md-1"></div>
                                                  
                                                    <div class="col-md-3" id="info">
                                                           <label id="nombreEvento">Descripción: <label>
                                                              
                                                    </div>
                                                     <div class="col-md-6" id="info2">
                                                            <textarea name="descripcion" class="form-control input-sm" id="descripcion"  style="text-transform:uppercase" rows="4" ></textarea>
                                                            </div>
                                                           
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



		
				
