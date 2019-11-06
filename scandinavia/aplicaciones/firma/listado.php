<?php 

require_once("../../seguridad/config.php");

$status = FALSE;
$cedulaSesion = $_SESSION['identificacion'];
$sesion = $_SESSION["user_id"];
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
$db = new DB();

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
//contro centro de costo
$conditionsemp['where'] = array('cedula'=> $_SESSION['identificacion'],); 
$totalesemp = $db->getRows('empleadolg',$conditionsemp); //ojo se pone tabla a consultar
$_SESSION['centrocosto']= substr($totalesemp[0]['centrocosto'],0,3) ;  
$condition['where'] = array('id_Aprobador'=> $sesion,); 
$usuario = $db->getRows('system_users',$condition);  


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
        <link type="text/css" href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'    rel='stylesheet'>
            
               
        <script src="../../scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="../../scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
  
        <!--<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->
        <script src="../../datatables/jquery.dataTables.js"></script>
        <script src="../../datatables/dataTables.bootstrap.js"></script>
        <link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
        
        <script>
        $(document).ready(function() {
				var dataTable =  $('#lookup').dataTable({
					
					"language":	{
					"sProcessing":     "Procesando...",
					"sLengthMenu":     "Mostrar _MENU_   &nbsp;&nbsp;Registros",
					"sZeroRecords":    "No se encontraron resultados",
					"sEmptyTable":     "Ningún dato disponible en esta tabla",
					"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
					"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix":    "",
					"sSearch":         "Buscar:",
					"sUrl":            "",
					"sInfoThousands":  ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst":    "Primero",
						"sLast":     "Último",
						"sNext":     "Siguiente",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					}
				},
					
					"processing": true,
					"serverSide": true,					
								
					"ajax":{
						url :"ajax-grid-infor.php", // json datasource	
												
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".lookup-error").html("");
							$("#lookup").append('<tbody class="employee-grid-error"></tbody>');
							$("#lookup_processing").css("display","none");
							
						}
					}
				} );					
		} );
        </script>
      
	 

	 
				  
              <a href="https://appmegalabs.com/scandinavia/default1.php" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         <br>   
                
                
<div class="panel ">         
<div class="panel-heading form-control text-center" >Listado </div> 
<div class="table table-responsive">                 
<div class="container">



<div class="row">	
	<div class="span12">					
		<table id="lookup" class="table table-striped table-bordered" style="border: 1px solid gray;" >  
							<thead>
							<tr>
							
							<th >Codigo</th>
							<th >Nombre panel </th>
							<th >Habeas Data</th>
							<th >Publicidad</th>
							<th >Material</th> 							
							<th >Transferencia de valor</th> 							
							<th > Modificar </th>
							<input type="hidden" name="aprobador" id="sesion" value="<?=$usuario[0]['sesion']?>">
							
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
