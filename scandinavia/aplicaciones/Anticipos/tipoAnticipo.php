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


if(!isset($_SESSION["session_username"])) {	
  header("location:../index.php");  
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

@media screen and (max-width: 800px) 
{
  
}


@media screen and (max-width: 600px) 
{

}

@media screen and (max-width: 300px) 
{

}


.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
    color: white;
}
</style>


<?php

$tipo = $_POST['tipo'];


   
  if(isset($_POST['opcion']) )
  {
    if(!empty($tipo))
    {
      if($tipo == "Empleado")
      {
          
        echo "<script type='text/javascript'>window.top.location='https://appmegalabs.com/scandinavia/aplicaciones/Anticipos/indexEmpleado.php?tp=Empleado';</script>";

      }
      else if ($tipo == "Proveedor")
      {
          echo "<script type='text/javascript'>window.top.location='https://appmegalabs.com/scandinavia/aplicaciones/Anticipos/indexProveedor.php?tp=Proveedor';</script>"; 
          
      }
    }
    else 
    {
        echo  "<div class='alert alert-danger' role='alert'>Seleccione una opción, por favor!</div>";
        
    }  
  }



?>


<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="https:https:https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="https:https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <link href="boostrap/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="boostrap/js/bootstrap.min.js"></script>

</head>





<script src="https://oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<!DOCTYPE html>
<html>
<head>

    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <link href="boostrap/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="boostrap/js/bootstrap.min.js"></script>

</head>

<body>
<div class="panel-body">    
    <div class="container" >
         <a href="https://appmegalabs.com/scandinavia/default1.php?group=Anticipos" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         <br>
         
        <div class="panel panel-default users-content">
            <div class="panel-body">
                <div class="panel ">  
                    <div class="panel-heading text-center form-control" >Tipo de anticipo</div> 
                            
                </div>
                <form action="" method="post">    
                            <div class="row">  
                                <div class="col-md-4">
                                            
                                </div>                                    
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg" name="tipo" id= "tipo">
                                        <option value="">Selecciona una opción</option>
                                        <option value="Empleado">Empleado</option>
                                        <option value="Proveedor">Proveedor</option>  
                                    </select>      
                                </div>  
                            </div>
                            <br />
                            <div class="form-group" >
                                <div class="col-lg-12 control-label" align="center">
                                    <button class="btn" style="background-color:#00AB84; color:white;" name="opcion" type="submit">Enviar</button> 
                                </div>
                            </div>                       
                </form>               
            </div>    
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

		