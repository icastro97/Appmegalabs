<?php
//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';





require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from database




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

    #canvas
    {
        margin-left: -10px;        
        border-width:2px;  
        border-style:solid;
        border-color:#00AB84;
    }
    
   

  
</style>




<!DOCTYPE html>
<html>



<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
   
</head>



<body>
    
<a href="https://appmegalabs.com/scandinavia/aplicaciones/firma/index.php?op=Consentimiento" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
    <br>
    <br>
    <br>
                                <!--Inicio de la firma-->
                                                    
                                                    
                                                    
                                                    <!-- creamos el form para el envio -->
                                                    <form id='formCanvas' method='post' action='firmar2.php' ENCTYPE='multipart/form-data'>
                                                                       
                                                    

                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="ex2">Cédula</label>
                                        			    			        <input name="cedula"  id="identificacion" type="text"  readonly="readonly"  class="form-control"    value="<?=$_POST['cedula'];?>"/>
                                                                            </div>
                                                                
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>

                                                                <canvas  id='canvas' width="400" height="300" >
                                                                <p>Tu navegador no soporta canvas</p>
                                                                
                                                                </canvas>
                                                                
                                                                <br>
                                                                <button type='button' id="guardar" class="btn"style="background-color:#00AB84; color:white;" onclick='GuardarTrazado()'>Guardar</button>
                                                                <button type="button" id="boton1" class="btn" style="background-color:#00AB84; color:white;"  onclick="LimpiarTrazado()" >Borrar</button>
                                                                <input type='hidden' name='imagen' id='imagen' />
                                                                <input type="hidden" name="opcion" value=<?=$_POST['opcion'];?>>
                                                                <input type="hidden" name="cod" value=<?=$_POST['cod'];?>>
                                                                <input type="hidden" name="nombreP" value="<?= $_POST['nombreP'];?>">    
                                                                <input type="hidden" name="nombreS" value="<?= $_POST['nombreS'];?>">    
                                                                <input type="hidden" name="apellidoP" value="<?= $_POST['apellidoP'];?>">    
                                                                <input type="hidden" name="apellidoS" value="<?= $_POST['apellidoS'];?>">    
                                                                <input type="hidden" name="fechaActual" value="<?= $_POST['fechaActual'];?>">   
                                                                <input type="hidden" name="dato" value="<?=$_POST['dato'];?>">   
                                                                <input type="hidden" name="datouno" value="<?=$_POST['datouno'];?>"> 
                                                                <input type="hidden" name="datodos" value="<?=$_POST['datodos'];?>">                                                                   
                                                                <input type="hidden" name="datotres" value="<?=$_POST['datotres'];?>">                                                      
                                                                <input type="hidden" name="ciudad" value="<?=$_POST['ciudad'];?>">   
                                                                <input type="hidden" name="nombrem" value="<?=$_POST['nombrem'];?>">
                                                                <input type="hidden" name="correo" value=<?=$_POST['correo'];?>>
                                                                <input type="hidden" name="telefono" value=<?=$_POST['telefono'];?>>
                                                                <input type="hidden" name="userid" value=<?=$_POST['userid'];?>>
                                                                    
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



<?php require_once('../../pie.php'); }?>


