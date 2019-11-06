<?php
//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
if(!empty($_GET['id'])){
	include '../../mcv5/clases/DB.class.php';		
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

<?php require('../../../cabeza.php'); 
$embebida = "";
if(isset($_REQUEST['url'])){
	$embebida = $_REQUEST['url'];	
}


?>




<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">

    #canvas
    {
        margin-left: -10px;        
        border-width:2px;  
        border-style:solid;
        border-color:#3b83bd;
    }
    
   .butones
   {
       
       margin-top:20px;
       margin-left:527px;
   }
   .text
   {
       margin-top:20px;
       margin-left:290px;
       text-align:justify;
   }
   

  
</style>




<script src="https://oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>

<!DOCTYPE html>
<html>



<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="validacionesDescarga.js"></script>
    
   
</head>



<body>
<form action="generadorPdf.php" method="POST" enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <div class="col">
        </div>
        <div class="col">
        <center><h2>NIT</h2></center>
        </div>
        <div class="col">
        
        </div>
    </div>
     <div class="row">
        <div class="col">
        </div>
        <div class="col">
        <input type="text" class="form-control form-control-sm" name="niteciyo" id="nit" placeholder="Nit">
        
        </div>
        <div class="col">
        
        </div>
    </div>
     
    <div class="row">
        <div class="col">
        </div>
        <div class="col">
        <center><h2>Correo</h2></center>
        </div>
        <div class="col">
        
        </div>
    </div>
        <div class="row">
        <div class="col">
        </div>
        <div class="col">
        <input type="text" class="form-control form-control-sm" name="correo" id="correo" placeholder="Correo Electronico">
        </div>
        <div class="col">
        
        </div>
    </div>
 <br>
 <br>
    
    
    <div class="row">
        
        <div class="col" >
        
        </div>
        
        <div class="col alert alert-danger" id="alerta3">
         <h6>Esto no existe!</h6>
        </div>
        
        
        <div class="col" >
        
        </div>
        
        
        </div>
    
    <div class="row">
        
        <div class="col" >
        
        </div>
        
        <div class="col alert alert-danger" id="alerta2">
         <h6>Esto no es válido!</h6>
        </div>
        
        
        
        <div class="col" >
        
        </div>
        
        
        </div>    
        
    
    <div class="row" id="code1">
        <div class="col">
        </div>
        <div class="col" >
        <center><h2>Código</h2></center>
        </div>
        <div class="col">
        
        </div>
    </div>
    <div class="row">
        
        <div class="col" >
        
        </div>
        
        <div class="col" id="code">
        <input type="text" class="form-control form-control-sm" name="codigo" id="codigo" placeholder="Código" >
        </div>
        
        <div class="col" >
        
        </div>
        
        
    </div>
    <br>
     <div class="row" id="fecha1">
        <div class="col">
        </div>
        <div class="col" >
        <center><h2>Año</h2></center>
        </div>
        <div class="col">
        
        </div>
    </div>
    <div class="row">
        
        <div class="col" >
        
        </div>
        
        <div class="col" id="fecha">
        <select name="select" class="selectpicker" id="fechas">
            <option value=" ">Seleccione una opción:</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
        </select>
        </div>
        
        <div class="col" >
        
        </div>
        
        
    </div>
    <br>
        <div class="row">
        
        <div class="col" >
        
        </div>
        
        <div class="col alert alert-danger" id="alertaMala">
         <h6>Por favor ingrese el código que se envio a su cuenta de correo electronico asociada!</h6>
        </div>
        
        <div class="col" >
        
        </div>
        
        
        </div>
    
    <div class="row">
        
        <input type="hidden" id="Axapta">
        <input type="hidden" id="nitEscondido" name="nitEscondido">
        <div class="col-md-2">
        <input type="submit" class="butones btn btn-danger" id="boton" value="Generar pdf"> 
        <input type="button" class="butones btn btn-primary" id="valida" value="Validar datos" onclick="prueba()">
        <input type="button" class="butones btn btn-primary" id="as" value="Confirmar código" onclick="validarCodigo()">
        
        </div>
        
    </div>
     
</form>

</body>
</html>

<?php require_once('../../../pie.php'); ?>
