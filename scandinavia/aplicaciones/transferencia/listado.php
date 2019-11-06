<?php 

require_once("../../seguridad/config.php");

$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

if ( authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["edit"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["view"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["delete"]) ) {
 $status = TRUE;
}


/*       
if ($status === FALSE) {
die("You dont have the permission to access this page");
}
*/

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

require_once '../../mcv5/clases/DB.class.php'; 
require_once 'estilos.php';

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
require_once('../../cabeza.php'); 

if(!isset($_SESSION["session_username"])) {	
  header("location:../../index.php");
 
  
} 
else {
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
div.container {
        width: 98%;
		min-height: 10%;
    }
.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
    color: white;
}
</style>

<!DOCTYPE html>
<html lang="en">
    <head>
    
	 
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
   
   <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" rel="stylesheet">             
    <link type="text/css" href="../../css/bootstrap.min.css" rel="stylesheet"> 
    
     
       <link type="text/css" href="../../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="../../css/theme.css" rel="stylesheet">
        
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'    rel='stylesheet'>
            
               
        <script src="../../scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="../../scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
  
        <!--<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->
        <script src="../../datatables/jquery.dataTables.js"></script>
        <script src="../../datatables/dataTables.bootstrap.js"></script>
        <link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">

        <script src="listado.js"></script>


 <a href="https://appmegalabs.com/scandinavia/default1.php?group=Transferencia" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         <br>




                  
<div class="panel ">         
<div class="panel-heading form-control text-center">Listado documentos</div>
<div class="table table-responsive">                 
<div class="container">

<div class="row">	
	<div class="span12">					
		<table id="lookup" class="table table-striped table-bordered" style="border: 1px solid gray;" >  
							<thead>
							<tr>
							
							<th width="15%" class="text-center">Documento</th>
							<th width="15%">Fecha </th>
							<th width="15%">Nombre</th>
							<th width="15%">Descripcion</th>
                            <th width ="15%">Estado </th>
                            
                            <th class="text-center" width="15%"> Ver Documento</th>
							</tr>
							</thead>
							<tbody>
							
							</tbody>
		</table>
</div>									
</div>
</div> 
</div> 
</div>                           
<?php require_once('../../pie.php'); }?>

