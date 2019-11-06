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

<?php require('../../../cabeza.php'); 
$embebida = "";
if(isset($_REQUEST['url'])){
	$embebida = $_REQUEST['url'];	
}


if(!isset($_SESSION["session_username"])) {	
  header("location:../index.php");  
} 
else {?>



<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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

</style>

<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <link href="boostrap/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="boostrap/js/bootstrap.min.js"></script>
    <title>Page Title</title>
</head>

<body>
<div class="container">
    <?php
    date_default_timezone_set('America/Bogota');
    $fechaActual=date("Y-m-d H:i:s");
    ?>

    <div class="panel panel-primary">
            <div class="panel-heading text-center form-control" >Formulario</div>
            <div class="panel-body">   

                <form method="post" action="formulario2.php" name="formulario">
                    <div class="row">
                                <div class="col-md-6">
                                    
                                    <label for="fechaActual">Fecha Actual:</label>     
                                    <input class="form-control" type="datetime" name="fechaActual" id="fecha" readonly="readonly" value="<?= $fechaActual?>"/> 
                                    
                                </div>
                         
                                <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="descripcion">Descripción:</label> 
                                        <input class="form-control" type="text" name="descripcion">
                                        </div>
                                </div>   
                    </div>
                    <div class="row">                         
                                <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="direccion">Dirección:</label> 
                                        <input  class="form-control" type="text" name="direccion">
                                        </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="diligencia">Fecha Diligencia:</label>
                                                    <div class='input-group date' id='datetimepicker1'>
                                                            <input type='text' name="diligencia" id="fecha" class="form-control" required min="" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                    </div>
                                                   
                                            
                                    </div>
                                    
                                </div>
                                
                    </div>      
                    
                    <div class="row">
                        
                                <div class="col-md-6">                 
                                <label for="jornada" class="label label-primary">Jornada</label>
                                <div class="form-group">
                                        
                                        <label><input class="" type="checkbox" name="uno" onClick="disableDos(this)" id="1"> Mañana</label>
                                        <label><input class="" type="checkbox" name="dos" onClick="disableUno()" id="2"> Tarde</label>
                                </div>                                        
                                </div> 

                                <div class="col-md-6">  
                                <div class="form-group">  
                                <input class="btn btn-primary"type="submit" name="enviar" value="Enviar">
                                </div> 
                                </div>     
                    </div> 
                </form>

        </div>
    </div>
</div>
<script type="text/javascript">
function disableCheck(field, causer) {
if (causer.checked) {
field.checked = false;
field.disabled = true;
}
else {
field.disabled = false;
}
}

function disableDos(field) {
disableCheck(formulario.dos, field);
}

function disableUno() {
field = formulario.uno

if (formulario.dos.checked) {
field.checked = false;
field.disabled = true;
}
else {
field.disabled = false;
}
}

</script>
<script type='text/javascript'>
    $( document ).ready(function() {
        $('#datetimepicker1').datetimepicker();
    });
</script>
</body>
</html>
<style type="text/css">
.container{padding: 10px;}
.glyphicon{font-size: 20px;}
.glyphicon-arrow-left{float: right;}
a.glyphicon{text-decoration: none;}
</style>
 
<div class="embed-container">
    <iframe width="933" height="700" src="<?php echo $embebida; ?>" frameborder="0" allowfullscreen="true"></iframe>
</div>
<?php require_once('../../../pie.php'); }?>

		