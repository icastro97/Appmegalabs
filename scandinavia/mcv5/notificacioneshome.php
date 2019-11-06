<?php

//require_once("../seguridad/config.php");
$parametro = $_REQUEST['filtro'];
$filtrousuario = $_SESSION['id'];
$status = FALSE;

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//load and initialize database class
require_once 'clases/DB.class.php';
$db = new DB();
//get users from database
 $conditionsh['where'] = array('iduseroutput'=> $filtrousuario,);
$usershome = $db->getRows('vw_llamadas',$conditionsh); //ojo se pone tabla a consultar

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

?>

               <?php if(!empty($usershome)): $count = 0; foreach($usershome as $user): $count++; ?>
					<div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted><?php echo $user['descripcion']; if($user['state'] == 0) { echo " - Sin Leer"; }else { echo " - Leida"; }?></muted><br/>
                            <a href="/cotizador/mcv5/view/addEditllamadasC.php?filtro=<?=$user['tipomensaje']?>&op=<?=$user['descripcion']?>&id=<?=$user['id']?>">De: <?php echo $user['de'];?></a> .<br/>
                            <?php echo $user['subject'];  ?><BR />
                            <?php echo substr(ucwords($user['comment']),0,30); ?>...<br/>
                      		Creada:<?php echo $user['created']; ?>.<br/>
                      		</p>
                      	</div>
                    </div>
                 <?php endforeach; else: ?>
                 Sin Notificaciones...
                 <?php endif; ?>         