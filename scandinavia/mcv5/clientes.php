<?php

/* capturar variable por método GET */
if (isset($_GET['pos']))
  $ini=$_GET['pos'];
else
  $ini=1; 

require_once("../seguridad/config.php");
require_once 'clases/paginador.php';

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


//paginacin
$limit_end = 100;
$init = ($ini-1) * $limit_end;
if(!isset($_SESSION['uri'])){
	$_SESSION['uri'] = $_SERVER["REQUEST_URI"];
}
$url = $_SESSION['uri'];
//



//get users from database
$users = $db->getRows('x2_contacts',array('order_by'=>'name ', 'start'=>$init, 'limit'=>$limit_end)); //ojo se pone tabla a consultar


//paginacion
$conditions['return_type'] = 'count';
$totales = $db->getRows('x2_contacts', $conditions); //ojo se pone tabla a consultar
$total = ceil($totales/$limit_end);




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
else {

	
	?>

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
                   <a href="http://appscandinavia.com/scandinavia/default1.php?group=Parametros" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Maestro de Clientes</h3>
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
            <div class="panel-heading">Clientes   <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"])) { ?> <a href="view/addEdit.php?op=<?php echo $_REQUEST['op']?>" class="glyphicon glyphicon-plus" ></a><?php }?></div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <?php if(!empty($users)): $count = 0; foreach($users as $user): $count++; ?>
                    <tr>
                        <td><?php echo '#'.$count; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td>
                           <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["edit"])){?> <a href="view/addEdit.php?id=<?php echo $user['id']; ?>&op=<?php echo $_REQUEST['op'];?>&pos=<?php echo $_REQUEST['pos'];?> " class="glyphicon glyphicon-edit"></a> <?php }?>
                           <?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["delete"])){?> <a href="view/userAction.php?action_type=delete&id=<?php echo $user['id']; ?>&op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-trash" onclick="return confirm('Are you sure to delete?')"></a> <?php }?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5">No existen clientes para mostrar......</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>



<?php
 /* numeración de registros [importante]*/
  echo "<br><div align='center' >" ;
  echo "<ul>";
  /****************************************/
  if(($ini - 1) == 0)
  {
    echo "<a href='#'>&laquo;</a>";
  }
  else
  {
    echo "<a href='$url&pos=".($ini-1)."'><b>&laquo;</b></a>";
  }
  /****************************************/
  for($k=1; $k <= $total; $k++)
  {
    if($ini == $k)
    {
      echo "<a href='#'><b>".$k."</b></a>&nbsp;&nbsp;";
    }
    else
    { 
	  if($k<=30)
      echo "<a href='$url&pos=$k'>".$k."</a>&nbsp;&nbsp;";
    }
  }
  /****************************************/
  if($ini == $total)
  {
    echo "<a href='#'>&raquo;</a>";
  }
  else
  {
    echo "<a href='$url&pos=".($ini+1)."'><b>&raquo;</b></a>";
  }
  /*******************END*******************/
  echo "</ul>";
  echo "</div>";

?>


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