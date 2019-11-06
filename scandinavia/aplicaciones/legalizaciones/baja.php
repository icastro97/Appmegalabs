<?php

require_once '../../mcv5/clases/DB.class.php';
$id_cabeza = $_REQUEST['dato'];


$sql = "update lg_cabeza set estado = 'BAJA', fechaFinalizada = NOW() where id_cabeza =  " . $id_cabeza;
$resultado = mysqli_query($mysqli, $sql);

if($resultado)
{
    
    
    echo "true";
}
else
{
    echo "false";
   
}

?>