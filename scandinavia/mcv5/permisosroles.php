<?php

require_once("../seguridad/config.php");

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
$users = $db->getRows('role_rights',array('order_by'=>'id DESC')); //ojo se pone tabla a consultar

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>


<?php require_once('../cabeza.php'); 


if(!isset($_SESSION["session_username"])) {	
  header("location:../seguridad/index.php");  
} 
else {?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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
           <a href="https://appmegalabs.com/scandinavia/default1.php?group=Administracion" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Maestro de Permisos Roles</h3>
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
    <div class="col-12">
      <div class="table-responsive">
        <div class="panel panel-default users-content">  
            <div class="panel-heading">Permisos Roles  <a href="view/addEditpermisosroles.php?op=<?php echo $_REQUEST['op']?>" class="glyphicon glyphicon-plus" ></a></div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Codigo ROL</th>
                        <th>Codigo Modulo</th>
                        <th>Permiso Crear</th>
                        <th>Permiso Editar</th>
                        <th>Permiso Eliminar</th>
                        <th>Permiso Ver</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <?php if(!empty($users)): $count = 0; foreach($users as $user): $count++; ?>
                    <tr>
                        <td><?php echo '#'.$count; ?></td>
                        <td><?php echo $user['rr_rolecode']; ?></td>
                        <td><?php echo $user['rr_modulecode']; ?></td>
                        <td><?php echo $user['rr_create']; ?></td>                          
                        <td><?php echo $user['rr_edit']; ?></td>  
                        <td><?php echo $user['rr_delete']; ?></td>  
                        <td><?php echo $user['rr_view']; ?></td>                                              
                        
                        <td>
                       <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["edit"])) { ?>
                            <a href="view/addEditpermisosroles.php?id=<?php echo $user['id']; ?>&op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-edit"></a>
                        <?php } ?>
                          <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["delete"])) { ?>
                            <a href="view/permisosrolesAction.php?action_type=delete&id=<?php echo $user['id']; ?>&op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-trash" onclick="return confirm('Are you sure to delete?')"></a><?php } ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5">Asignacion de permisos No encontrados......</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
            </div>
    </div>
</div>                  
                  
                  
                </section>
                <p>&nbsp;</p>
          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

     
  </section>

<?php require_once('../pie.php'); }?>