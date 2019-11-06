<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");


 //TRAEMOS LA SESION
 require '../../../scandinavia/seguridad/config.php';

$user = $_SESSION['user_id'];
 // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

  $comentario = $_GET['comentario'];
  $id = $_GET['id'];
  $precioU =$_GET['precioU'];
  $precioPr = $_GET['precioPr'];
  $codigo = $_GET['codigo'];
  $opcion = $_GET['opcion'];
  $fechaD = $_GET['fechaD'];
  $fechaH = $_GET['fechaH'];
  
  //VALIDAMOS SI EL COMENTARIO VIENE VACIO SI ESE ES EL CASO LO ENVIAMOS  COMO UN NULL 
  
  if (empty($comentario)) 
  {
    
    $ober = null;
  }
  else{
    $ober = $comentario;
  }

  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  $params = json_decode($json);
  $ober = "";
  // REALIZA LA QUERY A LA DB
  $sql="UPDATE `matrizPrecios` SET `precio_aprobado_x_umc`='$precioU',`precio_aprobado_x_presentac`='$precioPr',`comentarios`='$comentario',`opcion` = '$opcion', `tipo` = 'plataforma', vigenciaDesde = '$fechaD', vigenciaHasta='$fechaH' WHERE id = '$id'";
  $res=$con->query($sql);
  
  //AHORA COMPARAMOS SI SE REALIZO LA CONSULTA Y SI ES ASI ENVIAMOS AL HISTORICO DE CAMBIOS
  if($res == TRUE){
      $consulta ="INSERT INTO `historico_precios`(`codigo_axapta_afectado`, `usuario`, `fecha_cambio`) VALUES ('$codigo','$user',NOW())";
      $query =$con->query($consulta);
  }
else{
    
}


  class Result {}
  if ($query === TRUE) {
    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'Registro Exitoso';
} else {
  $response = new Result();
  $response->resultado='error';
    
}

  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>