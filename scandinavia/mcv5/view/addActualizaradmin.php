<?php
//start session
session_start();
$sesion = $_SESSION["user_id"];
$cedula = $_REQUEST['cedula'];

$identificacion = $_SESSION['identificacion'];
//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//get user data
if(!empty($_GET['id'])){
	include '../clases/DB.class.php';	
	$db = new DB();
	$conditions['where'] = array(
		'u_userid' => $_GET['id'], 
	);
	$conditions['return_type'] = 'single';
	$userData = $db->getRows('system_users', $conditions); //ojo se pone tabla a consultar
	$roles = $db->getRows('vw_modulesmatriz',array('order_by'=>'Module')); 

	$roleData = $db->getRows('role',array('order_by'=>'role_rolecode ')); //ojo se pone tabla a consultar
}
else{ /*cuando hay consultas de dropdown*/
include '../clases/DB.class.php';	
$db = new DB();	
$roleData = $db->getRows('role',array('order_by'=>'role_rolecode ')); //ojo se pone tabla a consultar
$roles = $db->getRows('vw_modulesmatriz',array('order_by'=>'Module'));
$use = $db->getRows('system_users');  
}

$actionLabel = !empty($_GET['id'])?'Editar':'Agregar';

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>

<?php require('../../cabeza.php'); 


if(!isset($_SESSION["session_username"])) {	
  header("location:../../seguridad/index.php");
} 
else {?>


<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
</style>
<script src="https://oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<style type="text/css">
.container{padding: 10px;}
.glyphicon{font-size: 20px;}
.glyphicon-arrow-left{float: right;}
a.glyphicon{text-decoration: none;}
</style>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
 $(document).ready(function() {
                <!--#my-form grabs the form id-->
                tabla();
                $("#formulario-contacto").submit(function(e) {
                    e.preventDefault();
					document.getElementById("userSubmit").disabled = true; 
                    $.ajax( {
                        <!--insert.php calls the PHP file-->
                        url: "adminAction2.php",
                        method: "post",
                        //data: $("form").serialize(),
					    data: new FormData( this ),
					    processData: false,
					    contentType: false,
                        dataType: "text",
                        success: function(strMessage) {
                        mostrar();
                        
                        }
                    });
                });
            });

function insertar()
{
  $('#aprobador').show();
  $('#resultado').show();
  $('#tables').show();
  const datos = {
     modulos:$('#modulos').val(),
     persona:$('#persona').val(),
     id:$('#id').val(),
     sesion:$('#sesion').val(),
     cedulaSesion:$('#cedulaSesion').val()
  }
  $.post('añadirPermiso.php', datos, function (response) {
    $.ajax({
          url:'datos.php',
          type:'GET',
          success:function(response){
            let permisos = JSON.parse(response);
            let templates = '';
            permisos.forEach(permiso =>{
              templates += ` 
              <tr>
                  <td>${permiso.sesion}</td>
                  <td>${permiso.aprobador} </td>
                  <td>${permiso.modulo}</td>
                  <td>${permiso.id}</td>
                  <td>${permiso.cedulaSesion}</td>
                  <td><button class='btn btn-danger'>Eliminar</button></td>
              </tr>
              `
            });
            $('#resultado').html(templates);
          }

      })
  })
}

function mostrar() 
{
  $('#aprobador').show();
  $('#resultado').show();
  $('#tables').show();
  swal ( "success" ,  "Se actualizó la información correctamente" ,  "success");
  
}

function empleado() {
            $("#persona").autocomplete({
                source: "buscar.php",
                minLength: 2,
                select: function(event, ui) {
                    
					event.preventDefault();
					
					$('#id').val(ui.item.id);
					$('#persona').val(ui.item.value);
                    $("#button").focus();
			     }
            });
		};
	

function tabla()
{
    let cedula = $('#cedulaSesion').val();
  $.ajax({
          url:'datos.php',
          type:'GET',
          data:{cedula},
          success:function(response){
            let permisos = JSON.parse(response);
            let templates = '';
            permisos.forEach(permiso =>{
              templates += ` 
              <tr>
                  <td>${permiso.sesion}</td>
                  <td>${permiso.aprobador} </td>
                  <td>${permiso.modulo}</td>
                  <td>${permiso.id}</td>
                  <td>${permiso.cedulaSesion}</td>
                  <td><button class='btn btn-danger'>Eliminar</button></td>
              </tr>
              `
            });
            $('#resultado').html(templates);
          }

      })

}

  
</script>
 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Maestro de Usuarios</h3>
          	<div class="row mt">
          		<div class="col-12">
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
            <div class="panel-heading"><?php echo $actionLabel; ?> Usuarios <a href="../admin.php?op=<?php echo $_REQUEST['op'];?>" class="glyphicon glyphicon-arrow-left"></a></div>
           
                <form id="formulario-contacto">
                  <div class="col-md-6">
                        <label>Usuario</label><input type="text" class="form-control" name="username" placeholder="Usuario"  value="<?php echo !empty($userData['u_username'])?$userData['u_username']:''; ?>" disabled>
                    </div>
                  <div class="col-md-6">
                        <label>Contraseña</label>
                        <input type="text" class="form-control" name="password" placeholder="Password..." required value="<?php echo !empty($userData['u_password'])?$userData['u_password']:''; ?>"disabled>
                    </div>                    
                    
                    
                  <div class="col-md-6">
                        <label>Nombres</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Nombres..." required value="<?php echo !empty($userData['full_name'])?$userData['full_name']:''; ?>"disabled>
                    </div> 
                    
                  <div class="col-md-6">
                        <label>Identificacion</label>
                        <input type="text" class="form-control" name="identificacion" placeholder="Identificacion..." required value="<?php echo !empty($userData['cedula'])?$userData['cedula']:''; ?>"disabled>
                    </div>  



                <div class="col-md-6">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email..." required value="<?php echo !empty($userData['email'])?$userData['email']:''; ?>"disabled>
                    </div>      
                    

                  <div class="col-md-6"> 
                   <label>ROL</label>
                    <select class="form-control form-control-lg" name="rol">
						<?php 
						foreach ($roleData as $row) {							
							    if(!empty($userData['u_rolecode'])){
									if($userData['u_rolecode'] == $row['role_rolecode']){
										echo '<option selected=\"selected\" value="'.$row['role_rolecode'].'">'.$row['role_rolecode'].'</option>';
									}	
									else{
										echo '<option value="'.$row['role_rolecode'].'">'.$row['role_rolecode'].'</option>';
									}
								}
								else{
									echo '<option value="'.$row['role_rolecode'].'">'.$row['role_rolecode'].'</option>';
								}
                        }?>
	    			</select>                                           
                                                         
                    <br>
                    <?php  $varid = 0;
					       if(isset($userData['u_userid'])) { $varid = $userData['u_userid'];;}  ?>
					<input type="hidden" name="id" value="<?php echo $varid; ?>">
                     <input type="hidden" name="op" value="<?php echo $_REQUEST['op'];?>">
                     <input type="hidden" name="cedulaSesion" id="cedulaSesion" value="<?php echo $userData['cedula']?>">

					<br> 
                    </div>
		<div class="col-md-5"></div>
        <div class="col-md-5">
          <br />
          <input type="submit" name="userSubmits" id="userSubmit" class="btn btn-success" value="Actualizar información"/> 
          </div>
            </form>
            
            </div> 
  <div class="col-md-3"></div>
                    <!-- Aqui empieza la asignacion de los permisos -->
                    
                    <div class="aprobador" id="aprobador">
                          <div class="col-md-3">
                          <br>
                              <label>Módulo</label>
                              <select class="form-control form-control-lg" name="modulo" id="modulos">
                              <?php
                              foreach ($roles as $row) 
                              {
                                if(!empty($row['Module']))
                                {
                                  
                                  echo '<option  name="modulos"  value="'.$row['Module'].'">'.$row['Module'].'</option>';
                                }
                              }
                                ?>
                              
                              </select>
                          </div>
                            
                      <div class="col-md-3"> 
                      <br>
                            <label>Aprobador</label>
                            <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="apro" type="text" id="persona" onKeyUp="empleado()">
                            </div>
                        </div>
                        <div class="col-md-3"> 
                      <br>
                            <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="id" type="hidden" id="id">
                            </div>
                        </div>
                        <div class="col-md-3"></div>
              <!-- Aqui termina la asignacion de los permisos -->
                    <div class="col-md-6" id="tables">
                    <br>
                    <input type="button" value="Agregar" class="btn btn-success" id="button" onclick="insertar()"><br>
                    
                    <input type="hidden" name="id" id="sesion" value="<?php echo $userData['u_userid']?>">
                    <input type="hidden" name="cedulaSesion" id="cedulaSesion" value="<?php echo $userData['cedula']?>">
                    <div class="table-responsive table-bordered">  
                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                  <tr>
                  
                  <tr>
                    <td>ID</td>
                    <td>Aprobador</td>
                    <td>Modulo</td>
                    </tr>
                                       
                    
                  </tr>
                  
                  
                </table>
                <div id="resultado">
                    
                    </div>
                      </div>    
                    </div> 		
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

     
  </section>

<?php require_once('../../pie.php'); }?>
		