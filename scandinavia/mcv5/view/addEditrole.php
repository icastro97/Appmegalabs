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
	$userData = $db->getRows('role', $conditions); //ojo se pone tabla a consultar
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
          	<h3><i class="fa fa-angle-right"></i> Maestro de Roles</h3>
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
            <div class="panel-heading"><?php echo $actionLabel; ?> Roles <a href="../roles.php?op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-arrow-left"></a></div>
           
                <form method="post" action="roleAction.php" class="form" id="formulario-contacto">
                  <div class="col-12">
                        <label>Codigo de Rol</label>
                        <input type="text" class="form-control" name="coderol" placeholder="Codigo de Rol"  value="<?php echo !empty($userData['role_rolecode'])?$userData['role_rolecode']:''; ?>">
                    </div>
                  <div class="col-md-12">
                        <label>Nombre de Rol</label>
                        <input type="text" class="form-control" name="namerol" placeholder="Nombre de Rol..." required value="<?php echo !empty($userData['role_rolename'])?$userData['role_rolename']:''; ?>">
                    </div>                    
                    
                    <br>
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