<?php
//start session
//session_start();
 ini_set ('memory_limit', '1024M');
 ini_set ('max_execution_time', 300);
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

</style>
<?php
if(isset($_POST['adjunto']))
{
    require_once('conexion.php');
    require_once('functions.php');
    
       $archivo = $_FILES['archivo']['name'];
       $archivoCopiado = $_FILES['archivo']['tmp_name'];
       $archivoGuardado = "Doc_".$archivo;
       $fechaActual = $_POST['fechaActual'];
       $userid = $_POST['userid'];
       $ruta = $_POST['ruta'];
        if(copy($archivoCopiado, $archivoGuardado )){}
       
       if(file_exists($archivoGuardado))
       {
            $fp = fopen($archivoGuardado,"r");
            $rows = 0;
            $resultado= limpiarDatos();
            while ($datos = fgetcsv($fp,0,";"))
            {
               
                    $rows++;
                    if($rows >1)
                    {
                        $resultado = insertarDatos($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6],$datos[7],$datos[8],$datos[9],$datos[10],$datos[11],$datos[12],$datos[13],$datos[14],$datos[15],$datos[16],$datos[17],$datos[18] ,$datos[19],$datos[20],$datos[21],$datos[22],$datos[23],$datos[24],$datos[25],$datos[26],$datos[27],$datos[28],$datos[29],$datos[30],$datos[31],$datos[32],$datos[33],$datos[34],$datos[35],$datos[36],$datos[37],$datos[38],$datos[39],$datos[40],$datos[41],$datos[42],$datos[43],$datos[44],$datos[45],$datos[46],$datos[47],$datos[48],$datos[49],$datos[50],$datos[51],$datos[52],$datos[53],$datos[54],$datos[55],$datos[56],$datos[57],$datos[58],$datos[59],$datos[60],$datos[61],$datos[62]);
                    }
                   
            }
            $query= datosArchivo($ruta, $archivoGuardado,$fechaActual, $userid);
            echo  "<div class='alert alert-success' role='alert'>Se realizaron las actualizaciones!</div>";
       }
        else
        {
           echo  "<div class='alert alert-danger' role='alert'>Por favor adjunte un archivo</div>";
        
         }
   
   
}
?>

<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
        <?php
        date_default_timezone_set('America/Bogota');
        $fechaActual=date("Y-m-d H:i:s");
        ?>
        <div class="row">
            <div class="col-6 col-md-4"></div>
                    <div class="col-6 col-md-4">
                    <div class="form-group" >
                        <div class="panel panel-primary" >
                        <div class="panel-heading text-center form-control"  >Importador Panel Saldos AX</div>
                        </div>
                        <div class="formulario ">
                            <form action="" class="opcion form-group" method="post" enctype="multipart/form-data">
                            <input type="file" name="archivo" id="archivo" onchange="return validarExt()">
                            <div id="visorArchivo">
                            </div>
                            </br></br>
                            <input type="hidden" name="fechaActual" id="fecha" readonly="readonly" value="<?= $fechaActual?>"/> 
                            <input type="hidden" name="ruta" value="Importador/Panel/" readonly="readonly">
                            <input type="hidden" name="userid" value="<?=$_SESSION["user_id"]?>">
                            <input type="submit" name="adjunto" value="Adjuntar archivo" class="btn btn-primary" >
                            
                            </form>
                           
                    </div>        
                 <div class="col-6 col-md-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<script type="text/javascript">

function validarExt()
{
    var archivo = document.getElementById('archivo');
    var archivoRuta = archivo.value;
    var extPermitidas = /(.CSV)$/i;
    if(!extPermitidas.exec(archivoRuta))
    {
        alert('Adjuntar archivos CSV!');
        archivo.value='';
        return false;
    }
    else
    {
        if(archivo.files && archivo.files[0])
        {
            var visor = new FileReader();
            visor.onload=function(e)
            {
                document.getElementById('visorArchivo').innerHTML='<embed src"'+e.target.result+'" width="500" height="500" >';
            };
            visor.readAsDataURL(archivo.files[0])
        }
    }
}
</script>   
<style type="text/css">
.container{padding: 10px;}
.glyphicon{font-size: 20px;}
.glyphicon-arrow-left{float: right;}
a.glyphicon{text-decoration: none;}
</style>
 

<?php require_once('../../../pie.php'); }?>

		
