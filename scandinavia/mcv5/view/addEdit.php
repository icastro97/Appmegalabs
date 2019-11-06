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


if(!isset($_SESSION["session_username"])) {	
  header("location:../../logininicial.php");
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
          	<h3><i class="fa fa-angle-right"></i> Maestro de Clientes</h3>
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
            <div class="panel-heading"><?php echo $actionLabel; ?> Cliente <a href="../clientes.php?op=<?php echo $_REQUEST['op'];?>&pos=<?php echo $_REQUEST['pos'];?>" class="glyphicon glyphicon-arrow-left"></a></div>
           
                <form method="post" action="userAction.php" class="form" id="formulario-contacto">
                  <div class="col-md-6">
                        <label>NIT</label>
                        <input type="text" class="form-control" name="nameid" placeholder="Digite Numero de Identificacion Tributaria"  value="<?php echo !empty($userData['nameId'])?$userData['nameId']:''; ?>">
                    </div>
                  <div class="col-md-6">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="name" placeholder="Digite Nombre de Organizacion..." required value="<?php echo !empty($userData['name'])?$userData['name']:''; ?>">
                    </div>                    
                    
                  <div class="col-md-6">
                        <label>Nombre Contacto</label>
                        <input type="text" class="form-control" name="firstname" placeholder="Digite Nombre de Contacto..." required value="<?php echo !empty($userData['firstName'])?$userData['firstName']:''; ?>">
                    </div>   
                  <div class="col-md-6">
                        <label>Apellido Contacto</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Digite Apellido de Contacto..." required value="<?php echo !empty($userData['lastName'])?$userData['lastName']:''; ?>">
                    </div>                                           
                  <div class="col-md-6">
                        <label>Titulo</label>
                        <input type="text" class="form-control" name="title" placeholder="Digite titulo de Contacto..."  value="<?php echo !empty($userData['title'])?$userData['title']:''; ?>">
                    </div>  
                    
                  <div class="col-md-6">
                        <label>Empresa</label>
                        <input type="text" class="form-control" name="company" placeholder="Digite Nombre Organizacion..." required value="<?php echo !empty($userData['company'])?$userData['company']:''; ?>">
                    </div>
                    
                  <div class="col-md-6">
                        <label>Telefono</label>
                        <input type="number" class="form-control" name="phone" data-error="Por favor, debe contener solo numeros" required value="<?php echo !empty($userData['phone'])?$userData['phone']:''; ?>">
                    </div>
                  <div class="col-md-6">
                        <label>Telefono 2</label>
                        <input type="number" class="form-control" name="phone2" data-error="Por favor, debe contener solo numeros"  value="<?php echo !empty($userData['phone2'])?$userData['phone2']:''; ?>">
                    </div>
                    
                  <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo !empty($userData['email'])?$userData['email']:''; ?>" placeholder="Digite E-mail" data-error="Por favor, informe um e-mail correto." required>	    
                        <div class="help-block with-errors"></div>
                    </div>
                    
                  <div class="col-md-6">
                        <label>WebSite</label>
                        <input type="text" class="form-control" name="website" placeholder="Digite Sitio Web..."  value="<?php echo !empty($userData['website'])?$userData['website']:''; ?>">
                    </div>
                    
                  <div class="col-md-6">
                        <label>Direccion</label>
                        <input type="text" class="form-control" name="address" placeholder="Direccion..." required value="<?php echo !empty($userData['address'])?$userData['address']:''; ?>">
                    </div>
                    
                  <div class="col-md-6">
                        <label>Direccion 2</label>
                        <input type="text" class="form-control" name="address2" placeholder="Direccion 2..."  value="<?php echo !empty($userData['address2'])?$userData['address2']:''; ?>">
                    </div>
                    
                  <div class="col-md-6">
                        <label>Ciudad</label>
                        <input type="text" class="form-control" name="city" placeholder="Ciudad..." required value="<?php echo !empty($userData['city'])?$userData['city']:''; ?>">
                    </div>                    
                    
                  <div class="col-md-6">
                        <label>Estado</label>
                        <input type="text" class="form-control" name="state" placeholder="Departamento..." required value="<?php echo !empty($userData['state'])?$userData['state']:''; ?>">
                    </div>    
                    
                  <div class="col-md-6">
                        <label>Pais</label>
                        <input type="text" class="form-control" name="country" placeholder="Pais..." required value="<?php echo !empty($userData['country'])?$userData['country']:''; ?>">
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
		