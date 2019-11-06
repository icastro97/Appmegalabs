<?php
    
    
    require('conexion.php');
    
    $respuesta = $_REQUEST['variable'];
    
    if($respuesta == 1)
    {
        $sql="UPDATE controles SET estados = 0"; 
        if(mysqli_query($bd,$sql)) 
        {echo json_encode("Se envio");}
    }
    else if($respuesta == 2)
    {
        parse_str(file_get_contents("php://input"), $res); 
        $restablecimiento = $res['proximoRestablecimiento'];
        $sql="UPDATE controles SET estados = 1, fechaRestablecimiento ='{$restablecimiento}'"; 
        if(mysqli_query($bd,$sql)) 
        {echo  json_encode("Fecha actualizada");} 
    }
    else
    {
        $sql="SELECT * FROM controles";
        $resultado= mysqli_query($bd, $sql);
        while($datos = mysqli_fetch_array($resultado))
        { 
            echo json_encode($datos); 
        }
    }
?> 