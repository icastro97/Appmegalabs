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
	$userData = $db->getRows('module', $conditions); //ojo se pone tabla a consultar	
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
          	<h3><i class="fa fa-angle-right"></i> Maestro de Modulos</h3>
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
            <div class="panel-heading"><?php echo $actionLabel; ?> Modulos <a href="../modulos.php?op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-arrow-left"></a></div>
            
                <form method="post" action="modulosAction.php" class="form" id="formulario-contacto" enctype="multipart/form-data">
                  <div class="col-md-6">
                        <label>Grupo Modulo</label><input type="text" class="form-control" name="grupomodulo" placeholder="Grupo Modulo"  value="<?php echo !empty($userData['mod_modulegroupcode'])?$userData['mod_modulegroupcode']:''; ?>">
                    </div>
                  <div class="col-md-6">
                        <label>Nombre Grupo</label>
                        <input type="text" class="form-control" name="nombregrupo" placeholder="Nombre Grupo..." required value="<?php echo !empty($userData['mod_modulegroupname'])?$userData['mod_modulegroupname']:''; ?>">
                    </div>                    
                    
                    
                  <div class="col-md-6">
                        <label>Codigo Modulo</label>
                        <input type="text" class="form-control" name="codigomodulo" placeholder="Codigo Modulo..." required value="<?php echo !empty($userData['mod_modulecode'])?$userData['mod_modulecode']:''; ?>">
                    </div> 
                    
                  <div class="col-md-6">
                        <label>Nombre Modulo</label>
                        <input type="text" class="form-control" name="nombremodulo" placeholder="Nombre Modulo..." required value="<?php echo !empty($userData['mod_modulename'])?$userData['mod_modulename']:''; ?>">
                    </div> 
                    
                    
                   <div class="col-md-6">
                        <label>Grupo Orden</label>
                        <input type="text" class="form-control" name="grupoorden" placeholder="Orden de Grupo..." required value="<?php echo !empty($userData['mod_modulegrouporder'])?$userData['mod_modulegrouporder']:''; ?>">
                    </div> 
                    
                    
                    <div class="col-md-6">
                        <label>Modulo Orden</label>
                        <input type="text" class="form-control" name="moduloorden" placeholder="Orden de Modulo..." required value="<?php echo !empty($userData['mod_moduleorder'])?$userData['mod_moduleorder']:''; ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label>Url</label>
                        <input type="text" class="form-control" name="url" placeholder="Url..." required value="<?php echo !empty($userData['mod_modulepagename'])?$userData['mod_modulepagename']:''; ?>">
                    </div> 
                    
                    
                    
                    <div class="col-md-6">
                    <label for="file">Icono para Mostrar</label>                       
                    <input type="file" name="file" >                   
                    <p class="help-block">solamente jpg,jpeg,png o gif archivo maximo de  1 MB es permitido.</p>
                    
                     <?php if ($userData['mod_modulepagename']!= "") { echo " <label>icono actual :</label> <br> <img src='/scandinavia/assets/img/app/" . $userData['icon'] . "'  />"; }?>
                    </div> 
                    
                                   
                    <br>
                    
                    
                   
            </div>
          </div>
                    
                    
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
		