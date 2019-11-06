<?php
require_once("config.php");
require_once '../mcv5/clases/DB.class.php';
$user = new DB();
$tblName = 'system_users';

function validar_clave($clave,&$error_clave){
   if(strlen($clave) < 6){
      $error_clave = "La clave nueva debe tener al menos 6 caracteres";
      return false;
   }
   if(strlen($clave) > 16){
      $error_clave = "La clave nueva no puede tener más de 16 caracteres";
      return false;
   }
   if (!preg_match('`[a-z]`',$clave)){
      $error_clave = "La clave nueva debe tener al menos una letra minuscula";
      return false;
   }
   if (!preg_match('`[A-Z]`',$clave)){
      $error_clave = "La clave nueva debe tener al menos una letra mayuscula";
      return false;
   }
   if (!preg_match('`[0-9]`',$clave)){
      $error_clave = "La clave nueva debe tener al menos un caracter numerico";
      return false;
   }
   $error_clave = "";
   return true;
}  


//control updte pwd
if(isset($_POST['updateSubmit'])){
	
	if(!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['passwordold'])){
        $fp_code = $_POST['passwordold'];
		$userid = 3;//$_POST['userid'];
		
		 $error_encontrado="";
		 $stringclave="";
		 $validaok = 1;
		   if (validar_clave($_POST["password"], $error_encontrado)){
			  $stringclave = "PASSWORD VALIDO";
		   }else{
			  $stringclave = $error_encontrado;
			  $sessData['status']['type'] = 'error';
			  $sessData['status']['msg'] = 'Ha ocurrido algún problema, ' . $stringclave;		  			  
			  $validaok = 0;
		   }
		 
		 if($validaok == 1){
					//password and confirm password comparison
					if($_POST['password'] !== $_POST['confirm_password']){
						$sessData['status']['type'] = 'error';
						$sessData['status']['msg'] = 'Confirm password must match with the password.'; 
					}else{
						//check whether identity code exists in the database
						$prevCon['where'] = array('u_password' => $fp_code, 'u_userid' => $userid);			
						$prevCon['return_type'] = 'single';
						$prevUser = $user->getRows($tblName ,$prevCon);
						if(!empty($prevUser)){
							//update data with new password
							$conditions = array(
								'u_password' => $fp_code, 'u_userid' => $userid
							);
							$data = array(
								'u_password' => ($_POST['password'])
							);
							$update = $user->update($tblName,$data, $conditions);
							if($update){
								$sessData['status']['type'] = 'success';
								$sessData['status']['msg'] = 'La contraseña de su cuenta se ha actualizado correctamente. Por favor ingrese con su nueva contraseña.';
							}else{
								$sessData['status']['type'] = 'error';
								$sessData['status']['msg'] = 'Ha ocurrido algún problema, por favor intente de nuevo.';
							}
						}else{
							$sessData['status']['type'] = 'error';
							$sessData['status']['msg'] = 'La contraseña que usted quiere modificar no concuerda con la de su usuario.';
						}
					}
				} 
	     }		 
		 
		 $_SESSION['sessData'] = $sessData;		 
         $redirectURL = ($sessData['status']['type'] == 'success')?'index.php':'updatePassword.php';
         //redirect to the login/reset pasword page
         header("Location:".$redirectURL);		 		 		 		
}
//




if(isset($_POST['forgotSubmit'])){
    //check whether email is empty
    if(!empty($_POST['email'])){
        //check whether user exists in the database
        $prevCon['where'] = array('email'=>$_POST['email']);
        $prevCon['return_type'] = 'count';
        $prevUser = $user->getRows($tblName,$prevCon);
        if($prevUser > 0){
            //generat unique string
            $uniqidStr = md5(uniqid(mt_rand()));
            
            //update data with forgot pass code
            $conditions = array(
                'email' => $_POST['email']
            );
            $data = array(
                'forgot_pass_identity' => $uniqidStr
            );
            $update = $user->update($tblName, $data, $conditions);
            
            if($update){
                $resetPassLink = 'https://appmegalabs.com/scandinavia/seguridad/resetPassword.php?fp_code='.$uniqidStr;
                
                //get user details
                $con['where'] = array('email'=>$_POST['email']);
                $con['return_type'] = 'single';
                $userDetails = $user->getRows($tblName ,$con);
                
                //send reset password email
                $to = $userDetails['email'];
                $subject = "Actualizacion de Password";
                $mailContent = 'Estimado(a) '.$userDetails['full_name'].', 
                <br>Recientemente se envió una solicitud para restablecer una contraseña para su cuenta. Si esto fue un error, simplemente ignora este correo electrónico y no pasará nada.
                <br><br>Para restablecer la contraseña, visite el siguiente enlace: <a href="'.$resetPassLink.'">'.$resetPassLink.'</a>
                <br><br>Saludos';
                //set content-type header for sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                //$headers = "MIME-Version: 1.0" . "rn";
                //$headers .= "Content-type:text/html;charset=UTF-8" . "rn";
                //additional headers
                //$headers .= 'From: Tu<[email protected]>' . "rn";
                $headers .='From: Aplicaciones Scandinavia Pharma <no-reply@appscandinavia.com>';
                //send email
                mail($to,$subject,$mailContent,$headers);
                
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'Por favor revise su correo electrónico, hemos enviado un enlace para restablecer su contraseña a su correo electrónico registrado.';
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Ha ocurrido algún problema, por favor intente de nuevo.';
            }
        }else{
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'El correo electrónico dado no está asociado a ninguna cuenta..' . $_POST['email']; 
        }
        
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Ingrese el correo electrónico para crear una nueva contraseña para su cuenta.'; 
    }
    //store reset password status into the session
    $_SESSION['sessData'] = $sessData;
    //redirect to the forgot pasword page
    header("Location:forgotPassword.php");
}elseif(isset($_POST['resetSubmit'])){
    $fp_code = '';
    if(!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['fp_code'])){
        $fp_code = $_POST['fp_code'];
        //password and confirm password comparison
        if($_POST['password'] !== $_POST['confirm_password']){
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Confirmar contraseña, deben coincidir.'; 
        }else{
            //check whether identity code exists in the database
            $prevCon['where'] = array('forgot_pass_identity' => $fp_code);
            $prevCon['return_type'] = 'single';
            $prevUser = $user->getRows($tblName ,$prevCon);
            if(!empty($prevUser)){
                //update data with new password
                $conditions = array(
                    'forgot_pass_identity' => $fp_code
                );
                $data = array(
                    //'u_password' => md5($_POST['password'])
					'u_password' => ($_POST['password'])
                );
                $update = $user->update($tblName,$data, $conditions);
                if($update){
                    $sessData['status']['type'] = 'success';
                    $sessData['status']['msg'] = 'La contraseña de su cuenta se ha restablecido correctamente. Por favor ingrese con su nueva contraseña.';
                }else{
                    $sessData['status']['type'] = 'error';
                    $sessData['status']['msg'] = 'Ha ocurrido algún problema, por favor intente de nuevo.';
                }
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'No tiene autorización para restablecer la nueva contraseña de esta cuenta.';
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Todos los campos son obligatorios, por favor complete todos los campos..'; 
    }
    //store reset password status into the session
    $_SESSION['sessData'] = $sessData;
    $redirectURL = ($sessData['status']['type'] == 'success')?'index.php':'resetPassword.php?fp_code='.$fp_code;
    //redirect to the login/reset pasword page
    header("Location:".$redirectURL);
}