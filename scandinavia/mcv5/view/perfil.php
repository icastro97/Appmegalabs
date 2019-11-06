

<?php
//start session
session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
require_once '../clases/DB.class.php';
$db = new DB();
	$conditions['where'] = array(
		'u_userid' => $_SESSION["user_id"],
	);
	$conditions['return_type'] = 'single';
	$userData = $db->getRows('vw_perfilusr', $conditions); //ojo se pone tabla a consultar
	


$actionLabel = !empty($_GET['id'])?'Editar':'Informacion';

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
          	<h3><i class="fa fa-angle-right"></i> Informacion del Usuario <?=$userData['nombres']?></h3>
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
            <div class="panel-heading"><?php echo $actionLabel; ?> Usuarios <a href="/scandinavia/default1.php?group=Aplicaciones" class="glyphicon glyphicon-arrow-left"></a></div>
           
                <form method="post" action="/scandinavia/default1.php?group=Aplicaciones" class="form" id="formulario-contacto">
                  <div class="col-md-6">
                        <label>Usuario</label><input type="text" class="form-control" name="username" placeholder="Usuario"  value="<?php echo !empty($userData['u_username'])?$userData['u_username']:''; ?>">
                    </div>
                  <div class="col-md-3">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="Password..." required value="<?php echo !empty($userData['u_password'])?$userData['u_password']:''; ?>">  <a href="/scandinavia/seguridad/updatePassword.php">Cambiar Contraseña</a>
                    </div>                    
                    
                
                  <div class="col-md-6">
                        <label>Identificacion</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Nombres..." required value="<?php echo !empty($userData['cedula'])?$userData['cedula']:''; ?>">
                    </div>  
                 
                  <div class="col-md-6">
                        <label>Nombres</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Nombres..." required value="<?php echo !empty($userData['nombres'])?$userData['nombres']:''; ?>">
                    </div> 
                    
                    
                  <div class="col-md-6"> 
                   <label>Rol</label>
                   <input type="text" class="form-control" name="fullname" placeholder="Rol..." required value="<?php echo !empty($userData['u_rolecode'])?$userData['u_rolecode']:''; ?>">
                  </div> 
                  
                  <div class="col-md-6"> 
                   <label>Email</label>
                   <input type="text" class="form-control" name="fullname" placeholder="Email..." required value="<?php echo !empty($userData['email'])?$userData['email']:''; ?>">
                  </div> 
                  
                    <div class="col-md-6"> 
                   <label>Cargo</label>
                   <input type="text" class="form-control" name="fullname" placeholder="Cargo..." required value="<?php echo !empty($userData['cargo'])?$userData['cargo']:''; ?>">
                  </div>
                  
                  <div class="col-md-6"> 
                   <label>Linea</label>
                   <input type="text" class="form-control" name="fullname" placeholder="Linea..." value="<?php echo !empty($userData['linea'])?$userData['linea']:''; ?>">
                  </div> 
                  
                   <div class="col-md-6"> 
                   <label>Area Terapeutica</label>
                   <input type="text" class="form-control" name="fullname" placeholder="Area Terapeutica..."  value="<?php echo !empty($userData['areaterapeutica'])?$userData['areaterapeutica']:''; ?>">
                  </div>
                  
                  <div class="col-md-6"> 
                   <label>Centro de Costo</label>
                   <input type="text" class="form-control" name="fullname" placeholder="Centro de Costo..." required value="<?php echo !empty($userData['centrocosto'])?$userData['centrocosto']:''; ?>">
                  </div> 
                  
                  
                   <div class="col-md-6"> 
                   <label>Firma</label>
                   <img src="../../aplicaciones/Anticipos/<?php echo $userData['ubicacionFirma']?>" width="100" height="100"/> </div> 
                                                          
                    <br>
                    <?php  $varid = 0;
					       if(isset($userData['u_userid'])) { $varid = $userData['u_userid'];;}  ?>
					<input type="hidden" name="id" value="<?php echo $varid; ?>">
                     <input type="hidden" name="op" value="<?php echo $_REQUEST['op'];?>">

					<br> 
					 <div class="col-md-6">
<br />
<input type="submit" name="userSubmit" class="btn btn-success" value="Hecho"/> 
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