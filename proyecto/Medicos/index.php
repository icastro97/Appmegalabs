<?php
//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
if(!empty($_GET['id'])){
	include '../../scandinavia/mcv5/clases/DB.class.php';		
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

<?php require('../../scandinavia/cabeza.php'); 
$embebida = "";
if(isset($_REQUEST['url'])){
	$embebida = $_REQUEST['url'];	
}


?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>FormularioMedicos</title>
  <base href="https://appmegalabs.com/proyecto/Medicos/">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="styles.8eb8bf5fb9e7b6b6ca4f.css"></head>
<body>
  <div class="container">
  <app-root></app-root>
</div>
<script src="runtime-es2015.d61f42a1e4be5689ac82.js" type="module"></script><script src="polyfills-es2015.a8cf2d3dc3edef6712e4.js" type="module"></script><script src="runtime-es5.0c5226cce70e491b47d0.js" nomodule defer></script><script src="polyfills-es5.b92542f53d263a30d490.js" nomodule defer></script><script src="main-es2015.b3b58ab3d29bff65fa17.js" type="module"></script><script src="main-es5.f37167eefc4374fb3056.js" nomodule defer></script></body>
</html>



<?php require_once('../../pie.php'); ?>


