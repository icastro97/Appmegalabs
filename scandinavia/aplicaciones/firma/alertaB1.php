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
   $('#docu').hide();
   $('#boton').hide();
   
  
   
   
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
	
    function enviar()
    {
        let fechaActual = $('#fecha').val();
        let nombremedico = $('#nombremedico').val();
        let codigom = $('#codigom').val();
        let opc = $('#opc').val();
        let cedula = $('#cedula').val();
        let nombreP = $('#nombreP').val();
        let nombreS = $('#nombreS').val();
        let apellidoP = $('#apellidoP').val();
        let apellidoS = $('#apellidoS').val();
        let correo = $('#correo').val();
        let tel = $('#tel').val();
        let ciudad = $('#ciudad').val();
        let dato = $('#dato').val();
        let dato1 = $('#dato1').val();
        let dato2 = $('#dato2').val();
        let imagen = $('#imagen').val();
        let userid = $('#userid').val();
        $.ajax({
           type:'POST',
           url:'guardarDocumento2.php',
           data:{fechaActual, nombremedico, codigom, opc,cedula,nombreP,nombreS,apellidoP,apellidoS,correo,tel, ciudad, dato,dato1,dato2, imagen, userid},
           success:function(response)
           {
              if(response == "bien"){
                  swal('Información','Se agrego la información','success').then((success)=>{ window.location = 'index1.php';});
              }
           }
        });
    }
	
     function firmar()
    {
        
            var isChecked1 = $('#firma').prop('checked');
            if(isChecked1)
            {   
                $('#docu').show();
                $('#boton2').hide();
                $('#botone').hide();
                $('#archive').hide();
            }
            else
            {
                $('#docu').hide();
                 $('#boton2').show();
                $('#botone').show();
                $('#archive').show();
            }
        
    }	
    
    function adjuntos()
    {
        var isChecked1 = $('#adjunto').prop('checked');
            if(isChecked1)
            {   
                $('#firm').hide();
                $('#archivo1').show();
                $('#boton').show();
            }
            else
            {
                $('#firm').show();
                $('#archivo1').hide();
                $('#boton').hide();
            }
    }
    
    function alertaBuena()
    {   
        swal('Información','Se agrego la información','success').then((success)=>{ window.location = 'index1.php';});
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
                                                    <form  method='post' action='indexFisico4.php' enctype="multipart/form-data">
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
                                                                            <input type="text" required name="nombreP"  id="nombreP" placeholder="Primer nombre" class="form-control" required>
                                                                            </div>
                                                                
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="nombres">Segundo nombre:</label>
                                                                            <input type="text"  name="nombreS"  id="nombreS" placeholder="Segundo nombre" class="form-control">
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="nombres">Primer apellido:</label>
                                                                            <input type="text" required name="apellidoP" id="apellidoP" placeholder="Primer apellido" class="form-control" required>
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="nombres">Segundo apellido:</label>
                                                                            <input type="text"  name="apellidoS"  id="apellidoS" placeholder="Segundo apellido" class="form-control">
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                          
                                                            </div>
                                                            <div class="col-md-2">
                                                                          
                                                            </div>
                                                             <div class="col-md-4">
                                                                            <div class="form-group">
                                                                            <label for="Correo electronico">Correo electronico:</label>
                                                                            <input type="email" name="correo" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required placeholder="Correo electronico" class="form-control" id="correo">
                                                                            </div>
                                                                
                                                            </div>
                                                             <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="Telefono">Teléfono(opcional):</label>
                                                                            <input type="text" name="telefono" id="tel" placeholder="Telefono" class="form-control" >
                                                                            </div>
                                                                
                                                            </div>
                                                            <div class="col-md-2">
                                                                            <div class="form-group">
                                                                            <label for="Telefono">Ciudad:</label>
                                                                            <input type="text" name="ciudad" id="ciudad" placeholder="Ciudad" class="form-control" required>
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
                                
                                                                        <input type="hidden" name="userid" id="userid" value="<?=$_SESSION["user_id"]?>">
                                                            </div> 
                                                            
                                                         </div>   
                                                          <div class="col-md-1">
                                                        </div>
                                                        
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="dato" id="dato" value="Si" required checked> Tratamiento de datos personales
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="datouno" id="dato1" value="Si" checked> Env&iacute;o de publicidad
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="datodos" id="dato2" value="Si" checked> Env&iacute;o de material cientifico
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                     
                                                         </div>   
                                                        <div class="row" >
                                                        <div class="col-md-5">
                                                             
                                                        </div>  
                                                        
                                                        
                                                        
                                                        
                                                        </div>    
                                                        <div id="firm" style="justify-content:center;">
                                                        <input type="checkbox" id="firma" onchange="firmar();">Firmar.
                                                  
                                                                    
                                                        <div id="docu">
                                                          <canvas  id='canvas' width="400" height="300" >
                                                                <p>Tu navegador no soporta canvas</p>
                                                                
                                                                </canvas>
                                                                             <br>
                                                                <button type='button' id="guardar" class="btn"style="background-color:#00AB84; color:white;" onclick='GuardarTrazado()'>Guardar</button>
                                                                <button type="button" id="boton1" class="btn" style="background-color:#00AB84; color:white;"  onclick="LimpiarTrazado()" >Borrar</button>
                                                                <input type='hidden' name='imagen' id='imagen' />
                                                                </div>
                                                                
                                                                
                                                        </div>        
                                                           <div class="row" id="archive" >
                                                               <div class="col-md-5" style="justify-content:center;">
                                                                  
                                                                  <input type="checkbox" id="adjunto" onchange="adjuntos();">Adjuntar.
                                                               </div>
                                                               
                                                                   <div id="arc1">
                                                                <input type="file" name="archivo1" id="archivo1"> 
                                                                </div>
                                                               
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
 #canvas
    {
        margin-left: -10px;        
        border-width:2px;  
        border-style:solid;
        border-color:#00AB84;
    }
    
</style>
 

<?php require_once('../../pie.php'); }?>
<script type="text/javascript">
                                                        /* Variables de Configuracion */
                                                        var idCanvas='canvas';
                                                        var idForm='formCanvas';
                                                        var inputImagen='imagen';
                                                        var estiloDelCursor='crosshair';
                                                        var colorDelTrazo='#555';
                                                        var colorDeFondo='#fff';
                                                        var grosorDelTrazo=2;
                                                    
                                                        /* Variables necesarias */
                                                        var contexto=null;
                                                        var valX=0;
                                                        var valY=0;
                                                        var flag=false;
                                                        var imagen=document.getElementById(inputImagen); 
                                                        var pizarraCanvas=document.getElementById(idCanvas);
                                                    
                                                        /* Esperamos el evento load */
                                                        window.addEventListener('load',IniciarDibujo,false);
                                                    
                                                        function IniciarDibujo(){
                                                          /* Creamos la pizarra */
                                                          pizarraCanvas.style.cursor=estiloDelCursor;
                                                          contexto=pizarraCanvas.getContext('2d');
                                                          contexto.fillStyle=colorDeFondo;                                                     
                                                          contexto.fillRect(0,0,499,300);
                                                          contexto.strokeStyle=colorDelTrazo;
                                                          contexto.lineWidth=grosorDelTrazo;
                                                          contexto.lineJoin='round';
                                                          contexto.lineCap='round';
                                                          /* Capturamos los diferentes eventos */
                                                          pizarraCanvas.addEventListener('mousedown',MouseDown,false);// Click pc
                                                          pizarraCanvas.addEventListener('mouseup',MouseUp,false);// fin click pc
                                                          pizarraCanvas.addEventListener('mousemove',MouseMove,false);// arrastrar pc
                                                    
                                                          pizarraCanvas.addEventListener('touchstart',TouchStart,false);// tocar pantalla tactil
                                                          pizarraCanvas.addEventListener('touchmove',TouchMove,false);// arrastras pantalla tactil
                                                          pizarraCanvas.addEventListener('touchend',TouchEnd,false);// fin tocar pantalla dentro de la pizarra
                                                          pizarraCanvas.addEventListener('touchleave',TouchEnd,false);// fin tocar pantalla fuera de la pizarra
                                                        }
                                                    
                                                        function MouseDown(e){
                                                          flag=true;
                                                          contexto.beginPath();
                                                          valX=e.pageX-posicionX(pizarraCanvas); valY=e.pageY-posicionY(pizarraCanvas);
                                                          contexto.moveTo(valX,valY);
                                                        }
                                                    
                                                        function MouseUp(e){
                                                          contexto.closePath();
                                                          flag=false;
                                                        }
                                                    
                                                        function MouseMove(e){
                                                          if(flag){
                                                            contexto.beginPath();
                                                            contexto.moveTo(valX,valY);
                                                            valX=e.pageX-posicionX(pizarraCanvas); valY=e.pageY-posicionY(pizarraCanvas);
                                                            contexto.lineTo(valX,valY);
                                                            contexto.closePath();
                                                            contexto.stroke();
                                                          }
                                                        }
                                                    
                                                        function TouchMove(e){
                                                          e.preventDefault();
                                                          if (e.targetTouches.length == 1) { 
                                                            var touch = e.targetTouches[0]; 
                                                            MouseMove(touch);
                                                          }
                                                        }
                                                    
                                                        function TouchStart(e){
                                                          if (e.targetTouches.length == 1) { 
                                                            var touch = e.targetTouches[0]; 
                                                            MouseDown(touch);
                                                          }
                                                        }
                                                    
                                                        function TouchEnd(e){
                                                          if (e.targetTouches.length == 1) { 
                                                            var touch = e.targetTouches[0]; 
                                                            MouseUp(touch);
                                                          }
                                                        }
                                                    
                                                        function posicionY(obj) {
                                                          var valor = obj.offsetTop;
                                                          if (obj.offsetParent) valor += posicionY(obj.offsetParent);
                                                          return valor;
                                                        }
                                                    
                                                        function posicionX(obj) {
                                                          var valor = obj.offsetLeft;
                                                          if (obj.offsetParent) valor += posicionX(obj.offsetParent);
                                                          return valor;
                                                        }
                                                    
                                                        /* Limpiar pizarra */
                                                        function LimpiarTrazado(){
                                                          contexto=document.getElementById(idCanvas).getContext('2d');
                                                          contexto.fillStyle=colorDeFondo;
                                                          contexto.fillRect(0,0,499,300);
                                                        }
                                                    
                                                        /* Enviar el trazado */
                                                        function GuardarTrazado(){
                                                          imagen.value=document.getElementById(idCanvas).toDataURL('prueba/');
                                                          enviar();
                                                        }
                                                        
                                                        
                                                       
                                                    </script>

