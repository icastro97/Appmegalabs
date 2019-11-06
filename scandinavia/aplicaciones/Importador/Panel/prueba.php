<?php
if(isset($_POST['adjunto']))
{
    
       $archivo = $_FILES['archivo']['tmp_name'];
       
       var_dump($archivo);
   
   
}
?>