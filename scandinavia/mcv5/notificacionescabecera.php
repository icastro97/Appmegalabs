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
 $conditionscab['where'] = array('iduseroutput'=> $filtrousuario,);
 $conditionscab['limit'] = '6';
$userscabecera = $db->getRows('vw_llamadas',$conditionscab); //ojo se pone tabla a consultar

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

?>

<?php $concatenanota= ""; $concatenallamada= "";?>

	<?php if(!empty($userscabecera)): $countcabecera = 0; $countcabeceranota =0;$countcabecerallamada =0;  foreach($userscabecera as $user): $countcabecera++; ?>
         <?php if($user['state'] == 0 && $user['tipomensaje'] == 1){
			 $countcabecerallamada++;
			 $concatenallamada .=   "<li><a href=\"/cotizador/mcv5/view/addEditllamadasC.php?filtro=1&op=LLAMADAS&id=" .$user['id'] . "\"> <span class=\"subject\">" .  "<span class=\"from\">" . $user['de']. "</span>";
               $concatenallamada .= "<span class=\"time\">&nbsp;</span>";
               $concatenallamada .= "</span>";
               $concatenallamada .= "<span class=\"message\">" . $user['subject'] . "</span></a></li>";			 			 
		 }
		 if($user['state'] == 0 && $user['tipomensaje'] == 2){
			 $countcabeceranota++;
			  
			   $concatenanota .=   "<li><a href=\"/cotizador/mcv5/view/addEditllamadasC.php?filtro=2&op=NOTAS&id=" .$user['id'] . "\"><span class=\"subject\">" .  "<span class=\"from\">" . $user['de']. "</span>";
               $concatenanota .= "<span class=\"time\">&nbsp;</span>";
               $concatenanota .= "</span>";
               $concatenanota .= "<span class=\"message\">" . $user['subject'] . "</span> </a></li>";			  		 
		 }
		 ?>
    <?php endforeach; else: ?>
    <?php endif; ?>         
    
    
    
    