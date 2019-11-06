<?php
//start session
session_start();

//load and initialize database class
require_once '../clases/DB.class.php';
$db = new DB();

$tblName = 'role';
//set default redirect url
if($_REQUEST['action_type'] == 'delete'){
	$redirectURL='../roles.php?op='. $_GET['op'];
}
else{
$redirectURL = '../roles.php?op='. $_POST['op'];
}


if(isset($_POST['userSubmit'])){
    if(!empty($_POST['coderol']) && !empty($_POST['namerol'])){
        if(!empty($_POST['id'])){
            //update data
            $userData = array(
                'role_rolecode' => $_POST['coderol'],
                'role_rolename' => $_POST['namerol']				
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
                $redirectURL = 'addEditrole.php?op='. $_POST['op'];				
            }
        }else{
            //insert data
            $userData = array(
                'role_rolecode' => $_POST['coderol'],
                'role_rolename' => $_POST['namerol']	
            );
            $insert = $db->insert($tblName, $userData);
            if($insert){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.'; 
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';             
                //set redirect url
                $redirectURL = 'addEditrole.php?op='. $_POST['op'];
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
        
        //set redirect url
        $redirectURL = 'addEditrole.php?op='. $_POST['op'];
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