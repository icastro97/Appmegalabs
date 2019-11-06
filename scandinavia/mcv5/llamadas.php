<?php

require_once("../seguridad/config.php");
$parametro = $_REQUEST['filtro'];
$filtrousuario = $_SESSION['id'];
$status = FALSE;


require_once("../seguridad/arraypermiso.php");

if ( authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["edit"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["view"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["delete"]) ) {
 $status = TRUE;
}

       
if ($status === FALSE) {
die("You dont have the permission to access this page");
}

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//load and initialize database class
require_once 'clases/DB.class.php';
$db = new DB();

//get users from database
 $conditions['where'] = array('tipomensaje' => $parametro,'iduseroutput'=> $filtrousuario,'idcliente'=> 0,);
$users = $db->getRows('vw_llamadas',$conditions); //ojo se pone tabla a consultar

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}


?>


<?php require_once('../cabeza.php'); 


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
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Maestro de <?php if ($_REQUEST['filtro'] == '1'){ echo 'Llamadas';} if ($_REQUEST['filtro'] == '2'){ echo 'Notas';} ?></h3>
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
          		<section id="unseen">

                  
<div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<?php } ?>
    <div class="row">
        <div class="panel panel-default users-content">
            <div class="panel-heading"><?php if ($_REQUEST['filtro'] == '1'){ echo 'Llamadas';} if ($_REQUEST['filtro'] == '2'){ echo 'Notas';} ?>  <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"])) { ?> <a href="view/addEditllamadas.php?filtro=<?php echo $_REQUEST['filtro']?>&op=<?php echo $_REQUEST['op']?>" class="glyphicon glyphicon-plus" ></a><?php }?></div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>De</th>
                        <th>Para</th>
                        <th>Subject</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <?php if(!empty($users)): $count = 0; foreach($users as $user): $count++; ?>
                    <tr>
                        <td><?php echo '#'.$count; ?></td>
                        <td><?php echo $user['de']; ?></td>
                        <td><?php echo $user['useroutput']; ?></td>
                        <td><?php echo $user['subject']; ?></td>
                        <td><?php if($user['state'] == 0) { echo "No Leida"; }else { echo "Leida"; }?></td>
                        <td>
                         <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["edit"])) { ?>						 
						   <a href="view/addEditllamadas.php?id=<?php echo $user['id']; ?>&filtro=<?php echo $_REQUEST['filtro'];?>&op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-edit"></a>
                           <?php }       ?>
                            <?php  if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["delete"])) {  ?>
                            <a href="view/llamadasAction.php?action_type=delete&id=<?php echo $user['id']; ?>&filtro=<?php echo $_REQUEST['filtro'];?>&op=<?php  echo $_REQUEST['op'];?>" class="glyphicon glyphicon-trash" onclick="return confirm('Are you sure to delete?')"></a>
                             <?php } ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5">No Llamadas(s) found......</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>                  
                  
                  
                </section>
                <p>&nbsp;</p>
          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

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
  </section>

<?php require_once('../pie.php'); }?>
