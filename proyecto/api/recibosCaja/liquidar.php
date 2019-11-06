<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
require("../precios/database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  //TRAEMOS LA SESION
require '../../../scandinavia/seguridad/config.php';

  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR

  //$user = $_SESSION['user_id'];
  $doc = $_GET['doc'];
  $productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
 //   var_dump($productosArray);
 $i = 0;
  foreach ($productosArray as $row) {
      $sql="UPDATE `rd_detalle` SET `RetImpositiva`='$row[RetImpositiva]',`DesPPago`='$row[DesPPago]',`DesAdicional`='$row[DesAdicional]',`OtrosDescuentos`='$row[OtrosDescuentos]',`ValNota`='$row[ValNota]',`ValNeto`=$row[ValNeto] WHERE Documento = '$row[Documento]' AND DocumentID = '$doc'";
      $query = mysqli_query($con, $sql);
      //var_dump($sql);
  }
  if($query == TRUE){
      echo "Bien";
  }
  else{
      echo mysqli_error($con);
  }
  
 ?>