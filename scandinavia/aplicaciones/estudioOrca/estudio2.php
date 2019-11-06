<?php

$cedulaMedico = $_POST['identificacion'];
$nombreMedico = $_POST['nombre'];
$estudio = $_POST['estudios'];
$codigoPaciente = $_POST['codigo'];


   $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
    mysqli_set_charset($bd,'utf8');

    
        global $bd;
        $sql= "INSERT INTO pacientes (estudio, codigoPaciente, cedulaMedico, nombreMedico, habilitado) VALUES('$estudio', '$codigoPaciente', '$cedulaMedico', '$nombreMedico', 1)";
        $query = mysqli_query($bd, $sql);


header('Location:https://appmegalabs.com/scandinavia/aplicaciones/estudioOrca/listadopacientesasignados.php');





?>