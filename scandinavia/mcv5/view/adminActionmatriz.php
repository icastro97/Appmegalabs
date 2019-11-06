<?php
//start session
session_start();

//load and initialize database class
require_once '../clases/DB.class.php';
$db = new DB();

$tblName = 'matrizaprobacion';
//set default redirect url
if($_REQUEST['action_type'] == 'delete'){
	$redirectURL='../adminmatriz.php?op='. $_GET['op'];
}
else{
$redirectURL = '../adminmatriz.php?op='. $_POST['op'];
}


$permitidos = $_POST['usuarios'];
 
foreach($permitidos as $permitido){
    $valor = $permitido;
    $permitido_aux[] = $valor;
}
$valores = implode(', ', $permitido_aux);

if(isset($_POST['userSubmit'])){
    if(!empty($_POST['paso']) && !empty($_POST['usuarios']) && !empty($_POST['procesos']) ){
        if(!empty($_POST['id'])){
            //update data
            $userData = array(
                'idproceso' => $_POST['procesos'],
                'paso' => $_POST['paso'],
				'responsable' => $valores,
				'descripcion' => $_POST['descripcion']
						
            );
            $condition = array('idarray' => $_POST['id']);
            $update = $db->update($tblName, $userData, $condition);
            if($update){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been updated successfully.';
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';
                
                //set redirect url
                $redirectURL = 'addEditmatriz.php?op='. $_POST['op'];			
            }
        }else{
            //insert data
            $userData = array(
                'idproceso' => $_POST['procesos'],
                'paso' => $_POST['paso'],
				'responsable' => $valores,
				'descripcion' => $_POST['descripcion']					
            );
            $insert = $db->insert($tblName, $userData);
            if($insert){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.'; 
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';             
                //set redirect url
                $redirectURL = 'addEditmatriz.php?op='. $_POST['op'];
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
        
        //set redirect url
        $redirectURL = 'addEditmatriz.php?op='. $_POST['op'];
    }
	
	//store status into the session
    $_SESSION['sessData'] = $sessData;
    
	//redirect to the list page
    header("Location:".$redirectURL);
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])){
    //delete data
    $condition = array('idarray' => $_POST['id']);
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