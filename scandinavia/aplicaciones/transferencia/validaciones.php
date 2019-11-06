<?php
require_once '../../mcv5/clases/DB.class.php';


$nit = $_POST['nit'];
$factura = $_POST['factura'];



	$consulta="SELECT id_transferencia from transferencia_val where nit = '$nit' and factura = '$factura'";	 
	
	//var_dump($consulta);
    $sql = mysqli_query($mysqli, $consulta); 
    $num = mysqli_num_rows($sql);
     
    if($num > 0)
    {
        echo json_encode($num);
    }
    
 

?> 