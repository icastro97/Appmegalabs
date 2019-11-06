<?php
//start session
session_start();

//load and initialize database class
require_once '../clases/DB.class.php';
$db = new DB();

$tblName = 'x2_contacts';
//set default redirect url
if($_REQUEST['action_type'] == 'delete'){
	$redirectURL='../clientes.php?op='. $_GET['op'];
}
else{
$redirectURL = '../clientes.php?op='. $_POST['op'];
}

if(isset($_POST['userSubmit'])){
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone'])){
        if(!empty($_POST['id'])){
            //update data
            $userData = array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'], 
				'nameid' => $_POST['nameid'],
				'firstName' => $_POST['firstname'],
				'lastname' => $_POST['lastname'],
				'title' => $_POST['title'],
				'company' => $_POST['company'],
				'phone2' => $_POST['phone2'],
				'website' => $_POST['website'],
				'address' => $_POST['address'],
				'address2' => $_POST['address2'],
				'city' => $_POST['city'],
				'state' => $_POST['state'],
				'country' => $_POST['country']
				
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
                $redirectURL = 'addEdit.php?op='. $_POST['op'];				
            }
        }else{
            //insert data
            $userData = array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'], 
				'nameid' => $_POST['nameid'],
				'firstName' => $_POST['firstname'],
				'lastname' => $_POST['lastname'],
				'title' => $_POST['title'],
				'company' => $_POST['company'],
				'phone2' => $_POST['phone2'],
				'website' => $_POST['website'],
				'address' => $_POST['address'],
				'address2' => $_POST['address2'],
				'city' => $_POST['city'],
				'state' => $_POST['state'],
				'country' => $_POST['country']
            );
            $insert = $db->insert($tblName, $userData);
            if($insert){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.'; 
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';             
                //set redirect url
                $redirectURL = 'addEdit.php?op='. $_POST['op'];
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
        
        //set redirect url
        $redirectURL = 'addEdit.php?op='. $_POST['op'];
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