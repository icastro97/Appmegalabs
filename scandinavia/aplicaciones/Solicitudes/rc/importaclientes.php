<?php

include '../../mcv5/clases/DB.class.php';
require('../../cabeza.php'); 
if(isset($_POST['btn-upload']))
{    
     
 $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="uploads/";
 $date = date("Y-m-d H:i:s");
 $usuario = $_SESSION["user_id"];
 $tipoupload = "Base Clientes";
 
 move_uploaded_file($file_loc,$folder.$file);
 $sql="INSERT INTO tbl_uploads(file,type,size,date, user, tipo) VALUES('$file','$file_type','$file_size', '$date', '$usuario', '$tipoupload')";
 mysqli_query($mysqli, $sql);
 
  
 $sqil="SELECT @@identity AS id";
 $rs = mysqli_query($mysqli, $sqil);
 
 if ($row = mysqli_fetch_row($rs)) {
	$ultimoid = trim($row[0]);
 }
 
 
 $sqltruncate="truncate table clientes";
 mysqli_query($mysqli, $sqltruncate);
 
 /**/
 date_default_timezone_set("America/Bogota");
 $db_host="localhost";
	$db_name="scandapp_app";
	$db_user="scandapp_app";
	$db_pass="Qwerty1234$";
    include '../../mcv5/clases/simplexlsx.class.php';	
	
    $xlsx = new SimpleXLSX(  $folder.$file );
    try {
       $conn = new PDO( "mysql:host=$db_host;dbname=$db_name", "$db_user", "$db_pass");
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $stmt = $conn->prepare( "INSERT INTO clientes (NIT, cuentacliente, razonsocial, grupoventas, condicionpago, zona, region) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindParam( 1, $Nit);
    $stmt->bindParam( 2, $cuentacliente);
    $stmt->bindParam( 3, $razonsocial);
    $stmt->bindParam( 4, $grupoventas);
    $stmt->bindParam( 5, $condicionpago);
    $stmt->bindParam( 6, $zona);
    $stmt->bindParam( 7, $region);				
	$i= 0;
	
    foreach ($xlsx->rows() as $fields)
    {
		if ($i!=0){
			$Nit = $fields[7];
			$cuentacliente = $fields[0];
			$razonsocial = $fields[1];
			$grupoventas = $fields[3]; 
			$condicionpago = $fields[4];
			$zona = $fields[5];
			$region = $fields[6];			
			$stmt->execute();
		}
		$i++;
    }
 /**/ 
}
?>
 <div class="panel-heading"> Upload de Fichero </div>
<form action="" method="post" enctype="multipart/form-data">

<table width="50%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td colspan="4" align="center"><br>
      Maestro de Clientes<br>
      <br></td>
    </tr>
  <tr>
    <td width="1%" align="right">&nbsp;</td>
    <td colspan="2" align="right"><input type="file" name="file" /></td>
    <td width="33%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td width="33%" align="right">&nbsp;</td>
    <td width="33%" align="center"><br>      <button type="submit" name="btn-upload" class="btn btn-success">Enviar</button></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>

<?php require_once('../../pie.php'); ?>
