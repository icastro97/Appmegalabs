<?php
//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
?>

<?php require('../../cabeza.php'); 

if(!isset($_SESSION["session_username"])) {	
  header("location:../logininicial.php");  
} 
else {?>



<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}

.embed-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}
.embed-container iframe {
    position: absolute;
    top:0;
    left: 0;
    width: 100%;
    height: 100%;
}

</style>

<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>

<style type="text/css">
.container{padding: 10px;}
.glyphicon{font-size: 20px;}
.glyphicon-arrow-left{float: right;}
a.glyphicon{text-decoration: none;}
</style>
          <a href="http://appscandinavia.com/scandinavia/default1.php?group=Parametros" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
<form action="importarfichero.php" method="post" enctype="multipart/form-data">
            <input type="file" name="archivo" id="archivo"></input>
            <input type="submit" value="Subir archivo" name="btn-upload"></input>
        </form>

<?php require_once('../../pie.php'); }?>
		