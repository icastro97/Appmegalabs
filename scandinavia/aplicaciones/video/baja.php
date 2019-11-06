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





<style type="text/css">
.container{padding: 8px; }
table tr th, table tr td{font-size: 1.2rem;}

.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
    color: white;
   
}

.form
{
    width:80%;
    margin-left:130px;
}

.btn
{
    
    background-color:#00965e;
    color:white;
}

.area
{
    margin-left:80px;
}
@media screen and (max-width: 800px) 
{
    .form
    {
        width:100%;
        margin-left:0px;
    }
    .btn
    {
        margin-left:100px;
        background-color:#00965e;
        color:white;
    }
    .area, .area1
    {
        margin-left:0px;
        width:100%;
    }
}


@media screen and (max-width: 600px) 
{
    .form
    { 
        width:100%;
        margin-left:0px;
      
    }
    .s
    {
        margin-left:100px;
        background-color:#00965e;
        color:white;
    }
    
    .area, .area1
    {
        margin-left:0px;
        width:100%;
    }
    .text 
    {
        margin-left:20px;
    }
}



</style>

<script>
     
               
     function habilitacionCheck()
     {
         if(datos != false || datos1 != false || datos2 != false || datos3 != false)
         {
             document.getElementById('enviar').disabled = false;
         }
        
     }
               
     function validacion()
       {
           let datos = $('#datos').prop('checked');
           let datos1 = $('#datos1').prop('checked');
           let datos2 = $('#datos2').prop('checked');
           let datos3 = $('#datos3').prop('checked');
           
        if(datos != false || datos1 != false || datos2 != false || datos3 != false)
           {
                   $("#formulario").submit(function(e) {
                            
                            e.preventDefault();
        					document.getElementById("enviar").disabled = true; 
                            $.ajax( {
                                <!--insert.php calls the PHP file-->
                                url: "baja2.php",
                                method: "post",
                                //data: $("form").serialize(),
        					    data: new FormData( this ),
        					    processData: false,
        					    contentType: false,
                                dataType: "text",
                                success: function(response)
                                {
                                   if(response == "realizado")
                                   { 
                                    
                                    swal("Mensaje", "Mensaje exito.", "success");
                                    document.getElementById("cedula").value = "";
                                    document.getElementById("descripcion").value = "";
                                    document.getElementById("datos").checked = false;
                                    document.getElementById("datos1").checked = false;
                                    document.getElementById("datos2").checked = false;
                                    document.getElementById("datos3").checked = false;
                                    document.getElementById("enviar").disabled = false;
                                   }
                                   else if(response == "mal")
                                   {
                                        swal("Mensaje", "No se realizo la baja de la informacion.", "error");
                                        document.getElementById("cedula").value = "";
                                        document.getElementById("descripcion").value = "";
                                        document.getElementById("datos").checked = false;
                                        document.getElementById("datos1").checked = false;
                                        document.getElementById("datos2").checked = false;
                                        document.getElementById("datos3").checked = false;
                                        document.getElementById("enviar").disabled = false;
                                   }
                                }
                            });
                });
           }        
            else
           {         
                     swal("Mensaje", "Por favor seleccione alguna de las opciones anteriores.", "error");    
                     document.getElementById('enviar').disabled = true;
           }  
           
       }     
    
    
    
    
    
  
    
   
</script>

<!DOCTYPE html>
<html>



<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />


<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">



   
</head>



<body>
   <div class="container">
    
    
    <table width="100%" border="0">
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    
            	    <td colspan="3" align="center"><h3>DAR DE BAJA</h3></td>
            	    </tr>
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    <td colspan="4" align="right">&nbsp;</td>
            	    <td align="center" valign="top">&nbsp;</td>
            	  </tr>        
            	  </table>	
            	
    <!--<form id="my-form" method="post" action="guardar.php?inserted=1" name="insertregistro" enctype="multipart/form-data">-->
   <div class="panel" style="border:1px solid #00AB84;">
            <div class="panel-heading text-center form-control" >Formulario dar de baja</div>
             
               <form id="formulario" class="form" method="post" enctype="multipart/form-data">
                
                        
            	
               
                    <div class="panel-body"> 
                            <?php
                            date_default_timezone_set('America/Bogota');
                            $fechaActual=date("d-m-Y");
                            ?>
                            <br>
                            <div class="row">
                                                             <div class="col-md-1"></div>

                                                            <div class="col-md-2">
                                                            <h5 class="text">Documento:</h5>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <input name="cedula"  id="cedula" type="text" required="required" style="text-transform:uppercase" class="form-control" placeholder="Cédula de ciudadania"/>
                                                            </div>
                                                           
                            </div>
                            <br>
                           
                                    <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="text">Observaciones: </h5>
                                        <div class="col-md-3">
                                            <textarea class="area1" name="descripcion" id="descripcion" cols="80" rows="4" required="required"></textarea>
                                        </div>                            
                                    </div>

                            <br>
                           <div class="row">
                                                            <div class="col-md-4">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="dato" id="datos" value="Si" onChange="habilitacionCheck()"> Tratamiento de datos personales
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="datouno" id="datos1" value="Si" onChange="habilitacionCheck()"> Env&iacute;o de publicidad
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">                                                                
                                                            </div>
                                                            <div class="col-md-5">
                                                            <input type="checkbox" name="datodos" id="datos2" value="Si" onChange="habilitacionCheck()"> Env&iacute;o de material cientifico
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">                                                                
                                                            </div>
                                                            <div class="col-md-4">
                                                            <input type="checkbox" name="datotres" id="datos3" value="Si" onChange="habilitacionCheck()"> Transferencia de valor
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        </div>   
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-3">
                            <input name="enviar" type="submit" id="enviar"  class="btn" value="Enviar Información" onclick="validacion()"/> 
                        </div>
                    </div> 
                      </form> 
                      <br>
         
     </div>                   
</div> 
</body>
</html>

<?php require_once('../../pie.php'); ?>


