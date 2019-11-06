<?php
//start session
session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';




//get user data
if(!empty($_GET['id'])){
	include '../mcv5/clases/DB.class.php';		
	$db = new DB();
	$conditions['where'] = array(
		'id' => $_GET['id'],
	);
	$conditions['return_type'] = 'single';
	$userData = $db->getRows('x2_contacts', $conditions); //ojo se pone tabla a consultar
}

$actionLabel = !empty($_GET['id'])?'Editar':'Agregar';

//get status message from session
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
  header("location:../logininicial.php");  
} 
else {?>




<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}

.embed-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}
.embed-container iframe {
    position: absolute;
    top:0;
    left: 0;
    width: 100%;
    height: 100%;
}

  #canvas
    {
        position: relative;
        width:37%;
        margin: 0 auto; 
        margin-left: 10%;
        margin-top:-3%;
        
    }
    
    #guardar
    {
        
        margin: 0;
        margin-left:0%;
        margin-top:0%;
    }
    
    #boton1
    {
        margin:0;
        margin-top:50%;
        
    }
    
    
@media screen and (max-width: 400px) 
{
  #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
        
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}



@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
    
   #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
        
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* Smartphones (landscape) */
@media only screen 
and (min-width : 321px) {
 
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
        
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* Smartphones (portrait) */
@media only screen 
and (max-width : 320px) {
 
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* iPads (portrait & landscape) */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) {
 
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* iPads (landscape) */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : landscape) {
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /*max-width: 92%;*/
        /*min-width: auto;*/
        width: 37%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -1%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-3%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-3%;
    }
}
 
/* iPads (portrait) */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : portrait) {
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /*max-width: 92%;*/
        /*min-width: auto;*/
        width: 37%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -1%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* Ordenadores de sobremesa y port芍tiles */
@media only screen 
and (min-width : 1224px) {
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
    
}
 
/* Pantallas grandes */
@media only screen 
and (min-width : 1824px) {
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        
        width: 37%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: 1%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-3%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-3%;
    }
}
 
/* iPhone 4 */
@media
only screen and (-webkit-min-device-pixel-ratio : 1.5),
only screen and (min-device-pixel-ratio : 1.5) {
 #canvas
    {
           /* position: absolute; */
        position: relative;
        max-width: 36%;
        /* min-width: auto; */
        width: 50%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: 0%;
        border-bottom: 1px solid #CCC;
        
    }
    

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}

@media screen and (max-width: 560px) 
{
  #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
        
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
      
}

@media screen and (max-width: 800px) 
{
  
      
}



.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
	color: white;
}
</style>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script>
$(document).ready(function() {
    
   document.getElementById('boton').disabled = true;
   $('#archivo').hide();
   $('#archivo1').hide();
   $('#alerta').hide();
   $('#ced').hide();	
   $('#doc').hide();	
  
   
   
});    
    
     function medico() {
        
            let nombre = $('#nombremedico').val();
            
            if( nombre != '')
            {
                $("#nombremedico").autocomplete({
                    source: "buscar.php?denti="+$('#ident').val(),
                    minLength: 2,
                    cache: false,
                    select: function(event, ui) {
                        
    					event.preventDefault();
    					
    					$('#nombremedico').val(ui.item.value);
    					$('#codigom').val(ui.item.id_cliente);
                        $("#opc").focus();
                        document.getElementById('boton').disabled = false;  
                        $('#alerta').hide();
    			    }
                });
                
                
            }
            else 
            {
                document.getElementById('codigom').value = "";
                document.getElementById('boton').disabled = true;
                $("#nombremedico").focus();
                
                
            }
                
            
		};
	
	
	
   
	
	
function medico2(j) {
//Disparar funcion al hacer clic en el boton Ajax
        $('#nombremedico').blur(function () {
        	var x = $("#nombremedico").val();
        
          //llamada ajax
          $.ajax({
        	data: {var1: x} ,
        	cache: false,
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
        		$('#codigom').val(data.value);
        		$('#cod').val(data.value);
        		$("#opc").focus(); 
                validacion();
                validacionCodigo();
            })
            
 });
 
};
	
	function validacion()
	{
	    let codigo = $('#codigom').val();
	    if(codigo == "")
            {
               $('#alerta').show();
               $('#textoConsentimiento').hide();	
               $('#textoCodigo').hide();	
               $('#xd').hide();
                document.getElementById('boton').disabled = true; 
                document.getElementById('codigom').disabled = true;
            }
            else
            {
                $('#alerta').hide();
                $('#textoConsentimiento').show();	
                $('#textoCodigo').show();	
                $('#xd').show();
                document.getElementById('boton').disabled = false;
                document.getElementById('codigom').disabled = true;  
                 
            }
	}
	
	
	
	function check()
	{
       
	    var isChecked = document.getElementById('datos').checked;
        if(isChecked)
        {
            $('#archivo').show();  
        }
        else
        {
            $('#archivo').hide();  
        }
   
	}
	
	function check1()
	{
       
	    var isChecked1 = document.getElementById('datos3').checked;
        if(isChecked1)
        {
            $('#archivo1').show();  
            document.getElementById("archivo1").required = true;
        }
        else
        {
            $('#archivo1').hide(); 
            document.getElementById("archivo1").required = false;
        }
   
	}
	
	$(function () {
	
	$('#cedula').keyup(function() {
		if($('#cedula').val())
		{
			let cedulaMedico = $('#cedula').val();
			$.ajax({
				url:'cedulaMedico.php',
				type: 'POST',
				data: {cedulaMedico},
				cache: false,
				success: function (response) {
					let datos = JSON.parse(response);
					let template = '';
						datos.forEach(dato => {
						template += `
						
						<div id="alerta">
    						<div class="alert alert-success" role="alert"> 
    						    <h5>Cedula ya registrada en el sistema</h5> 
    						</div>
						</div>
						<h5>Tratamiento de datos: ${dato.tratamientoDatos}</h5>
						<h5>Envío de publicidad: ${dato.publicidad}</h5>
						<h5>Envío de material cientifico: ${dato.materialCientifico}</h5>
						<h5>Transferencia de valor: ${dato.transferenciaValor}</h5>
						
						
						
						<input type='text' name="tratamiento" value='${dato.tratamientoDatos}'>
						<input type='text' name="publicidad" value='${dato.publicidad}'>
						<input type='text' name="material" value='${dato.materialCientifico}'>
						<input type='text' name="transferencia" value='${dato.transferenciaValor}'>
						
						<input type='submit' class='btn btn-success' name="cruce" value='Cruzar'>
						`
						
					
					});

					if(template === "")
					{
						$('#alertacedula').html("<div id='alerta'><div class='alert alert-danger' role='alert'> <h5>Cedula no registrada en el sistema</h5> <a href='https://appmegalabs.com/scandinavia/aplicaciones/firma/tipoConsentimiento.php?op=Consentimiento' class='btn btn-success'>Crear Consentimiento</a> </div>   </div> <h5>Tratamiento de datos: No registra </h5><h5>Envío de publicidad: No registra </h5><h5>Envío de material cientifico: No registra </h5><h5>Transferencia de valor: No registra </h5>");
						
					}
					else
					{
						
						$('#alertacedula').html(template);	
					}
					
				}
			})
		}
		else
		{
			console.log("No hay nada");
		}
	})
	 
    });
	function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}




    function validacionCodigo()
    {
        let codigoMedico = $('#cod').val();
        if(codigoMedico)
		{
			$.ajax({
				url:'codigoMedico.php',
				type: 'POST',
				data: {codigoMedico},
				cache: false,
				success: function (response) {
					let datos = JSON.parse(response);
					let template = '';
					
						datos.forEach(dato => {
						template += `<h5>Tratamiento de datos: ${dato.tratamientoDatos}</h5><h5>Envío de publicidad: ${dato.publicidad}</h5><h5>Envío de material cientifico: ${dato.materialCientifico}</h5><h5>Transferencia de valor: ${dato.transferenciaValor}</h5>`
						$('#ced').hide();	
				        $('#doc').hide();
					});

				    if(template)
				    {
						$('#textoCodigo').show();
				        $('#textoCodigo').html("<div class='alert alert-success' role='alert'> <h5>Este código ya cuenta con consentimiento</h5></div>");
						$('#xd').html(template);	
						$('#ced').hide();	
			            $('#doc').hide();
						
				    }
				    else if(template === "")
				    {
				        $('#textoCodigo').html("<div id='alerta'><div class='alert alert-danger' role='alert'> <h5>Este código no cuenta con consentimiento</h5> </div></div>");
						$('#ced').show();	
			            $('#doc').show();
			            $('#xd').html(template);
				    }
					
				}
			})
		}
		else
		{
		    $('#textoCodigo').html("<div id='alerta'><div class='alert alert-danger' role='alert'> <h5>Este código no cuenta con consentimiento</h5> </div></div>");   
		    $('#ced').hide();	
			$('#doc').hide();
		}
		
    }
    

    
    
    
    
    
    
    
    
</script>


<script src="https://oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<!DOCTYPE html>
<html>



<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    
   
</head>


<body>
<div class="container">
    <a href="http://appmegalabs.com/scandinavia/default1.php?group=Documentos" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
    <br>
    <br>
    <br>
    <div class="panel" style="border:1px solid #00AB84;">
            <div class="panel-heading text-center form-control" >Consentimiento informado</div>
            <div class="panel-body">  
                     
                                <!--Inicio de la firma-->
                                                    
                                                    
                                                    
                                                    <!-- creamos el form para el envio -->
                                                    <form  method='post' action='cruce.php' enctype="multipart/form-data">
                                                        <div class="row">
                                                           
                                                            <div class="col-md-2">
                                                                 
                                                                
                                                            </div>
                                                            <div class="col-md-4">
                                                                 <label for="documento">Nombre del médico:</label>
                                                                 
                                                                <input type="text" class="form-control" name="nombrem" id="nombremedico" onKeyUp="medico()" onBlur="medico2(1)" placeholder="Nombre del medico">
                                                                <div id="alerta">
                                                                    <div class="alert alert-danger" role="alert">
                                                                      <h5>Por favor digite un médico válido..</h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                 <label for="documento">Codigo del médico:</label>
                                                                <input type="text" class="form-control" name="codigos" id="codigom"  placeholder="Codigo" onchange="validacion()">
                                                                <input type="hidden" class="form-control" name="cod" id="cod"  placeholder="Codigo" onchange="validacion()">
                                                                
                                                            </div>
                                                            <div class="col-md-2" id="textoCodigo">
                                                                
                                                            </div>
                                                            <div class="col-md-2" id="textoConsentimiento">
                                                            </div>
                                                        </div>
                                                        
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-3" id="doc">
                                                                            <div class="form-group">
                                                                            <label for="documento">Tipo de documento:</label> 
                                                                            <select name="opcion" id="opc" class="form-control input-sm" style="height: 40px; width:180px;" required>
                                                                                <option value="">Seleccione una opción..</option>
                                                                                <option value="CC">Cedula de ciudadania</option>
                                                                                <option value="CE">Cedula de extranjeria</option>
                                                                            </select>
                                                                            </div>
                                                                            
                                                            </div>
                                                            
                                                            <div class="col-md-4" id="ced">
                                                                            <div class="form-group">
                                                                            <label for="cedula">Cedula:</label> 
                                                                            <input type="text" id="cedula" name="cedula" placeholder="Cedula" class="form-control" onkeypress="validate(event)" required >
                                                                            
                                                                            <div id="alertacedula">
                                                                                
                                                                            </div>
                                                                            
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                            <div id="xd">
                                                            
                                                            </div>
                                                            </div>
                                                        
                                                        
                                                         <div  class="col-md-5"></div>
                                                         <div class="col-md-5" >
                                                             <br>
                                                                        <input type="hidden" name="ide" id="ident" value="<?= $_SESSION['identificacion']?>">
                                                                       <input class="btn" style="background-color:#00AB84; color:white;" name= "boton" id="boton" type="hidden" value="Enviar">
                                                                              
                                                         </div>   
                                                          
                                                            

                                                                
                                                        </form>
                                                        
          
        </div>
          
    </div>
</div>


</body>
</html>
<style type="text/css">
.container{padding: 10px;}
.glyphicon{font-size: 20px;}
.glyphicon-arrow-left{float: right;}
a.glyphicon{text-decoration: none;}
</style>
 

<?php require_once('../../pie.php'); }?>


