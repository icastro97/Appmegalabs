
<?php
$title = "Restablecer Contraseña";
include 'header.php';
session_start();
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
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

<title>. :: Restablecer la contraseña de su cuenta :: .</title>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal"  action="userAccount.php" method="post">
            <div align="center">
              <p>
                <input type="hidden" name="mode" value="login" >
              <img src="../assets/img/icono.png" width="100" height="100"><br>
                <img src="../assets/img/Logotipo.png" width="250"></p>
             
            </div>
            <fieldset>
                
             <br /><br />   
            <div class="form-group">
                <div class="row">
                   <div class="col-md-1">
                       
                   </div> 
                   <div class="col-md-3">
                       
                   </div> 
                   <div class="col-md-5">
                         <h4>Restablecer la contraseña de su cuenta</h4>
                          <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?> 
                    
                   </div>      
                </div>      
                
                
                     
                    
                <div class="row">
                    <div class="col-md-1" >
                             
                    </div>     
                    <div class="col-md-3">
                             
                    </div>     
                    <div class="col-md-4"> 
                            <input type="password" name="password" placeholder="Nuevo Password" class="form-control" required="">
                    </div>    
                </div>  
                <br>
                    <div class="row">
                    <div class="col-md-1" >
                             
                    </div>     
                    <div class="col-md-3">
                             
                    </div>     
                    <div class="col-md-4"> 
                            <input type="password" name="confirm_password" placeholder="Confirmar Password" class="form-control" required="">
                    </div>    
                </div>      
                  <br>
                 
                <div class="row">
                <div class="col-md-4" >
                         
                </div>     
                <div class="col-md-1">
                         
                </div>     
                <div class="col-md-3">
                        <input type="hidden" name="fp_code" value="<?php echo $_REQUEST['fp_code']; ?>"/>
                        <br />
                        <input type="submit" name="resetSubmit" class="btn btn-primary" value="Restablecer" style="background-color:#00965e;color:white;">                    
                </div>    
                </div>       
                        
                        
                    </div>
                 </div>       
           
                <div style="height: 10px;">&nbsp;</div>
                <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-2">
                       <div class="help-block">
                                                 <p align="center"><img class="imagen" src="../assets/img/Cenefa-01.png"  />
                         </p>
                      </div>
                    </div>
                </div>

                
          </fieldset>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>


