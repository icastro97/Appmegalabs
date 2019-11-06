<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';


//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from database
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar


$bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar

 $conditions['where'] = array('Documento'=> $sid,); 
$users = $db->getRows('vw_basec_vendedores',$conditions); //ojo se pone tabla a consultar




//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>


<?php require_once('../../cabeza.php'); 


if(!isset($_SESSION["session_username"])) {	
  header("location:../../logininicial.php");
} 
else {?>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="../../bower_components/dropzone/downloads/css/dropzone.css"> 
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>


 <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
	<script type="text/javascript" src="../../bower_components/dropzone/downloads/dropzone.min.js"></script>

	<script type="text/javascript">
	
	 var guid = "";
		function S4() {
			return (((1+Math.random())*0x10000)|0).toString(16).substring(1); 
		}
		 
		// then to call it, plus stitch in '4' in the third group
		guid = (S4() + S4() + "-" + S4() + "-4" + S4().substr(0,3) + "-" + S4() + "-" + S4() + S4() + S4()).toLowerCase();
	
	
	$(document).ready(function()
	{
		Dropzone.autoDiscover = false;
		$("#dropzone").dropzone({
			url: "uploads.php?inf="+guid+"&legalizacion="+document.getElementById("legalizacion").value,
			addRemoveLinks: true,
			maxFileSize: 100000,
			dictResponseError: "Ha ocurrido un error en el server",
			acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF,.rar,application/pdf,.psd',
			complete: function(file)
			{
				if(file.status == "success")
				{
					alert("El siguiente archivo ha subido correctamente: " + file.name);
				}
			},
			error: function(file)
			{
				alert("Error subiendo el archivo " + file.name);
			},
			removedfile: function(file, serverFileName)
			{
				var name = file.name;
				$.ajax({
					type: "POST",
					url: "uploads.php?delete=true",
					data: "filename="+name,
					success: function(data)
					{
						var json = JSON.parse(data);
						if(json.res == true)
						{
							var element;
							(element = file.previewElement) != null ? 
							element.parentNode.removeChild(file.previewElement) : 
							false;
							alert("El elemento fué eliminado: " + name); 
						}
					}
				});
			}
		});
	});
	</script>


<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">          
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
          		<section id="unseen">

                  
<div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<p>
	  <?php } ?>
	</p> <form name="form1" method="post" action="">
	  <div >
	  <div class="panel panel-default users-content">
            <div class="panel-body"> <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"])) { ?> <a href="view/addEdit.php?op=<?php echo $_REQUEST['op']?>" class="glyphicon glyphicon-plus" ></a><?php }?>
              <input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
              <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /> 
              <input name="legalizacion" type="hidden" id="legalizacion" value="<?php echo $_REQUEST['id']; ?>">
            </div>
            <p>&nbsp;</p>
            <div id="dropzone" class="dropzone"></div>
            <p>&nbsp;</p>
            <p>
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>">
            </p>
            
            </form>           
        </div>
</div>
</div>                  
                  
                  
                </section>
                <p>&nbsp;</p>
      </section><! --/wrapper --><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2018 - HBT
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->


<?php require_once('../../pie.php'); }?>


		
				
