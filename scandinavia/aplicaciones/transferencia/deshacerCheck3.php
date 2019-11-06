<?php
require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['id_factura'];


$consulta = "UPDATE transferencia_val SET inv_comercial = 'false' WHERE id_transferencia = ".$id;
$ejecucion = mysqli_query($mysqli, $consulta);

if($ejecucion == true)
{
    echo true;

}
else
{
     
    var_dump(mysqli_error($mysqli));
}


 
?>

