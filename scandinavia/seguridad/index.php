<?php
//header ("Location: http://www.appmegalabs.com");
session_start();
$_SESSION = array();
unset($_SESSION);
session_destroy();



require_once("config.php");
require_once '../mcv5/clases/DB.class.php';

$db = new DB();
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != "") {
    // if logged in send to dashboard page
    redirect("default.php");
}

//
//echo "valor: " . $_COOKIE['remember'];
if (isset($_COOKIE['remember']))
{
    // no te olvides de escapar la cookie
	$conditions['where'] = array(
		'remember_key' => $_COOKIE['remember'],
	);
		
    $conditions['return_type'] = 'single';
	$userData = $db->getRows('system_users', $conditions); //ojo se pone tabla a consultar
	
	if(!empty($userData)) {
		 // generar uno aleatorio
            //$remember = md5(uniqid(mt_rand(), true));

            // colocar el tiempo que quieras
            //setcookie("remember", $remember, time()+3600, "/");

            // actualizar el remember_key del usuario
            				
			    $_SESSION["errorType"] = "success";
                $_SESSION["errorMsg"] = "You have successfully logged in.";

                $_SESSION["user_id"] = $userData['u_userid'];
                $_SESSION["rolecode"] = $userData['u_rolecode'];
                $_SESSION["username"] = $userData['u_username'];
				
				$_SESSION['session_username']=$userData['u_username'];	
				$_SESSION['session_name']=$userData['full_name']; 	
				$_SESSION['id']=$userData['u_userid'];
				$_SESSION['identifica']=$results[0]["cedula"];
				$_SESSION['correo']=$userData['email']; 
				
			    redirect("../default.php");
					 
			/*
			$tblName = "system_users";
			$condition = array('u_userid' => $userData['u_userid']);
			$userData = array('remember_key' => $remember);		
			$update = $db->update($tblName, $userData, $condition);
			*/
	}	
    // consulta here
	// guardar tu informaciomn de sesion en $_SESSION	
} 
//

$title = "Portal de Aplicaciones ";
$mode = $_REQUEST["mode"];
if ($mode == "login") {
    $username = trim($_POST['username']);
    $pass = trim($_POST['user_password']);

    if ($username == "" || $pass == "") {

        $_SESSION["errorType"] = "danger";
        $_SESSION["errorMsg"] = "Campos obligatorios";
    } else {
        $sql = "SELECT * FROM system_users WHERE u_username = :uname AND u_password = :upass ";

        try {
            $stmt = $DB->prepare($sql);

            // bind the values
            $stmt->bindValue(":uname", $username);
            $stmt->bindValue(":upass", $pass);

            // execute Query
            $stmt->execute();
            $results = $stmt->fetchAll();

            if (count($results) > 0) {
				
				if (isset($_POST['remember']))
         		{
					// generar uno aleatorio
					$remember = md5(uniqid(mt_rand(), true));
					
					// colocar el tiempo que quieras
					setcookie("remember", $remember, time()+10800, "/");
					
					// consulta sql de UPDATE
					//
					 $updatecookie = "UPDATE FROM system_users SET remember_key = " . $remember . " WHERE user_id = " . $results[0]["u_userid"];
					
					 $tblName = "system_users";
					 $condition = array('u_userid' => $results[0]["u_userid"]);
					 $userData = array('remember_key' => $remember);					 
                     $update = $db->update($tblName, $userData, $condition);
					// ejecutar consulta
         		}				
				
				
                $_SESSION["errorType"] = "success";
                $_SESSION["errorMsg"] = "You have successfully logged in.";

                $_SESSION["user_id"] = $results[0]["u_userid"];
                $_SESSION["rolecode"] = $results[0]["u_rolecode"];
                $_SESSION["username"] = $results[0]["u_username"];
				
				$_SESSION['session_username']=$results[0]["u_username"];	
				$_SESSION['session_name']=$results[0]["full_name"];	
				$_SESSION['id']=$results[0]["u_userid"];
				$_SESSION['identificacion']=$results[0]["cedula"];
				$_SESSION['correo']=$results[0]["email"];
                //redirect("dashboard.php");
				redirect("../default.php");
				

                exit;
            } else {
                $_SESSION["errorType"] = "info";
                $_SESSION["errorMsg"] = "Nombre de usuario o password no existe.";
            }
        } catch (Exception $ex) {

            $_SESSION["errorType"] = "danger";
            $_SESSION["errorMsg"] = $ex->getMessage();
        }
    }
    redirect("index.php");
}
include 'header.php';

?>
<style>

@media screen and (max-width: 800px) 
{
  .imagen 
  {
    width:100%;  
  }
}


@media screen and (max-width: 600px) 
{
  .imagen 
  {
    width:100%;  
  }
}
</style>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" name="contact_form" id="contact_form" method="post" action="">
            <div align="center">
              <p>
                <input type="hidden" name="mode" value="login" >
              <img src="../assets/img/icono.png" width="100" height="100"><br>
              <img src="../assets/img/Logotipo.png" width="250">
              </p>
              <p><br />
              </p>
            </div>
            
            <fieldset>
             

                <div class="form-group" >
                    <label class="col-lg-4 control-label" for="username"><span class="required">*</span>Usuario:</label>
                    <div class="col-lg-4" >
                        <input type="text" value="" placeholder="User Name" id="username" class="form-control" name="username" required="Campo Necesario" >
                    </div>
                </div>

                <div class="form-group" >
                    <label class="col-lg-4 control-label" for="user_password"><span class="required">*</span>Contraseña:</label>
                    <div class="col-lg-4">
                        <input type="password" value="" placeholder="Password" id="user_password" class="form-control" name="user_password" required="Necesario" >
                    </div>
                    
                 </div>  
                   
               <!-- <div class="form-group" >
                     <label class="col-lg-4 control-label" for="user_password"><span class="required"></span>Recordarme:</label>
                    <div class="col-lg-4" align="left">
                          <input type="hidden" name="remember" value="1" class="checkbox">   
                    </div>
                 </div>  -->    
                  
                    
                 

                <div class="form-group" >
                    
                    <div class="col-lg-6 control-label" align="center">
                        <button class="btn" style="background-color:#00965e; color:white;" type="submit">Enviar</button> 
                    </div>
                    
                </div>
                <div class="form-group" >
                    <div class="col-md-3" align="center">
                         
                    </div>
                    <div class="col-lg-6" align="center">
                          <a href="forgotPassword.php" >&iquest;Olvidaste tu contraseña?</a>
                    </div>
                 </div>
                
                <div style="height: 10px;">&nbsp;</div>
                <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-2">
                       <div class="help-block">
                                                 <p align="center"><img class="imagen" src="../assets/img/Cenefa-01.png" />
                         </p>
                      </div>
                    </div>
                </div>
                
            </fieldset>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>