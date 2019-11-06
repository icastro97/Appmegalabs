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
  header("location:../logininicial.php");  
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

  #canvas
    {
        position: relative;
        width:37%;
        margin: 0 auto; 
        margin-left: 10%;
        margin-top:-3%;
        
    }
    
    #guardar
    {
        
        margin: 0;
        margin-left:0%;
        margin-top:0%;
    }
    
    #boton1
    {
        margin:0;
        margin-top:50%;
        
    }
    
    
@media screen and (max-width: 400px) 
{
  #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
        
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}



@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
    
   #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
        
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* Smartphones (landscape) */
@media only screen 
and (min-width : 321px) {
 
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
        
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* Smartphones (portrait) */
@media only screen 
and (max-width : 320px) {
 
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* iPads (portrait & landscape) */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) {
 
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* iPads (landscape) */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : landscape) {
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /*max-width: 92%;*/
        /*min-width: auto;*/
        width: 37%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -1%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-3%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-3%;
    }
}
 
/* iPads (portrait) */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : portrait) {
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        /*max-width: 92%;*/
        /*min-width: auto;*/
        width: 37%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -1%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}
 
/* Ordenadores de sobremesa y port谩tiles */
@media only screen 
and (min-width : 1224px) {
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
    
}
 
/* Pantallas grandes */
@media only screen 
and (min-width : 1824px) {
 #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        
        width: 37%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: 1%;
        border-bottom: 1px solid #CCC;
    }

    #boton1
    {
       
        margin:0;
        margin-top:-3%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-3%;
    }
}
 
/* iPhone 4 */
@media
only screen and (-webkit-min-device-pixel-ratio : 1.5),
only screen and (min-device-pixel-ratio : 1.5) {
 #canvas
    {
           /* position: absolute; */
        position: relative;
        max-width: 36%;
        /* min-width: auto; */
        width: 50%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: 0%;
        border-bottom: 1px solid #CCC;
        
    }
    

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
}

@media screen and (max-width: 560px) 
{
  #canvas
    {
            /*position: relative;  
            max-width: 220px;  
            min-width: 250px;
            width:300;
            margin: 0 auto;
            margin-left:5%;
            margin-top:-7%;
            border-bottom: 1px solid #CCC;*/
         /* position: absolute; */
           /* position: relative; */
        max-width: 92%;
        min-width: auto;
        width: 88%;
        /* height: 90%; */
        margin: 0 auto;
        margin-left: 5%;
        margin-top: -7%;
        border-bottom: 1px solid #CCC;
        
    }

    #boton1
    {
       
        margin:0;
        margin-top:-7%;
        
    }
    
    #guardar
    {
        margin: 0;
        margin-left:5%;
        margin-top:-7%;
    }
      
}

@media screen and (max-width: 800px) 
{
  
      
}




</style>

<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<!DOCTYPE html>
<html>



<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
    
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
   
</head>



<body>
<div class="container">
    <div class="alert alert-danger" role="alert">
      Ocurrio un error al enviar la informaci��n!
    </div>
    <div class="panel panel-primary">
            <div class="panel-heading text-center form-control" >Consentimiento informado</div>
            <div class="panel-body">  
                     
                                <!--Inicio de la firma-->
                                                    
                                                    
                                                    
                                                    <!-- creamos el form para el envio -->
                                                    <form  method='post' action='firmar.php'>
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                            <div class="form-group">
                                                                            
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="documento">Tipo de documento:</label> 
                                                                            <select name="opcion" id="opc" class="form-control input-sm" style="height: 40px; width:180px;"  disabled="disabled">
                                                                                <option value="">Seleccione una opción</option>
                                                                                <option value="CC">Cedula de ciudadania</option>
                                                                                <option value="CE">Cedula de extranjeria</option>
                                                                            </select>
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                            <div class="form-group">
                                                                            <label for="cedula">Cedula:</label> 
                                                                            <input type="text" id="cedula" required name="cedula" placeholder="Cedula" class="form-control" disabled="disabled">
                                                                            </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                            <div class="form-group">
                                                                            <label for="nombres">Nombre completo:</label>
                                                                            <input type="text" required name="nombre"  placeholder="Nombre completo" class="form-control" disabled="disabled">
                                                                            </div>
                                                                
                                                            </div>
                                                            <div class="col-md-1">
                                                                            <div class="form-group">
                                                                            
                                                                            </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                            <div class="form-group">
                                                                            
                                                                            </div>
                                                            </div>
                                                             <div class="col-md-5">
                                                                            <div class="form-group">
                                                                            <label for="Correo electronico">Correo electronico:</label>
                                                                            <input type="email" name="correo" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" disabled="disabled" required placeholder="Correo electronico" class="form-control">
                                                                            </div>
                                                                
                                                            </div>
                                                             <div class="col-md-5">
                                                                            <div class="form-group">
                                                                            <label for="Ciudad">Ciudad:</label>
                                                                            <input type="text" name="ciudad" placeholder="Ciudad" class="form-control" required disabled="disabled">
                                                                            </div>
                                                                
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                     <?php
                                                                        
                                                                        setlocale(LC_TIME,'spanish');
                                                                        $fechaActual = strftime("%d de %B de %Y");
                                                                        $fechaActual = ucfirst(iconv("ISO-8859-1","UTF-8",$fechaActual));
                                                                        
                                                                        ?> 
                                                                       <input type="hidden" name="fechaActual" id="fecha" readonly="readonly" value="<?= $fechaActual?>"/> 
                                
                                                                        <input type="hidden" name="userid" value="<?=$_SESSION["user_id"]?>">
                                                            </div> 
                                                            
                                                         </div>   
                                                         
                                                         
                                                         <div class="col-md-1">             
                                                         </div>  

                                                        <div class="col-md-9">
                                                        <div class="alert alert-light" style="background-color:#fff3cd; border-color: #ffeeba;" role="alert">
                                                                Ver documento antes de firmar!!
                                                            </div>
                                                            <a href="documento.PNG" style='text-decoration:none;color:black;'><img src="contract.png" width="50" height="50"></a>
                                                            
                                                        </div>
                                                        
                                                        <div class="col-md-1">
                                                        </div>

                                                        <div class="col-md-5"></div>               
                                                         <div class="col-md-3">
                                                             <br>
                                                            
                                                                       <input class="btn btn-primary" type="submit" value="Firmar documento" disabled="disabled" >
                                                                              
                                                            </div>   
                                                            
                                                            

                                                                
                                                        </form>
                                                        
          
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


