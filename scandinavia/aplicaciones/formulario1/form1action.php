<?php
//start session
session_start();
//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';

$db = new DB();

$tblName = 'comentarioform';
//set default redirect url
$redirectURL = 'indexform.php?op='. $_POST['op'];




if(isset($_POST['userSubmit'])){
    if(!empty($_POST['producto']) && !empty($_POST['fechaingreso']) && !empty($_POST['comentario']) && !empty($_POST['cantidad']) ){
        if(!empty($_POST['id'])){
            //update data
            $userData = array(
                'producto' => $_POST['producto'],
                'fechaingreso' => $_POST['fechaingreso'],
				'comentario' => $_POST['comentario'],
				'cantidad' => $_POST['cantidad']				
            );
            $condition = array('u_userid' => $_POST['id']);
            $update = $db->update($tblName, $userData, $condition);
            if($update){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been updated successfully.';
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';
                
                //set redirect url
                $redirectURL = 'indexform.php?op='. $_POST['op'];			
            }
        }else{
            //insert data
            $userData = array(
                'producto' => $_POST['producto'],
                'fechaingreso' => $_POST['fechaingreso'],
				'comentario' => $_POST['comentario'],
				'cantidad' => $_POST['cantidad'],
				'userid' => $_POST['userid'],				
            );
            $insert = $db->insert($tblName, $userData);
            if($insert){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.'; 
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';             
                //set redirect url
                $redirectURL = 'indexform.php?op='. $_POST['op'];
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
        
        //set redirect url
        $redirectURL = 'indexform.php?op='. $_POST['op'];
    }
	
	//store status into the session
    $_SESSION['sessData'] = $sessData;
    
	//redirect to the list page
   // header("Location:".$redirectURL);
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])){
    //delete data
    $condition = array('u_userid' => $_GET['id']);
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
    //header("Location:".$redirectURL);
}
exit();
?>