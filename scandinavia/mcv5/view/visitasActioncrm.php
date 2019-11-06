<?php
//start session
session_start();

//load and initialize database class
require_once '../clases/DB.class.php';
$db = new DB();

$tblName = 'seguimientos';
//set default redirect url

$redirectURL = '/cotizador/mcv5/historico.php?id='.$_REQUEST['cliente'];

if(isset($_POST['userSubmit'])){
    if(!empty($_POST['fecha']) && !empty($_POST['subject']) && !empty($_POST['comment'])){
        if(!empty($_POST['id'])){
            //update data
            $userData = array(
                'fechavisita' => $_POST['fecha'],
                'subject' => $_POST['subject'],
                'comment' => $_POST['comment'], 
				'iduserinput' => $_POST['iduserinput'],
				'contacto' => $_POST['contacto'],				
				'idcliente' => $_POST['cliente']
            );
            $condition = array('id' => $_POST['id']);
            $update = $db->update($tblName, $userData, $condition);
            if($update){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been updated successfully.';
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';
                
                //set redirect url
                $redirectURL = '/cotizador/mcv5/historico.php?id='.$_REQUEST['cliente'];				
            }
        }else{
            //insert data
            $userData = array(
                'fechavisita' => $_POST['fecha'],
                'subject' => $_POST['subject'],
                'comment' => $_POST['comment'], 
				'iduserinput' => $_POST['iduserinput'],
				'contacto' => $_POST['contacto'],				
				'idcliente' => $_POST['cliente']
            );
            $insert = $db->insert($tblName, $userData);
            if($insert){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.'; 
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';             
                //set redirect url
                $redirectURL = '/cotizador/mcv5/historico.php?id='.$_REQUEST['cliente'];
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
        
        //set redirect url
        $redirectURL = '/cotizador/mcv5/historico.php?id='.$_REQUEST['cliente'];
    }
	
	//store status into the session
    $_SESSION['sessData'] = $sessData;
    
	//redirect to the list page
    header("Location:".$redirectURL);
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])){
    //delete data
    $condition = array('id' => $_GET['id']);
    $delete = $db->delete($tblName, $condition);
    if($delete){
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'User data has been deleted successfully.';
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Some problem occurred, please try again.';
    }
    
    //store status into the session
    $_SESSION['sessData'] = $sessData;

    //redirect to the list page
    header("Location:".$redirectURL);
}
exit();
?>