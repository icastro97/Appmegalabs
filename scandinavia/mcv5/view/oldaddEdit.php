<?php
//start session
session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
if(!empty($_GET['id'])){
	include '/clases/DB.class.php';
	$db = new DB();
	$conditions['where'] = array(
		'id' => $_GET['id'],
	);
	$conditions['return_type'] = 'single';
	$userData = $db->getRows('x2_contacts', $conditions);
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP CRUD Operations by CodexWorld</title>
<meta charset="utf-8">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="varios/validator.js"></script>
<style type="text/css">
.container{padding: 10px;}
.glyphicon{font-size: 20px;}
.glyphicon-arrow-left{float: right;}
a.glyphicon{text-decoration: none;}
</style>
</head>
<body>
<div class="container">
	<?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<?php } ?>
    <div class="row">
            <div class="panel panel-default users-content">
            <div class="panel-heading"><?php echo $actionLabel; ?> User <a href="../indexoriginal.php" class="glyphicon glyphicon-arrow-left"></a></div>
            <div class="panel-body">
                <form method="post" action="userAction.php" class="form" id="formulario-contacto">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Digite seu Nome..." required value="<?php echo !empty($userData['name'])?$userData['name']:''; ?>">
                    </div>
                    <div class="form-group">
                        <label>NIT</label>
                        <input type="text" class="form-control" name="nit" placeholder="Digite Numero de Identificacion Tributaria"  value="<?php echo !empty($userData['nameid'])?$userData['nameid']:''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo !empty($userData['email'])?$userData['email']:''; ?>" placeholder="Digite seu E-mail" data-error="Por favor, informe um e-mail correto." required>	    
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="number" class="form-control" name="phone" data-error="Por favor, debe contener solo numeros" required value="<?php echo !empty($userData['phone'])?$userData['phone']:''; ?>">
                    </div>
                    
                    
                    <?php  $varid = 0;
					       if(isset($userData['id'])) { $varid = $userData['id'];;}  ?>
					<input type="hidden" name="id" value="<?php echo $varid; ?>">
					<input type="submit" name="userSubmit" class="btn btn-success" value="SUBMIT"/>
                </form>
            </div>
		</div>
    </div>
</div>
</body>
</html>