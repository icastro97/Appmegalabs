<?php
function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
   
 
 
    return $string;
}


?>

<?php 

require_once '../../mcv5/clases/DB.class.php';

$ide = $_POST['id'];
$panel = $_POST['panel'];
$cedulapanel = $_POST['cedulapanel'];
$nopanel = $_POST['nopanel'];
$nopanelcedula = $_POST['nopanelcedula'];
$empleado = $_POST['empleado'];
$cedulaempleado = $_POST['cedulaempleado'];
$primercheck = $_POST['primercheck'];
$segundocheck = $_POST['segundocheck'];
$tercercheck = $_POST['tercercheck'];
$quintocheck = $_POST['quintocheck'];
$sextocheck = $_POST['sextocheck'];
$panel2 = $_POST['panel2'];
$cantidad = $_POST['cantidad'];
$panel10 = $_POST['panel10'];
$valor = $_POST['val'];
$valor1 = $_POST['val1'];
$valor2 = $_POST['val2'];
$valor3 = $_POST['val3'];

$val = intval($valor);
$val1 = intval($valor1);
$val2 = intval($valor2);
$val3 = intval($valor3);


if($primercheck == "panel" && !empty($cedulapanel) && !empty($val))
{

    $sql = "UPDATE transferencia_val SET asistencia = '1' where id_transferencia =".$ide;
    $resultado = mysqli_query($mysqli, $sql);

    $consulta = "INSERT INTO asistencia_trans_valor (tipo, nombreAsistente, cedulaAsistente, identificadordet, valor) VALUES ('$primercheck','$panel', '$cedulapanel','$ide', '$val')";    
    
    $result = mysqli_query($mysqli, $consulta);
    
    echo "Insertado";

}
else;

if ($segundocheck == "nopanel" && !empty($val2))
{

    
    $sql = "UPDATE transferencia_val SET asistencia = '1' where id_transferencia =".$ide;
    $resultado = mysqli_query($mysqli, $sql);

    $consulta2 = "INSERT INTO `asistencia_trans_valor`(`tipo`,`cantidad`, `nombreAsistente`, `cedulaAsistente`, `identificadordet`, valor)  VALUES ('$segundocheck',1,'$nopanel', '$nopanelcedula','$ide', '$val2')";
    $result2 = mysqli_query($mysqli, $consulta2);
    echo "Insertado";
}
else;

if($tercercheck == "empleado" && !empty($cedulaempleado) && !empty($val3))
{

    $sql = "UPDATE transferencia_val SET asistencia = '1' where id_transferencia =".$ide;
    $resultado = mysqli_query($mysqli, $sql);

    $consulta2 = "INSERT INTO asistencia_trans_valor (tipo,`cantidad`, nombreAsistente, cedulaAsistente, identificadordet, valor) VALUES ('$tercercheck',1,'$empleado', '$cedulaempleado','$ide', '$val3')";
    $result2 = mysqli_query($mysqli, $consulta2);
    echo "Insertado";
}
else;
  
if($quintocheck == "Farmacia" && $cantidad != "")
{

    $sql = "UPDATE transferencia_val SET asistencia = '1' where id_transferencia =".$ide;
    $resultado = mysqli_query($mysqli, $sql);

    $consulta2 = "INSERT INTO asistencia_trans_valor (tipo, cantidad, nombreAsistente, identificadordet)VALUES ('$quintocheck','$cantidad', 'Farmacias','$ide')";
    $result2 = mysqli_query($mysqli, $consulta2);
    echo "Insertado";
}
else;

if($sextocheck == "PanelM" && !empty($panel2) && !empty($val1))
{

    $sql = "UPDATE transferencia_val SET asistencia = '1' where id_transferencia =".$ide;
    $resultado = mysqli_query($mysqli, $sql);

    $panelMegalabs = sanear_string($panel10);

    $consulta3 = "INSERT INTO asistencia_trans_valor (tipo, nombreAsistente, cedulaAsistente, identificadordet, valor) VALUES ('$sextocheck','$panelMegalabs','$panel2', '$ide', '$val1')";
    $resultados = mysqli_query($mysqli, $consulta3);
    
    echo "Insertado";
}
else;


?>