<?php
//start session
session_start();

//load and initialize database class
require_once '../clases/DB.class.php';
$db = new DB();

$tblName = 'module';
//set default redirect url
if($_REQUEST['action_type'] == 'delete'){
	$redirectURL='../modulos.php?op='. $_GET['op'];
}
else{
    $redirectURL = '../modulos.php?op='. $_POST['op'];
}

if(isset($_POST['userSubmit'])){
    if(!empty($_POST['grupomodulo']) && !empty($_POST['nombregrupo']) && !empty($_POST['codigomodulo']) && !empty($_POST['nombremodulo']) && !empty($_POST['grupoorden'])&& !empty($_POST['moduloorden']) && !empty($_POST['url']) ){
        if(!empty($_POST['id'])){
            //update data
            $userData = array(
                'mod_modulegroupcode' => $_POST['grupomodulo'],
                'mod_modulegroupname' => $_POST['nombregrupo'],
				'mod_modulecode' => $_POST['codigomodulo'],
				'mod_modulename' => $_POST['nombremodulo'],
				'mod_modulegrouporder' => $_POST['grupoorden'],
				'mod_moduleorder' => $_POST['moduloorden'],
				'mod_modulepagename' => $_POST['url'],
				'icon' => $_FILES['file']['name']
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
                $redirectURL = 'addEditmodulos.php?op='. $_POST['op'];				
            }
        }else{
            //insert data
            $userData = array(
                'mod_modulegroupcode' => $_POST['grupomodulo'],
                'mod_modulegroupname' => $_POST['nombregrupo'],
				'mod_modulecode' => $_POST['codigomodulo'],
				'mod_modulename' => $_POST['nombremodulo'],
				'mod_modulegrouporder' => $_POST['grupoorden'],
				'mod_moduleorder' => $_POST['moduloorden'],
				'mod_modulepagename' => $_POST['url'],
				'icon' => $_FILES['file']['name']	
            );
            $insert = $db->insert($tblName, $userData);
            if($insert){
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.'; 
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';             
                
                //set redirect url
                $redirectURL = 'addEditmodulos.php?op='. $_POST['op'];
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
        
        //set redirect url
        $redirectURL = 'addEditmodulos.php?op='. $_POST['op'];
    }
	
	//store status into the session
    $_SESSION['sessData'] = $sessData;
    
	
	//subida de fichero
	  error_reporting(E_ALL);
        ini_set('display_errors', 1);
            $name     = $_FILES['file']['name'];
            $tmpName  = $_FILES['file']['tmp_name'];
            $error    = $_FILES['file']['error'];
            $size     = $_FILES['file']['size'];
            $ext      = strtolower(pathinfo($name, PATHINFO_EXTENSION));
			
			
			$pathReal = getcwd();
			$path = "/home/scandapp/public_html/scandinavia/assets/img/app/";
			$pathmove = "/home/scandapp/public_html/scandinavia/assets/img/app/";
            $path = $path . basename( $_FILES['file']['name']);
           /* if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
             echo "The file ".  basename( $_FILES['file']['name']). 
                " has been uploaded";
             }*/
			
			
           
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if ( !in_array($ext, array('jpg','jpeg','png','gif')) ) {
                        $valid = false;
                        $response = 'Invalid file extension.';
                    }
                    //validate file size
                    if ( $size/1024/1024 > 2 ) {
                        $valid = false;
                        $response = 'File size is exceeding maximum allowed size.';
                    }
                    //upload file
                    if ($valid) {
                        //$targetPath =  "c:\\wamp\\www\\scandinavia\\assets\\img" . DIRECTORY_SEPARATOR. 'app' . DIRECTORY_SEPARATOR. $name;
                        $targetPath =  $pathmove . $name;
						
						
                        move_uploaded_file($tmpName,$targetPath);
                        //header("Location:".$redirectURL);
                        //exit;
                    }
                    break;
                
            }
 
            //echo $response;	
	
	//fin de subida
	
	
	
	
	
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