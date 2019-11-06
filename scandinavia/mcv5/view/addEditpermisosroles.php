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
		'id' => $_GET['id'],
	);
	$conditions['return_type'] = 'single';
	$userData = $db->getRows('role_rights', $conditions); //ojo se pone tabla a consultar
	

	$roleData = $db->getRows('role',array('order_by'=>'id ')); //ojo se pone tabla a consultar
	$moduleData = $db->getRows('module',array('order_by'=>'id ')); //ojo se pone tabla a consultar
}
else{ /*cuando hay consultas de dropdown*/
include '../clases/DB.class.php';	
$db = new DB();	
$roleData = $db->getRows('role',array('order_by'=>'id ')); //ojo se pone tabla a consultar
$moduleData = $db->getRows('module',array('order_by'=>'id ')); //ojo se pone tabla a consultar

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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
</style>

<script src="https://oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
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
          	<h3><i class="fa fa-angle-right"></i> Permisos por Rol</h3>
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
            <div class="panel-heading"><?php echo $actionLabel; ?> Permisos por Rol <a href="../permisosroles.php?op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-arrow-left"></a></div>
           
                <form method="post" action="permisosrolesAction.php" class="form" id="formulario-contacto">
                  <div class="col-md-6"> 
                   <label>Codigo ROL</label>
                 
                    <select class="form-control form-control-lg" name="rolecode">
						<?php 						
						foreach ($roleData as $row) {							
							    if(!empty($userData['rr_rolecode'])){
									if($userData['rr_rolecode'] == $row['role_rolecode']){										
										echo '<option selected=\"selected\" value="'.$row['role_rolecode'].'">'.$row['role_rolecode'].'</option>';
									}	
									else{
										echo '<option value="'.$row['role_rolecode'].'">'.$row['role_rolecode'].'</option>';
									}
								}
								else{
									echo '<option value="'.$row['role_rolecode'].'">'.$row['role_rolecode'].'</option>';
								}
                        }?>
	    			</select>                                           
                    </div>   
                    
                  <div class="col-md-6"> 
                   <label>Codigo Modulo</label>
                    <select class="form-control form-control-lg" name="modulocode">
						<?php 
						foreach ($moduleData as $row) {							
							    if(!empty($userData['rr_modulecode'])){
									if($userData['rr_modulecode'] == $row['mod_modulecode']){
										echo '<option selected=\"selected\" value="'.$row['mod_modulecode'].'">'.$row['mod_modulecode'].'</option>';
									}	
									else{
										echo '<option value="'.$row['mod_modulecode'].'">'.$row['mod_modulecode'].'</option>';
									}
								}
								else{
									echo '<option value="'.$row['mod_modulecode'].'">'.$row['mod_modulecode'].'</option>';
								}
                        }?>
	    			</select>                                           
                    </div>                                 
                
                
                  <div class="col-md-6">
                        <label class="checkbox-inline">                    
                       <?php   $checked = "";
					       if(!empty($userData['rr_create'])){
						      	if($userData['rr_create'] == 'yes') {
									$checked = "checked=\"checked\"";
									echo ' <input type="checkbox" name="create[]"  value="yes" '.$checked.' />';
									echo '<input type="hidden" name="create[]" value="no" />';																		
								}
								else{
									echo ' <input type="checkbox" name="create[]"  value="yes" />';
									echo '<input type="hidden" name="create[]" value="no" />';	
								}									
							}
							else{
								   echo '<input type="checkbox" name="create[]" value="yes" />';
								   echo '<input type="hidden" name="create[]" value="no" />';
							}
							  
						   
						   ?>  Permiso Creacion  </label>  
                    </div>
                  <div class="col-md-6">
                        <label class="checkbox-inline">
                        <?php $checked = "";
					       if(!empty($userData['rr_edit'])){
						      	if($userData['rr_edit'] == 'yes') {
									$checked = "checked=\"checked\"";
									echo ' <input type="checkbox" name="edit[]"  value="yes" '.$checked.' />';
									echo '<input type="hidden" name="edit[]" value="no" />';																		
								}
								else{
									echo ' <input type="checkbox" name="edit[]"  value="yes" />';
									echo '<input type="hidden" name="edit[]" value="no" />';	
								}									
							}
							else{
								   echo '<input type="checkbox" name="edit[]" value="yes" />';
								   echo '<input type="hidden" name="edit[]" value="no" />';
							}
						   ?>Permiso Modificacion</label>
                    </div>                    
                    
                    
                  <div class="col-md-6">
                        <label class="checkbox-inline">
                        <?php $checked = "";
					       if(!empty($userData['rr_delete'])){
						      	if($userData['rr_delete'] == 'yes') {
									$checked = "checked=\"checked\"";
									echo ' <input type="checkbox" name="delete[]"  value="yes" '.$checked.' />';
									echo '<input type="hidden" name="delete[]" value="no" />';																		
								}
								else{
									echo ' <input type="checkbox" name="delete[]"  value="yes" />';
									echo '<input type="hidden" name="delete[]" value="no" />';	
								}									
							}
							else{
								   echo '<input type="checkbox" name="delete[]" value="yes" />';
								   echo '<input type="hidden" name="delete[]" value="no" />';
							}					  						   
						   ?>  Permiso Eliminacion</label>                      
                    </div> 
                    
                    
                     <div class="col-md-6">
                         <label class="checkbox-inline">
                       <?php $checked = "";
					       if(!empty($userData['rr_view'])){
						      	if($userData['rr_view'] == 'yes') {
									$checked = "checked=\"checked\"";
									echo ' <input type="checkbox" name="view[]"  value="yes" '.$checked.' />';
									echo '<input type="hidden" name="view[]" value="no" />';																		
								}
								else{
									echo ' <input type="checkbox" name="view[]"  value="yes" />';
									echo '<input type="hidden" name="view[]" value="no" />';	
								}									
							}
							else{
								   echo '<input type="checkbox" name="view[]" value="yes" />';
								   echo '<input type="hidden" name="view[]" value="no" />';
							}					  						   
						   ?> Permiso Ver</label>                       
                    </div>   
                    
                                        
                    <br>
                    <?php  $varid = 0;
					       if(isset($userData['id'])) { $varid = $userData['id'];;}  ?>
					<input type="hidden" name="id" value="<?php echo $varid; ?>">
                    <input type="hidden" name="op" value="<?php echo $_REQUEST['op'];?>">
					<br> 
					 <div class="col-md-6">
<input type="submit" name="userSubmit" class="btn btn-success" value="Enviar"/> </div>
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
		