<?php
//start session
//session_start();

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


?>



<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">

    #canvas
    {
        margin-left: -10px;        
        border-width:2px;  
        border-style:solid;
        border-color:#3b83bd;
    }
    
   

  
</style>




<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<!DOCTYPE html>
<html>



<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
   
</head>



<body>
    
                  
                                <!--Inicio de la firma-->
                                                    
                                                    
                                                    
                                                    <!-- creamos el form para el envio -->
                                                    <form id='formCanvas' method='post' action='index2.php' ENCTYPE='multipart/form-data'>
                                                                       
                                                   
                                                                <canvas  id='canvas' width="400" height="300" >
                                                                <p>Tu navegador no soporta canvas</p>
                                                                </canvas>
                                                                
                                                                <br><br>
                                                                <br><br>
                                                                <button type='button' id="guardar" class="btn btn-primary" onclick='GuardarTrazado()'>Guardar</button>
                                                                <button type="button" id="boton1" class="btn btn-primary" onclick="LimpiarTrazado()" >Borrar</button>
                                                                <input type='hidden' name='imagen' id='imagen' />
                                                                    
                                                    </form>
                                                    
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
                                                          imagen.value=document.getElementById(idCanvas).toDataURL('upload/');
                                                          document.forms[idForm].submit();
                                                        }
                                                    </script>
                                                    
                                                    
                                                   
                                                    <!--Fin de la firma-->
  

</body>
</html>

<?php require_once('../../pie.php'); ?>


