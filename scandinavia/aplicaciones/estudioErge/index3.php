<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

//start session
session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
$parametro = $_REQUEST['id'];
$cedulaAnticipo = $_REQUEST['cedula'];
$cedulaLogueada = $_SESSION['identificacion'];
$sesionLogueada = $_SESSION["user_id"];





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

//get users from empresa
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar

//cabeza de recibo
$conditionscabeza['where'] = array('id_formularioc'=> $parametro,); 
$cabeza = $db->getRows('formulariochaco',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('id_formularioc'=> $cabeza[0]['id_formularioc'],); 
$detalle = $db->getRows('formulariochaco',$conditionsdetalle); //ojo se pone tabla a consultar




//detalle soportes
$sql20= "SELECT
`type`,
`ico`,
identificacion,
consecutivo,
`tipoArchivo`,
`pdf`
FROM
anticipo T1
INNER JOIN rc_mime T2 ON
T1.id_anticipo = " . $parametro;
$Obser=mysqli_query($mysqli, $sql20);
$row_Obser = mysqli_fetch_assoc($Obser);
$rowcount=mysqli_num_rows($Obser);



//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>


<?php require_once('../../cabeza.php'); 


if(!isset($_SESSION["session_username"])) {	
  header("location:../../logininicial.php");
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">


<script src="assets/jquery.maskMoney.js" type="text/javascript"></script>

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
}

function des2(field) {
disableCheck(formulario.sicol, field);
}

function des3(field) {
disableCheck(formulario.nocolh, field);
}

function des4(field) {
disableCheck(formulario.sicolh, field);
}

function des5(field) {
disableCheck(formulario.notri, field);
}
function des6(field) {
disableCheck(formulario.sitri, field);
}
function des7(field) {
disableCheck(formulario.nogli, field);
}
function des8(field) {
disableCheck(formulario.sigli, field);
}
function des9(field) {
disableCheck(formulario.nohe, field);
}


function des10(field) {
   
disableCheck(formulario.sihe, field);
}

function des11(field) {
disableCheck(formulario.nocre, field);
}


function des12(field) {
   
disableCheck(formulario.sicre, field);
}

function des13(field) {
disableCheck(formulario.noac, field);
}


function des14(field) {
   
disableCheck(formulario.siac, field);
}

function des15(field) {
disableCheck(formulario.noal, field);
}


function des16(field) {
   
disableCheck(formulario.sial, field);
}

function des17(field) {
disableCheck(formulario.noH, field);
}


function des18(field) {
   
disableCheck(formulario.siH, field);
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
        document.getElementById("boton").disabled = true;
         
    }  
      
    
}

function disableDos(field) {
;
if(!disableCheck(formulario.si2, field))
    {
        document.getElementById("si1").disabled = false;
        document.getElementById("no1").disabled = false;
        document.getElementById("fem").disabled = false;        
        document.getElementById("mas").disabled = false;
        document.getElementById("peso").disabled = false;
        document.getElementById("talla").disabled = false;  
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
        document.getElementById("boton").disabled = true;
        
    }    
    
}



</script>

		

<script type="text/javascript">
$(document).ready(function(){
    $("#sicol").change(function(){
        var sicol = $(this).val();
        if($("#sicol").prop('checked')){
        if($("#texto8").length === 0){
            $("#valor1").append("<label id='valoreee'>Valor: <label>");
            $("#valor2").append("<input name='colesterol' class='form-control' id='texto8' type='number' step='any'>");
          ;
        }    	
        }else{
            $("#texto8").remove(); 
            $("#valoreee").remove(); 
           

        }
    });
    
});
</script>
		
<script type="text/javascript">
$(document).ready(function(){
    $("#sicolh").change(function(){
        var sicolh = $(this).val();
        if($("#sicolh").prop('checked')){
        if($("#texto1").length === 0){
            $("#valor3").append("<label id='valors'>Valor: <label>");
            $("#valor4").append("<input name='colesterolh' class='form-control' id='texto1' type='number' step='any'>");
          ;
        }    	
        }else{
            $("#texto1").remove(); 
            $("#valors").remove(); 
           

        }
    });
    
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#siH").change(function(){
        var siH = $(this).val();
        if($("#siH").prop('checked')){
        if($("#texto").length === 0){
            $("#info").append("<label id='nombreEvento'>Descripción<label>");
            $("#info").append("<textarea name='descripcion' class='form-control input-sm' id='texto'  style='text-transform:uppercase' rows='4' ></textarea>");
          ;
        }    	
        }else{
            $("#texto").remove(); 
            $("#nombreEvento").remove(); 
           

        }
    });
    
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#sitri").change(function(){
        var sitri = $(this).val();
        if($("#sitri").prop('checked')){
        if($("#texto2").length === 0){
            $("#valor5").append("<label id='valores'>Valor: <label>");
            $("#valor6").append("<input name='trigli' class='form-control' id='texto2' type='number' step='any'>");
          ;
        }    	
        }else{
            $("#texto2").remove(); 
            $("#valores").remove(); 
           

        }
    });
    
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#sigli").change(function(){
        var sigli = $(this).val();
        if($("#sigli").prop('checked')){
        if($("#texto3").length === 0){
            $("#valor7").append("<label id='valores1'>Valor: <label>");
            $("#valor8").append("<input name='gli' class='form-control' id='texto3' type='number' step='any'>");
          ;
        }    	
        }else{
            $("#texto3").remove(); 
            $("#valores1").remove(); 
           

        }
    });
    
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#sihe").change(function(){
        var sihe = $(this).val();
        if($("#sihe").prop('checked')){
        if($("#texto4").length === 0){
            $("#valor9").append("<label id='valores2'>Valor: <label>");
            $("#valor10").append("<input name='hemo' class='form-control' id='texto4' type='number' step='any'>");
          ;
        }    	
        }else{
            $("#texto4").remove(); 
            $("#valores2").remove(); 
           

        }
    });
    
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#sicre").change(function(){
        var sicre = $(this).val();
        if($("#sicre").prop('checked')){
        if($("#texto5").length === 0){
            $("#valor11").append("<label id='valores3'>Valor: <label>");
            $("#valor12").append("<input name='cre' class='form-control' id='texto5' type='number' step='any'>");
          ;
        }    	
        }else{
            $("#texto5").remove(); 
            $("#valores3").remove(); 
           

        }
    });
    
});
</script>


<script type="text/javascript">
$(document).ready(function(){
    $("#siac").change(function(){
        var siac = $(this).val();
        if($("#siac").prop('checked')){
        if($("#texto6").length === 0){
            $("#valor13").append("<label id='valores4'>Valor: <label>");
            $("#valor14").append("<input name='aci' class='form-control' id='texto6' type='number' step='any'>");
          ;
        }    	
        }else{
            $("#texto6").remove(); 
            $("#valores4").remove(); 
           

        }
    });
    
});
</script>


<script type="text/javascript">
$(document).ready(function(){
    $("#sial").change(function(){
        var sial = $(this).val();
        if($("#sial").prop('checked')){
        if($("#texto7").length === 0){
            $("#valor15").append("<label id='valores5'>Valor: <label>");
            $("#valor16").append("<input name='alb' class='form-control' id='texto7' type='number' step='any'>");
          ;
        }    	
        }else{
            $("#texto7").remove(); 
            $("#valores5").remove(); 
           

        }
    });
    
});
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
<div class="alert alert-success" role="alert">
  <h4>Diligenciamiento y envio exitoso!</h4>
</div>
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
                      <td colspan="3" align="center"><h3 ><strong>Estudio Epi-ERGE – 2018 - V01 </strong></h3></td> 
                      
                      </tr>
                         
                      <tr>
                          <td colspan="3" align="center"><h4>“Estudio <strong>Epi-ERGE</strong>: Evaluación <strong>Epi</strong>demiológica en pacientes con <strong>E</strong>nfermedad por <strong>R</strong>eglujo <strong>G</strong>astro-<strong>E</strong>sofático” </h4></td> 
                      
                      </tr>
                      <tr >
                    <td colspan="3" align="center"><h3><strong>AVISO DE CONFIDENCIALIDAD </strong></h3></td>     
                       
                      
                    
                      </tr>
                      
                      
                      </tr>
                      
                      <?php if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
                                                
                                                <?php endforeach; else: ?>
              <tr>
                
              </tr>
              <?php endif; 
			  
			  
			  ?>
                     
                      
                     
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
    <h6><?=$user['fechaActual'];?></h6>
    </div>
    <div class="col-md-3">
    <label for="ex2">Nombre médico</label>
    <h6><?=$user['nombreMedico'];?></h6>
    </div>
    <div class="col-md-3">
    <label for="ex2">Ciudad</label>
    <h6><?=$user['ciudad'];?></h6>
    </div>
    <div class="col-md-2">
    <label for="ex2">Codigo Paciente</label>
    <h6 style="color:red;"><?=$user['codigoPaciente'];?></h6>
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
                                            <div class="panel-body" > 
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="card">
                                                        <div class="card-body" >
                                                            <h5 ><strong>Criterios de inclusión</strong></h5>                                                         
                                                            <p class="card-text">
                                                            <ul>
                                                             <li value="1"><h6>Edad mayor o igual a 18 años. </h6></li>
                                                             <li value="2"><h6>Diagnóstico PREVIO de Enfermedad por Reflujo Gastro-Esofágico (ERGE), de acuerdo con los criterios de diagnóstico establecidos por World Gastroenterology Organisation (WGO), el American College of  Gastroenterology (<strong>ACG</strong>) y las Guías de Asociación Colombiana de Gastroenterología (<strong>ACG</strong>).</h6></li>
                                                             <li value="2"><h6>Tratamiento de la ERGE <strong>[</strong>*Ya sea formulado por un médico o por automedicación; *Ya sea tomando en forma "regular", "irregular" o "a libre demanda"<strong>]</strong>, cumpliendo alguna de las siguientes condiciones:</h6></li>
                                                             <ol>
                                                             <li><strong>CON</strong> tratamiento actual de algún Inhibidor de la Bomba de Protones (IBP), </li>
                                                             <li><strong>SIN</strong> tratamiento actual de algún IBP, PERO SI en el último año</li>
                                                             </ol>
                                                             <h5><strong>¿Cumple el paciente con los anteriores criterios de inclusión?</strong></h5>
                                                            </ul>
                                                            <br>
                                                            <div class="col-md-1"></div>                                                            
                                                            <div class="col-md-2">
                                                                <h6 ><?=$user['siI'];?></h6>
                                                            </div>    
                                                            
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-2">
                                                                <h6 ><?=$user['noI'];?></h6>
                                                            </div>    
                                                            
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
                                                                <h5 ><?=$user['siE'];?></h5>
                                                            </div>    
                                                            
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-2">
                                                                  <h5 ><?=$user['noE'];?></h5>                                                              
                                                            </div>    
                                                               

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
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                                    
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-4 ">
                                                                                <div class="form-group">
                                                                                    <label for="ex2">Genero</label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                            <h6 ><?=$user['fem'];?></h6>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                            <h6 ><?=$user['mas'];?></h6>
                                                                                        </div>
                                                                                        
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
                                                                                                <input name="peso"   type="number" required="required" class="form-control" id="peso" min="20" max="300" value="<?=$user['peso'];?>"  minlength="3" disabled/>
                                                                                                <br>
                                                                                                <input name="talla"   type="number" required="required" class="form-control" id="talla"  min="100" max="300" value="<?=$user['talla'];?>"  minlength="3" disabled/>
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
                                                     
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                    <ul>
                                                        <li value="-"><h5> ENDOSCOPIA: ¿Le han realizado ENDOSCOPIA?</h5></li>
                                                    </ul>
                                                    </div>            
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['noH'];?></h6>     
                                                                    </div>
                                                                   
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['siH'];?></h6>    
                                                                    </div>
                                                                    
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-1"></div>
                                                    <?php
                                                    $usuariosi = $user['siH'];
                                                    if($usuariosi == "Si")
                                                    {
                                                       ?>
                                                       <div class="col-md-9" id="info">
                                                         <label>Descripción:</label>
                                                               <br>
                                                           
                                                    </div>
                                                    
                                                           <div class="col-md-9" id="info2">
                                                            <?=$user['descripcion'];?>
                                                            </div>
                                                    <?php
                                                        
                                                    }
                                                    else
                                                    {
                                                        echo "No aplica";
                                                    }
                                                    ?>
                                                    
                                                </div>    
                                                    
                                                 
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                                <label for="ex2"></label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        
                                                                    </div>
                                                                    <h6 class="texto"></h6>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        
                                                                    </div>
                                                                    <h6 class="texto"></h6>
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                    <div class="form-group">
                                                                <label for="ex2"></label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        
                                                                    </div>
                                                                    <h6 class="texto"></h6>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        
                                                                    </div>
                                                                    <h6 class="texto"></h6>
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                    <div class="form-group">
                                                                <label for="ex2"></label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        
                                                                    </div>
                                                                    <h6 class="texto"></h6>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        
                                                                    </div>
                                                                    <h6 class="texto"></h6>
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>                       
                                                </div>    
                                                                                                   
                                               <br>                         
                                                                                
                                            </div>                          

                                            
                                          
    </div>            
            
    
   <div class="col-md-3"></div>
<div class="col-md-1"></div>
<div class="col-md-1"></div>
<div class="col-md-3">
    <h4 style='text-decoration:none;color:black;'>Generar pdf</h4>
     <td><?php echo "<a href=\"" . $user['archivo'] . " \"target=\"\_blank\">";echo "<img src=\"/scandinavia/assets/images/ico/ico_pdf.png\" alt=\"" . $row_Obser['archivo']. "\" width=\"60\" height=\"60\" />"; ?></td>  
</div>    
                            
    </div>
    
                                  
                                               <br>                         
                                                                                
                                            </div>                          

                                            
                                          
    </div>            
                                    
    </div>
  
</form> 
                       
            
                        
                  
                  

      

<?php require_once('../../pie.php'); }?>



		
				
