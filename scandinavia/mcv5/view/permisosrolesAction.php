<?php
//start session
session_start();

//load and initialize database class
require_once '../clases/DB.class.php';
$db = new DB();

$tblName = 'role_rights';
//set default redirect url
if($_REQUEST['action_type'] == 'delete'){
	$redirectURL='../permisosroles.php?op='. $_GET['op'];
}
else{
$redirectURL = '../permisosroles.php?op='. $_POST['op'];
}

if(isset($_POST['userSubmit'])){
	
	$arr_use = $_POST["create"];
	for($i=0; $i<count($arr_use); $i++)
	{
	   if($arr_use[$i] == "yes"){
		   unset($arr_use[$i + 1]);
	   }			
	}
	$new_array = array_values($arr_use);
	//print_r($new_array);		
	$createrole = $new_array[0];	
	
	
	$arr_use = $_POST["edit"];
	for($i=0; $i<count($arr_use); $i++)
	{
	   if($arr_use[$i] == "yes"){
		   unset($arr_use[$i + 1]);
	   }			
	}
	$new_array = array_values($arr_use);
	//print_r($new_array);		
	$editarole = $new_array[0];	


	$arr_use = $_POST["delete"];
	for($i=0; $i<count($arr_use); $i++)
	{
	   if($arr_use[$i] == "yes"){
		   unset($arr_use[$i + 1]);
	   }			
	}
	$new_array = array_values($arr_use);
	//print_r($new_array);		
	$deletearole = $new_array[0];	
	
	
	$arr_use = $_POST["view"];
	for($i=0; $i<count($arr_use); $i++)
	{
	   if($arr_use[$i] == "yes"){
		   unset($arr_use[$i + 1]);
	   }			
	}
	$new_array = array_values($arr_use);
	//print_r($new_array);		
	$viewrole = $new_array[0];		
	
    if(!empty($_POST['rolecode']) && !empty($_POST['modulocode']) ){
        if(!empty($_POST['id'])){
            //update data

            $userData = array(
                'rr_rolecode' => $_POST['rolecode'],
                'rr_modulecode' => $_POST['modulocode'],
				'rr_create' => $createrole,
				'rr_edit' => $editarole,
				'rr_delete' => $deletearole,
				'rr_view' => $viewrole				
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
                $redirectURL = 'addEditpermisosroles.php?op='. $_POST['op'];				
            }			
        }else{
            //insert data
            $userData = array(
                'rr_rolecode' => $_POST['rolecode'],
                'rr_modulecode' => $_POST['modulocode'],
				'rr_create' => $createrole,
				'rr_edit' => $editarole,
				'rr_delete' => $deletearole,
				'rr_view' => $viewrole	
            );
            $insert = $db->insert($tblName, $userData);
            if($insert){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.'; 
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';             
                //set redirect url
                $redirectURL = 'addEditpermisosroles.php?op='. $_POST['op'];
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
        
        //set redirect url
        $redirectURL = 'addEditpermisosroles.php?op='. $_POST['op'];
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