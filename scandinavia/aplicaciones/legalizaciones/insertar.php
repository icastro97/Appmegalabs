
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

$lgcabeza = $_POST['lgcabeza'];
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
$cantidad = $_POST['cantidad'];
$sextocheck = $_POST['sextocheck'];
$panel2 = $_POST['panel2'];
$panel10 = $_POST['panel10'];

if($primercheck == "panel" && !empty($cedulapanel))
{

    $sql = "UPDATE lg_det_cabeza SET asistencia = '1' where identificador =".$ide;
    $resultado = mysqli_query($mysqli, $sql);

    $nombrepanel = sanear_string($panel);
    
    $consulta = "INSERT INTO asistencia (tipo, nombreAsistente, cedulaAsistente, identificadorlg, identificadordet) VALUES ('$primercheck','$nombrepanel', '$cedulapanel', '$lgcabeza','$ide')";
    //var_dump($consulta);
    $result = mysqli_query($mysqli, $consulta);
    echo "Insertado";

}
else;

if ($segundocheck == "nopanel")
{

    
    $sql = "UPDATE lg_det_cabeza SET asistencia = '1' where identificador =".$ide;
    $resultado = mysqli_query($mysqli, $sql);


    $nombrenopanel = sanear_string($nopanel);

    $consulta2 = "INSERT INTO asistencia ( tipo, nombreAsistente, cedulaAsistente,identificadorlg, identificadordet) VALUES ('$segundocheck','$nombrenopanel', '$nopanelcedula', '$lgcabeza','$ide')";
    $result2 = mysqli_query($mysqli, $consulta2);
    echo "Insertado";
}
else;

if($tercercheck == "empleado" && !empty($cedulaempleado))
{

    
    $sql = "UPDATE lg_det_cabeza SET asistencia = '1' where identificador =".$ide;
    $resultado = mysqli_query($mysqli, $sql);

    $nombreemple = sanear_string($empleado);
    
    $consulta2 = "INSERT INTO asistencia ( tipo, nombreAsistente, cedulaAsistente, identificadorlg, identificadordet) VALUES ('$tercercheck','$nombreemple', '$cedulaempleado', '$lgcabeza','$ide')";
    $result2 = mysqli_query($mysqli, $consulta2);
    
    echo "Insertado";
}
else;
  
if($quintocheck == "Farmacia" && $cantidad != "")
{

    $sql = "UPDATE lg_det_cabeza SET asistencia = '1' where identificador =".$ide;
    $resultado = mysqli_query($mysqli, $sql);


    $consulta2 = "INSERT INTO asistencia ( tipo, cantidad,nombreAsistente, identificadorlg, identificadordet) VALUES ('$quintocheck','$cantidad', 'Farmacias', '$lgcabeza','$ide')";
    $result2 = mysqli_query($mysqli, $consulta2);
    echo "Insertado";
}
else;


if($sextocheck == "PanelM" && !empty($panel2))
{

    $sql = "UPDATE lg_det_cabeza SET asistencia = '1' where identificador =".$ide;
    $resultado = mysqli_query($mysqli, $sql);

    $panelMegalabs = sanear_string($panel10);

    $consulta2 = "INSERT INTO asistencia ( tipo, nombreAsistente,cedulaAsistente, identificadorlg, identificadordet) VALUES ('$sextocheck','$panelMegalabs','$panel2', '$lgcabeza','$ide')";
    
    $result2 = mysqli_query($mysqli, $consulta2);
    
    echo "Insertado";
}
else;

?>
