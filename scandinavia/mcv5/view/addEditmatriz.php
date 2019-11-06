<?php
//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
if(!empty($_GET['id'])){
	include '../clases/DB.class.php';	
	$db = new DB();
	$conditions['where'] = array(
		'idarray' => $_GET['id'],
	);
	$conditions['return_type'] = 'single';
	$matrizData = $db->getRows('matrizaprobacion', $conditions); //ojo se pone tabla a consultar	
	
	$userData = $db->getRows('system_users', array('order_by'=>'full_name ')); //ojo se pone tabla a consultar
	$roleData = $db->getRows('vw_modulesmatriz',array('order_by'=>'Module ')); //ojo se pone tabla a consultar
	
}
else{ /*cuando hay consultas de dropdown*/
include '../clases/DB.class.php';	
$db = new DB();	
$userData = $db->getRows('system_users', array('order_by'=>'full_name ')); //ojo se pone tabla a consultar
	$roleData = $db->getRows('vw_modulesmatriz',array('order_by'=>'Module ')); //ojo se pone tabla a consultar
	$matrizData = $db->getRows('matrizaprobacion',array('order_by'=>'idproceso, paso ')); //ojo se pone tabla a consultar

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


if(!isset($_SESSION["session_username"])) {	
  header("location:../../seguridad/index.php");
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
</style>

<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<style type="text/css">
.container{padding: 10px;}
.glyphicon{font-size: 20px;}
.glyphicon-arrow-left{float: right;}
a.glyphicon{text-decoration: none;}
</style>
 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Matriz de Asignación</h3>
          	<div class="row mt">
          		<div class="col-12">
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
            <div class="panel-heading"><?php echo $actionLabel; ?> Matriz <a href="../admin.php?op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-arrow-left"></a></div>
           
                <form method="post" action="adminActionmatriz.php" class="form" id="formulario-contacto">
                    
                    <div class="col-md-6"> 
                   <label>Proceso</label>
                    <select class="form-control form-control-lg" name="procesos">
						<?php 
						foreach ($roleData as $row) {							
							    if(!empty($matrizData['idproceso'])){
									if($matrizData['idproceso'] == $row['Module']){
										echo '<option selected=\"selected\" value="'.$row['Module'].'">'.$row['Module'].'</option>';
									}	
									else{
										echo '<option value="'.$row['Module'].'">'.$row['Module'].'</option>';
									}
								}
								else{
									echo '<option value="'.$row['Module'].'">'.$row['Module'].'</option>';
								}
                        }?>
	    			</select>                                           
                    </div>  
                    
                    
                    <div class="col-md-6">
                    <?php 
					$csvString = $matrizData['responsable'];
					$array = explode(", ", $csvString);
					?>
                      <label>Usuarios</label>
                    <select name="usuarios[]" size="8" multiple="MULTIPLE" class="form-control form-control-lg">
						<?php 
						foreach ($userData as $row) {	
							    if (in_array($row['u_userid'], $array, true)) {
										echo '<option selected=\"selected\" value="'.$row['u_userid'].'">'.$row['full_name'].'</option>';										
									}	
									else{
									 echo '<option value="'.$row['u_userid'].'">'.$row['full_name'].'</option>';   
									}
							
						  
						}
																								
						?>
	    			</select>
                    </div>  
                    
                    
                   <div class="col-md-6">
                        <label>Descripción</label>
                        <input type="text" class="form-control" name="descripcion" placeholder="descripcion..." required value="<?php echo !empty($matrizData['descripcion'])?$matrizData['descripcion']:''; ?>">
                    </div> 
                    
                    
                      <div class="col-md-6">
                        <label>Orden</label>
                        <input type="text" class="form-control" name="paso" placeholder="Paso..." required value="<?php echo !empty($matrizData['paso'])?$matrizData['paso']:''; ?>">
                    </div> 
                    
                                                           
                    <br>
                    <?php  $varid = 0;
					       if(isset($matrizData['idarray'])) { $varid = $matrizData['idarray'];;}  ?>
					<input type="hidden" name="id" value="<?php echo $varid; ?>">
                     <input type="hidden" name="op" value="<?php echo $_REQUEST['op'];?>">

					<br> 
					 <div class="col-md-6">
<br />
<input type="submit" name="userSubmit" class="btn btn-success" value="Enviar"/> 
</div>
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
		