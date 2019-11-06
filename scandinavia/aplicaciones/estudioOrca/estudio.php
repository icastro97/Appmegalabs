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

 $conditions['where'] = array('u_userid'=> $id,); 
$users = $db->getRows('system_users',$conditions); //ojo se pone tabla a consultar



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
	
function medico(j) {
            $("#identificacion").autocomplete({
                source: "buscarmedico.php",
                minLength: 2,
                select: function(event, ui) {  
					event.preventDefault();
					
					$('#identificacion').val(ui.item.Documento);
					$('#nombre').val(ui.item.NombreMedico);
					$("#estudios").focus();
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
		$('#nombre').val(data.NombreMedico);
        $("#estudios").focus();
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
            	    <td colspan="3" align="center"><h3>Asignación de Pacientes</h3></td>
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
             
               <form id="my-form" method="post" action="estudio2.php"  name="insertregistro" enctype="multipart/form-data">
                
                        
            	
               
                    <div class="panel-body"> 
                            <?php
                            date_default_timezone_set('America/Bogota');
                            $fechaActual=date("d-m-Y");
                            ?>
                            <div class="row">
                                
                                                             <div class="col-md-1">
                                                                            <div class="form-group">
                                                                            
            			    			                                    <input class="form-control" type="hidden" name="fechaActual" id="fecha" readonly="readonly" value="<?= $fechaActual?>"/> 
                                                                            </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Documento Médico</label>
                                        			    			        <input name="identificacion"  id="identificacion" onKeyUp="medico(1)"  onBlur="empleado2(1)" type="text" required="required" class="form-control" id="identificacion"  placeholder="Documento"/>
                                                                            </div>
                                                                
                                                            </div>
                                                           
                                                             <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Nombre Médico</label>
                                        			    			        <input name="nombre" type="text" required="required" class="form-control" id="nombre"  placeholder="Nombre" value=""/>
                                                                            </div>
                                                                
                                                            </div>
                             
                                                             <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Estudio:</label>
                                                                                <div class="input-group">
                                                                                    <select class="form-control form-control-lg" id="estudios" name="estudios">
                                                                                      <option>ORCA</option>
                                            			    			            <option>EPI-ERGE</option>
                                            			    			            <option>CHACO</option>
                                                                                    </select>
                                            			    			        
                                            		    			            </div>
                                                                            </div>
                                                                
                                                            </div>
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Codigo Paciente</label>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo">
                                            			    			        
                                            		    			            </div>
                                                                            </div>
                                                                
                                                            </div>
                            </div>
                          
                            
                            <tr>
                              <td><br />
                                <br />
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>" />
            <input type="hidden" name="ultimoinserted" id="ultimoinserted" value="" /> 
            <center>
            <input name="input" type="submit" id="buttonsave"  class=" btn btn-primary" value="Asignar paciente" /> 
            </center>
            
            
            
            </td>
                            </tr>
                          
                          
                            
                  

      

<?php require_once('../../pie.php'); }?>



		
				
