<?php

require_once("../../seguridad/config.php");
$status = FALSE;

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php'; 


if (isset($_SESSION['uId'])) {
	//existe
	$crea = "no";
	$consecutivo = $_POST['docupdate'];
	} // Checks if session exists 
else {
	//no existe
	$crea = "no";
	$consecutivo = $_POST['docupdate'];
	} 


    $tipos = $_POST['tp'];
    $fechaActual = $_POST['fechaActual'];
    $identificacion = $_POST['identificacion'];
    $nombreEmpleado = $_POST['nombre'];
    $moneda = $_POST['Moneda'];
    $valor = $_POST['valor'];
    $efectivo = $_POST['efectivo'];
    $transferencia = $_POST['transferencia'];
    $cheque = $_POST['cheque'];
    $inversioncom = $_POST['inversioncom'];
    $otros = $_POST['otros'];
    $evento = $_POST['evento'];
    $cinversion = $_POST['cinversion'];
    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];
    $descripcion = $_POST['descripcion'];
    $userid = $_POST['useridl'];
    $namel = $_POST['username'];
    $fechadesembolso = $_POST['fechadesembolso'];
    
    $check = $_POST['cambioaprobador'];
    if($crea == "ok"){
            
            
            $consulta = "SELECT consecutivo FROM anticipo ORDER BY consecutivo DESC LIMIT 1";  
            $var = mysqli_query($mysqli, $consulta); 
            $resultado = mysqli_num_rows($var);
            
            if($resultado > 0)
            {
                while($row = mysqli_fetch_array($var))
                {
                    $consecutivo = $row['consecutivo'] + 1;
                }
                
            }
            else 
                $consecutivo = 1; 
            
            
            
                                   
    }		
if(empty($check))
 {
    
            for ($i = 0; $i < count($fechaActual); $i++) 
            {	
                $nombreaprobador = $_POST['nombreaprobador'];
                 
                $valor[$i] = str_replace(",","",$valor[$i]);	
                                
                $query_Cabeza = "INSERT INTO anticipo (`consecutivo`, `tipo`, `fechaActual`, `identificacion`, `nombre`, `moneda`, `monto`, `efectivo`, `transferencia`, `cheque`, `inversioncom`, `otros`, fechadesembolso, `evento`, `cinversion`, `fechaini`, `fechafin`, `descripcion`, `userid`, `nombreUsuario`, `estado`, `archivo`, `tipoArchivo`,aprobador) VALUES ($consecutivo, '$tipos','$fechaActual','$identificacion', '$nombreEmpleado','$moneda[$i]', '$valor[$i]', '$efectivo', '$transferencia', '$cheque', '$inversioncom', '$otros', '$fechadesembolso','$evento', '$cinversion', '$fechaini','$fechafin','$descripcion', '$userid','$namel', '0', '$nombre', '$tipo', '$nombreaprobador')";
                mysqli_query($mysqli, $query_Cabeza); 
                     //var_dump($query_Cabeza);
                     
                          //echo "<BR>". $sql; 
                          
                    //Grabamos los datos en la tabla personal
                    
                    
                        //se verifica ciudad
                        $sqlc = "select * from ciudades where nombre = '$ciudad[$i]'";
                        $result  = mysqli_query($mysqli, $sqlc);
                        $rowcount = mysqli_num_rows($result);
                        if ($rowcount<1){
                            $sqlc = "INSERT INTO ciudades(nombre) values ('$ciudad[$i]')";
                            mysqli_query($mysqli, $sqlc);
                        } 
            }		
                    
    
    
                
    
            
                                       
            
    
    
    
    /*$sql = "Delete from anticipo where consecutivo = $consecutivo and fechaActual = '' and identificacion = '' and nombre = ''";
    mysqli_query($mysqli, $sql);
    $sql = "Delete from ciudades where nombre = ''";
    mysqli_query($mysqli, $sql);
    $sql = "Delete from bancos where descripcion = ''";
    mysqli_query($mysqli, $sql);*/ 
    
    
    $_SESSION['uId'] = $consecutivo;
    
    
    echo $consecutivo;
    
    
        }
      else {
        for ($i = 0; $i < count($fechaActual); $i++) 
        {	
            $aprobador = $_POST['codigoAprobador'];
             
            $valor[$i] = str_replace(",","",$valor[$i]);	
                            
            $query_Cabeza = "INSERT INTO anticipo (`consecutivo`, `tipo`, `fechaActual`, `identificacion`, `nombre`, `moneda`, `monto`, `efectivo`, `transferencia`, `cheque`, `inversioncom`, `otros`, fechadesembolso, `evento`, `cinversion`, `fechaini`, `fechafin`, `descripcion`, `userid`, `nombreUsuario`, `estado`, `archivo`, `tipoArchivo`, aprobador) VALUES ($consecutivo, '$tipos','$fechaActual','$identificacion', '$nombreEmpleado','$moneda[$i]', '$valor[$i]', '$efectivo', '$transferencia', '$cheque', '$inversioncom', '$otros', '$fechadesembolso','$evento', '$cinversion', '$fechaini','$fechafin','$descripcion', '$userid','$namel', '0', '$nombre', '$tipo','$aprobador' )";
            mysqli_query($mysqli, $query_Cabeza); 
                 //var_dump($query_Cabeza);
                 
                      //echo "<BR>". $sql; 
                      
                //Grabamos los datos en la tabla personal
                
                
                    //se verifica ciudad
                    $sqlc = "select * from ciudades where nombre = '$ciudad[$i]'";
                    $result  = mysqli_query($mysqli, $sqlc);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount<1){
                        $sqlc = "INSERT INTO ciudades(nombre) values ('$ciudad[$i]')";
                        mysqli_query($mysqli, $sqlc);
                    } 
        }		
                


            

        
                                   
        



/*$sql = "Delete from anticipo where consecutivo = $consecutivo and fechaActual = '' and identificacion = '' and nombre = ''";
mysqli_query($mysqli, $sql);
$sql = "Delete from ciudades where nombre = ''";
mysqli_query($mysqli, $sql);
$sql = "Delete from bancos where descripcion = ''";
mysqli_query($mysqli, $sql);*/ 


$_SESSION['uId'] = $consecutivo;


echo $consecutivo;
      }  
    ?>
    
    
    