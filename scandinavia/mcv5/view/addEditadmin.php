<?php
//start session
session_start();
$sesion = $_SESSION["user_id"];
//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
if(!empty($_GET['id'])){
	include '../clases/DB.class.php';	
	$db = new DB();
	$conditions['where'] = array(
		'u_userid' => $_GET['id'],
	);
	$conditions['return_type'] = 'single';
	$userData = $db->getRows('system_users', $conditions); //ojo se pone tabla a consultar
	$roles = $db->getRows('vw_modulesmatriz',array('order_by'=>'Module')); 

	$roleData = $db->getRows('role',array('order_by'=>'role_rolecode ')); //ojo se pone tabla a consultar
}
else{ /*cuando hay consultas de dropdown*/
include '../clases/DB.class.php';	
$db = new DB();	
$roleData = $db->getRows('role',array('order_by'=>'role_rolecode ')); //ojo se pone tabla a consultar
$roles = $db->getRows('vw_modulesmatriz',array('order_by'=>'Module'));
$use = $db->getRows('system_users');  
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


<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
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



<script>
 $(document).ready(function() {
                <!--#my-form grabs the form id-->
               
                $("#formulario-contacto").submit(function(e) {
                    e.preventDefault();
					document.getElementById("userSubmit").disabled = true; 
				   
                    $.ajax( {
                        <!--insert.php calls the PHP file-->
                        url: "adminAction.php",
                        method: "post",
                        //data: $("form").serialize(),
					    data: new FormData( this ),
					    processData: false,
					    contentType: false,
                        dataType: "text",
                        success: function(strMessage) {
                        
                        devolver();
                        }
                    });
                });
            });




function devolver()
{
    window.top.location='https://appmegalabs.com/scandinavia/mcv5/admin.php?op=USUARIOS';
}

  
</script>
 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Maestro de Usuarios</h3>
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
            <div class="panel-heading"><?php echo $actionLabel; ?> Usuarios <a href="../admin.php?op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-arrow-left"></a></div>
           
                <form id="formulario-contacto">
                  <div class="col-md-6">
                        <label>Usuario</label><input type="text" class="form-control" name="username" placeholder="Usuario"  value="<?php echo !empty($userData['u_username'])?$userData['u_username']:''; ?>">
                    </div>
                  <div class="col-md-6">
                        <label>Contrase���a</label>
                        <input type="text" class="form-control" name="password" placeholder="Password..." required value="<?php echo !empty($userData['u_password'])?$userData['u_password']:''; ?>">
                    </div>                    
                    
                    
                  <div class="col-md-6">
                        <label>Nombres</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Nombres..." required value="<?php echo !empty($userData['full_name'])?$userData['full_name']:''; ?>">
                    </div> 
                    
                  <div class="col-md-6">
                        <label>Identificacion</label>
                        <input type="text" class="form-control" name="identificacion" placeholder="Identificacion..." required value="<?php echo !empty($userData['cedula'])?$userData['cedula']:''; ?>">
                    </div>  



                <div class="col-md-6">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email..." required value="<?php echo !empty($userData['email'])?$userData['email']:''; ?>">
                    </div>      
                    

                  <div class="col-md-6"> 
                   <label>ROL</label>
                    <select class="form-control form-control-lg" name="rol">
						<?php 
						foreach ($roleData as $row) {							
							    if(!empty($userData['u_rolecode'])){
									if($userData['u_rolecode'] == $row['role_rolecode']){
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
                                                         
                    <br>
                    <?php  $varid = 0;
					       if(isset($userData['u_userid'])) { $varid = $userData['u_userid'];;}  ?>
					<input type="hidden" name="id" value="<?php echo $varid; ?>">
                     <input type="hidden" name="op" value="<?php echo $_REQUEST['op'];?>">

					<br> 
					 <div class="col-md-3">
          <br />
          <input type="submit" name="userSubmits" id="userSubmit" class="btn btn-success" value="Enviar"/> 
          </div>
            </form>
            
            </div> 
  
                  		
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

     
  </section>

<?php require_once('../../pie.php'); }?>
		