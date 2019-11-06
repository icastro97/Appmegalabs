<?php
session_start();
//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';

$db = new DB();

$tblName = 'comentarioform';
//set default redirect url
//$redirectURL = 'index.php';




if(isset($_POST['userSubmit'])){
    if(!empty($_POST['producto']) && !empty($_POST['fecha']) && !empty($_POST['comentario']) && !empty($_POST['cantidad']) )
	{       		
            //insert data
            $userData = array(
                'producto' => $_POST['producto'],
                'fechaingreso' => $_POST['fecha'],
				'comentario' => $_POST['comentario'],
				'cantidad' => $_POST['cantidad'],
				'userid' => $_POST['userid'],				
				'url' => $_POST['reporte'],
				'opcion' => $_POST['nombrereporte'],
            );
            $insert = $db->insert($tblName, $userData);
            if($insert){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.'; 
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';             
                //set redirect url
                $redirectURL = 'indexform.php?op='. $_POST['op'];
            }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
        
        //set redirect url
        $redirectURL = 'indexform.php?op='. $_POST['op'];
    }
	
	//store status into the session
    $_SESSION['sessData'] = $sessData;
    
	//redirect to the list page
   // header("Location:".$redirectURL);
}
?>

<link rel="stylesheet" type="text/css" href="/scandinavia/aplicaciones/formulario1/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
	
<script type="text/javascript" src="/scandinavia/aplicaciones/formulario1/js/jquery.min.js"></script>
<script src="/scandinavia/aplicaciones/formulario1bootstrap.min.js"></script>
<script type="text/javascript" src="/scandinavia/aplicaciones/formulario1/js/typeahead.js"></script>

 <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>


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

<?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<?php } ?>
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
                      <label >Fecha Estimada de Ingreso:</label>
                      <div class='input-group date' id='datetimepicker1'>
                         <input type='text' name="fecha" id="fecha" class="form-control" required min="" />
                         <span class="input-group-addon">
                         <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div>
                   </div>
             </div>                                           
         </div>


          <div class="row">                 
             <div class="col-md-6">
                   <div class="form-group">
                      <label for="textarea" class="control-label">Comentario:</label>                  
                      <textarea name="comentario" id="" class="form-control" required></textarea>
                   </div>
             </div>
        
        
                 <div class="col-md-6">
                       <div class="form-group">
                          <label class="control-label">Cantidad Aproximada:</label>
                          <input type="number" name="cantidad" id="cantidad"  class="form-control" value="0" placeholder="Numero Entero" required="" pattern="[0-9]"/>
                       </div>
                 </div>
         
          </div>
         
         
         
<?php //busca opcion de menu
$cadena_de_texto = $_SERVER['REQUEST_URI'];
$cadena_buscada   = '?op=';
$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada, 20);


if ($posicion_coincidencia === false) {
    //echo "NO se ha encontrado la palabra deseada!!!!";
    } else {
		
            //echo "Éxito!!! Se ha encontrado la palabra buscada en la posición: ".$posicion_coincidencia ;
			$opcionurl = substr($cadena_de_texto,$posicion_coincidencia + 4);
			$opcionurl1 = str_replace("%20"," ",$opcionurl);
            }
?>         
         
					<input type="hidden" name="userid" value="<?=$_SESSION["user_id"]?>">
            		<input type="hidden" name="action_type" value="ingreso">
                    <input type="hidden" name="op" value="Formulario">
                    <input type="hidden" name="reporte" value="<?=substr($_REQUEST["url"],8)?>">
                    <input type="hidden" name="nombrereporte" value="<?=$opcionurl1?>">
         <input type="submit" class="btn btn-primary" value="Enviar" name="userSubmit" >
   
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
