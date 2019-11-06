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
 
 move_uploaded_file($file_loc,$folder.$file);
 $sql="INSERT INTO tbl_uploads(file,type,size) VALUES('$file','$file_type','$file_size')";
 mysqli_query($mysqli, $sql);
 
 $sqil="SELECT @@identity AS id";
 $rs = mysqli_query($mysqli, $sqil);
 
 if ($row = mysqli_fetch_row($rs)) {
	$ultimoid = trim($row[0]);
 }
 
 
 
 
 /**/
 date_default_timezone_set("America/Bogota");
 //echo  $folder.$file;
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
    $stmt = $conn->prepare( "INSERT INTO bancos (codigo, descripcion) VALUES (?, ?)");
    $stmt->bindParam( 1, $codigo);
    $stmt->bindParam( 2, $descripcion); 				
	$i= 0;
	
    foreach ($xlsx->rows() as $fields)
    {
		if ($i!=0){
			$codigo = $fields[1];
			$descripcion = $fields[2];									     
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
      Maestro de Bancos<br>
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
