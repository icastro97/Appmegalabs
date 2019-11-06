
<link rel="stylesheet" type="text/css" href="alert/jquery.alerts.css">
<script src="http://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>

<script type="text/javascript" src="alert/jquery.alerts.js"></script>
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

       
if ($status === FALSE) {
die("You dont have the permission to access this page");
}

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';

$db = new DB();
$conditions['where'] = array(
		'tipo' => 'Base Cartera',		
	);
	
//get users from database

$users = $db->getRows('vw_tbluploads',array('order_by'=>'date DESC')); //ojo se pone tabla a consultar

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>

<?php require_once('../../cabeza.php'); 


$filtrando = $_REQUEST['id'];
if(!isset($_SESSION["session_username"])) {	
  header("location:../seguridad/index.php");  
} 
else {
	
if (isset($_REQUEST['env'])) {
		if($_REQUEST['radio']== 1){
			$message =  "Actualiza Facturas?";
			echo "<script> jConfirm('Confirma que $message' , 'Confirmacion', function(r) {
				     if(r==false){
						 jAlert('Transaccion Cancelada ' , 'Resultados');		
					 }
					 else{						 
		       		    window.location='procesarfichero.php?id='+$filtrando;		
					 }
				}); 
		</script>";
		}
		else{
			$message =  "No Actualiza Facturas?";
			echo "<script> jConfirm('Confirma que $message' , 'Confirmacion', function(r) {
		       		  if(r==false){
						 jAlert('Transaccion Cancelada ' , 'Resultados');		
					 }
					 else{
		       		    window.location='procesarfichero2.php?id='+$filtrando;		
					 }			
				}); 
		</script>";			
		}				
	}	
	
	
	?>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Procesar Ficheros de Cartera</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
          		<section id="unseen">

                  
<div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<?php } ?>
    <div class="col-12">
      <div class="table-responsive">
        <div class="panel panel-default users-content">  
            <div class="panel-heading">Ficheros Cartera  </div>
            <form id="form1" name="form1" method="post" action="">
            <table width="50%" border="0" align="center" class="table-bordered">
    <tr>
      <td><label for="textfield">
        <input name="radio" type="radio" id="radio" value="1" checked="checked" />
        Actualizar Facturas</label></td>
      <td><input type="radio" name="radio" id="radio2" value="2" /> 
        No Actualiza Facturas</td>
    </tr>
    <tr>
      <td><input name="env" type="hidden" id="env" value="1" /></td>
      <td><input name="button" type="submit" class="btn btn-danger btn-sm remove" id="button"  value="Enviar"/></td>
    </tr>
  </table>
  </form>
            
        </div>
      </div>
    </div>
</div>                  
                  
                  
                </section>
                <p>&nbsp;</p>
          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

     
  </section>

<?php require_once('../../pie.php'); }?>


