<?php

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';


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

<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
	
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/typeahead.js"></script>

 <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<meta charset="utf-8">
	<style>
	.typeahead { border: 2px solid #fff;border-radius: 4px;padding: 8px 12px;max-width: 300px;min-width: 290px;background: rgba(128, 128, 128, 1);color: #FFF;}
	.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;border-bottom:#CCC 1px solid;color:#FFF;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.lista-color {max-width: 450px;min-width: 290px;max-height:340px;
	border-radius:4px;text-align:left;margin:10px; margin-bottom:120px;}
	.producto {font-size:1.5em;color: #686868;font-weight: 700; text-align:left}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #1f3f41;
		outline: 0;
	}
	.form-control{width:300px;}
	.form-control1 {width:300px;}
		
	
    </style>
    
    
 

<div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading">Formulario de Comentarios</div>
      <div class="panel-body">
        


<form action="" method="post">
<!--Elementos de formulario que realizara la busqueda-->
	
		 <div class="row">
            <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">Producto:</label>
                      <input type="text" name="producto" id="producto"  class="form-control" required/>
                   </div>
             </div>                 
                         
                         
                                       
             <div class="col-md-6">
                   <div class="form-group">
                      <label >Fecha:</label>
                      <div class='input-group date' id='datetimepicker1'>
                         <input type='text' class="form-control" required/>
                         <span class="input-group-addon">
                         <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div>
                   </div>
             </div>                                           
         </div>
         <br>
          <div class="row">                 
             <div class="col-md-6">
                   <div class="form-group">
                      <label for="textarea" class="control-label">Comentario:</label>                  
                      <textarea name="textarea" id="textarea" class="form-control" required></textarea>
                   </div>
             </div>
        
        
                 <div class="col-md-6">
                       <div class="form-group">
                          <label class="control-label">Cantidad Aproximada:</label>
                          <input type="number" name="cantidad" id="cantidad"  class="form-control" value="0" placeholder="Numero Entero" required="" pattern="[0-9]/>
                          <input type="number" placeholder="Enter numbers only" name="number">
                       </div>
                 </div>
         
          </div>
         
         <input type="submit" class="btn btn-primary" value="Enviar">
         
		
</form>
		</div>
      </div>
   </div>
</div>


<script>
    $(document).ready(function () {		
        $('#producto').typeahead({
            source: function (busqueda, resultado) {
                $.ajax({
                    url: "consulta.php",
					data: 'busqueda=' + busqueda,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						resultado($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });									
    });
		     
</script>

<script type='text/javascript'>
		$( document ).ready(function() {
			$('#datetimepicker1').datetimepicker();
			
		});
	</script>

<?php require_once('../../pie.php'); }?>