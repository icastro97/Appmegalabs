<?php
//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
if(!empty($_GET['id'])){
	include '../../mcv5/clases/DB.class.php';	
		
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
$embebida = "";
if(isset($_REQUEST['url'])){
	$embebida = $_REQUEST['url'];	
}


if(!isset($_SESSION["session_username"])) {	
  header("location:../../logininicial.php");  
  
} 
else {?>

 
<div class="embed-container">
    <iframe width="933" height="700" src="<?php echo $embebida; ?>" frameborder="0" allowfullscreen></iframe>
</div>

<?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<?php } ?>

<?php require_once('../../mcv5/index.php'); ?>

                    

<?php require_once('../../pie.php'); }?>
		