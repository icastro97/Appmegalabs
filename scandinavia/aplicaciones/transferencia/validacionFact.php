<?php

require_once '../../mcv5/clases/DB.class.php';

$factura = $_POST['numeroFactura'];
$nit = $_POST['nit'];
$tipo = $_POST['opciones'];
$radicado = $_POST['radicado'];



    $consulta="SELECT factura, establecimiento FROM transferencia_val WHERE factura = '$factura' and nit = '$nit'";
     $sql = mysqli_query($mysqli, $consulta);
    
     $numeroConsulta = mysqli_num_rows($sql);
     
     
    if($numeroConsulta > 0)
    {
        echo true;
    }
    else
    {
        echo false;
    }   

 

?> 