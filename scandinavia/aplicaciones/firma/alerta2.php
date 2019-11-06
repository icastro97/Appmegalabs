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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    alertaBuena();
   document.getElementById('boton').disabled = true;
   $('#archivo').hide();
   $('#archivo1').hide();
   $('#alerta').hide();
   $('#alert').hide();
   $('#alert1').hide();
   
  
   
   
});    
    
     function medico() {
        
            let nombre = $('#nombremedico').val();
            
            if( nombre != '')
            {
                $("#nombremedico").autocomplete({
                    source: "buscar.php?denti="+$('#ident').val(),
                    minLength: 2,
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
                validacionConsentimiento();
            })
            
 });
 
};
	
	function validacion()
	{
	    let codigo = $('#codigom').val();
	    if(codigo == "")
            {
               $('#alerta').show();
                document.getElementById('boton').disabled = true; 
                document.getElementById('codigom').disabled = true;
            }
            else
            {
                $('#alerta').hide();
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
	
    function validacionConsentimiento()
    {
        let codigom = $('#codigom').val();
        $.ajax({
          url:'consulta1.php',
          data:{codigom},
          type: "POST",
          success: function (response)
          {
             if(response == "ok")
             {
                swal('Informacion', 'Este codigo ya cuenta con consentimiento','error');
             }
             else
             {
                swal('Informacion', 'Este codigo no cuenta con consentimiento','success');
             }
          }
        }); 
    }
	
	function alertaBuena()
    {   
        swal('Información','No se agrego la información','error').then((success)=>{ window.location = 'indexFisico.php';});
    }
</script>


<script src="https://oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<!DOCTYPE html>
<html>



<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    
   
</head>


<body>
<div class="container">
    <a href="https://appmegalabs.com/scandinavia/default1.php?group=Documentos" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
    <br>
    <br>
    <br>
    <div class="panel" style="border:1px solid #00AB84;">
            <div class="panel-heading text-center form-control" >Consentimiento informado</div>
            <div class="panel-body">  
                     
                                <!--Inicio de la firma-->
                                                    
                                                    
                                                    
                                                    <!-- creamos el form para el envio -->
                                                    <form  method='post' action='indexFisico2.php' enctype="multipart/form-data">
                                                        <div class="row">
                                                           
                                                            <div class="col-md-2">
                                                                 
                                                                
                                                            </div>
                                                            <div class="col-md-5">
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
                                                            <div class="col-md-1">
                                                                 
                                                                
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="documento">Tipo de documento:</label> 
                                                                            <select name="opcion" id="opc" class="form-control input-sm" style="height: 40px; width:180px;" required>
                                                                                <option value="">Seleccione una opción..</option>
                                                                                <option value="CC">Cedula de ciudadania</option>
                                                                                <option value="CE">Cedula de extranjeria</option>
                                                                            </select>
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                            <div class="form-group">
                                                                            <label for="cedula">Cedula:</label> 
                                                                            <input type="text" id="cedula" required name="cedula" placeholder="Cedula" class="form-control" >
                                                                            </div>
                                                                            
                                                                            
                                                            </div>
                                                            <div class="col-md-2">
                                                                
                                                            </div>
                                                            <div class="col-md-2">
                                                                
                                                            </div>
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="nombres">Primer nombre:</label>
                                                                            <input type="text" required name="nombreP"  placeholder="Primer nombre" class="form-control" required>
                                                                            </div>
                                                                
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="nombres">Segundo nombre:</label>
                                                                            <input type="text"  name="nombreS"  placeholder="Segundo nombre" class="form-control">
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="nombres">Primer apellido:</label>
                                                                            <input type="text" required name="apellidoP"  placeholder="Primer apellido" class="form-control" required>
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="nombres">Segundo apellido:</label>
                                                                            <input type="text"  name="apellidoS"  placeholder="Segundo apellido" class="form-control">
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                          
                                                            </div>
                                                            <div class="col-md-2">
                                                                          
                                                            </div>
                                                             <div class="col-md-4">
                                                                            <div class="form-group">
                                                                            <label for="Correo electronico">Correo electronico:</label>
                                                                            <input type="email" name="correo" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required placeholder="Correo electronico" class="form-control">
                                                                            <!--pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"!-->
                                                                            </div>
                                                                
                                                            </div>
                                                             <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="Telefono">Teléfono(opcional):</label>
                                                                            <input type="text" name="telefono" placeholder="Telefono" class="form-control" >
                                                                            </div>
                                                                
                                                            </div>
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="Telefono">Ciudad:</label>
                                                                            <input type="text" name="ciudad" placeholder="Ciudad" class="form-control" required>
                                                                            </div>
                                                                
                                                            </div>
                                                            <div class="col-md-1">
                                                                          
                                                                
                                                            </div>
                                                            <div class="col-md-3">
                                                                     <?php
                                                                        
                                                                        setlocale(LC_TIME,'spanish');
                                                                        $fechaActual = strftime("%d de %B de %Y");
                                                                        $fechaActual = ucfirst(iconv("ISO-8859-1","UTF-8",$fechaActual));
                                                                        
                                                                        ?> 
                                                                       <input type="hidden" name="fechaActual" id="fecha" readonly="readonly" value="<?= $fechaActual?>"/> 
                                
                                                                        <input type="hidden" name="userid" value="<?=$_SESSION["user_id"]?>">
                                                            </div> 
                                                            
                                                         </div>   
                                                         <div class="col-md-1">
                                                        </div>
                                                        
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="dato" id="datos" value="Si" Onchange="check()" required> Tratamiento de datos personales
                                                                <br>
                                                                <div id="arc">
                                                                <input type="file" name="archivo" id="archivo">  
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="datouno" id="datos1" value="Si"> Env&iacute;o de publicidad
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="datodos" id="datos2" value="Si"> Env&iacute;o de material cientifico
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">                                                                
                                                            </div>
                                                            <div class="col-md-4">
                                                            <input type="checkbox" name="datotres" id="datos3" value="Si" Onchange="check1()"> Transferencia de valor
                                                                <br>
                                                                <div id="arc1">
                                                                <input type="file" name="archivo1" id="archivo1"> 
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        
                                                        </div>   
                                                        
                                                        <div class="row" >
                                                        <div class="col-md-5" ></div>    
                                                         <div class="col-md-5" >
                                                             <br>
                                                                        <input type="hidden" name="ide" id="ident" value="<?= $_SESSION['identificacion']?>">
                                                                       <input class="btn" style="background-color:#00AB84; color:white;" name= "boton" id="boton" type="submit" value="Enviar">
                                                                              
                                                        </div>   
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


