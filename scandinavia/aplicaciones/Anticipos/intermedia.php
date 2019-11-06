<?php
include('tipoAnticipo.php');

$tipo = $_POST['tipo'];


   
  if(isset($_POST['opcion']) )
  {
    if(!empty($tipo))
    {
      if($tipo == "Empleado")
      {
          
        header("location:indexEmpleado.php?tipe=Empleado");

      }
      else if ($tipo == "Proveedor")
      {
          header("location:indexProveedor.php?tipe=Proveedor");
          
      }
    }
    else 
    {
        echo  "<div class='alert alert-danger' role='alert'>Seleccione una opción, por favor!</div>";
        
    }  
  }



?>