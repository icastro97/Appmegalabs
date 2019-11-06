<?php
require_once '../../mcv5/clases/DB.class.php'; 
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if(isset($_GET["delete"]) && $_GET["delete"] == true)
	{
		$name = $_POST["filename"];
		if(file_exists('./uploads/'.$name))
		{
			unlink('./uploads/'.$name);
			$sql = "DELETE FROM uploadslg WHERE name = '$name'";
			
			mysqli_query($mysqli, $sql);				
			echo json_encode(array("res" => true));
		}
		else
		{
			echo json_encode(array("res" => false));
		}
	}
	else
	{
		$file = $_FILES["file"]["name"];
		$filetype = $_FILES["file"]["type"];
		$filesize = $_FILES["file"]["size"];
        $guid  = $_REQUEST['inf'];
		$coti = $_REQUEST['legalizacion'];
		if(!is_dir("uploads/"))
			mkdir("uploads/", 0777);

		if($file && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/".$file))
		{
           $sql ="INSERT INTO uploadslg VALUES(null, '$file','$filetype','$filesize', '$guid', $coti)";
		   mysqli_query($mysqli, $sql);
		}
	}
}