<?php
$title = "Actualizar Contrase&ntilde;a";
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
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<title>. :: Restablecer la contrase&ntilde;a de su cuenta :: .</title>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal"  action="userAccount.php" method="post">
            <div align="center">
              <p>
                <input type="hidden" name="mode" value="login" >
               <img src="../assets/img/icono.png" width="100" height="100"><br>
                <img src="../assets/img/Logotipo.png" width="250"></p></p>
             
            </div>
            <fieldset>
                
             <br /><br />   
            <div class="form-group">
           <div class="row">
               <div class="col-md-1">
                   
               </div> 
               <div class="col-md-3">
                   
               </div> 
               <div class="col-md-4">
                     <h4>Actualizar la contrase&ntilde;a de su cuenta</h4>
                      <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?> 
               </div>      
            </div>  
            <br>
                    <div class="row">
                            
                    <div class="col-md-1">
                    
                    </div>
                    <div class="col-md-3">
                    
                    </div>    
                    <div class="col-md-3">
                    <input type="password" name="passwordold" placeholder="Password Anterior" class=" form-control" required="">
                    </div>
                    </div>
                <br>
                <div class="row">
                <div class="col-md-1">
                        
                </div>     
                <div class="col-md-3">
                        
                </div>     
                <div class="col-md-4">
                        <input type="password" name="password" placeholder="Nuevo Password" class=" form-control" required="">
                </div>    
                </div>
                 <br>
                <div class="row">
                <div class="col-md-1">
                        
                </div>     
                <div class="col-md-3">
                        
                </div>     
                <div class="col-md-4">
                        <input type="password" name="confirm_password" placeholder="Confirmar Password" class=" form-control" required="">                       
                </div>    
                </div>   
                   <br>
                <div class="row">
                <div class="col-md-4" >
                         
                </div>     
                <div class="col-md-1">
                         
                </div>     
                <div class="col-md-3">
                        <input type="hidden" name="userid" value="<?php echo $_SESSION['id']; ?>"/>
                        <br />
                        <input type="submit" name="updateSubmit" class="btn" value="Actualizar" style="background-color:#00965e;color:white;">                       
                </div>    
                </div>       
                        
                        
                    </div>
                 </div>       
                
           
                <div style="height: 10px;">&nbsp;</div>
                <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-2">
                       <div class="help-block">
                         <p align="center"><img class="imagen"src="../assets/img/Cenefa-01.png"  />
                         </p>
                      </div>
                    </div>
                </div>

                
          </fieldset>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>


