<?php

//require_once("../seguridad/config.php");
$parametro = $_REQUEST['filtro'];
$filtrousuario = $_SESSION['id'];
$status = FALSE;

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//load and initialize database class
require_once 'clases/DB.class.php';
$db = new DB();
//get users from database
 $conditions['where'] = array('assignedTo'=> $filtrousuario,'visibility'=> 7,);
 $conditions['limit'] = '10';
$users = $db->getRows('x2_contacts',$conditions); //ojo se pone tabla a consultar

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

?>
                                  
                 <?php if(!empty($users)): $count = 0; ?>
			  		<div class="col-lg-12">
                      <div class="content-panel">
                      <h4><i class="fa fa-angle-right"></i> Posibles Clientes <a href="/cotizador/mcv5/clientescrm.php?tipo=7&op=<?php echo $_REQUEST['op']?>" title="Ver Todo" class="glyphicon glyphicon-play" ></a></h4> 
                          <section id="unseen">
                            <table class="table table-bordered table-striped table-condensed">
                              <thead>
                              <tr>
                                  <th>Compañia</th>
                                  <th class="numeric">Email</th>
                                  <th class="numeric">Telefonos</th>
                                  <th class="numeric">Ciudad</th>
                                  <th class="numeric">Ver</th>
                                </tr>
                              </thead>
                              <tbody>
                               <?php  foreach($users as $user): $count++; ?>
                              <tr>
                                  <td> <?php echo $user['company'];?></td>
                                  <td><?php echo $user['email'];?></td>
                                  <td><?php echo $user['phone'] . "/" . $user['phone2'];?></td>
                                  <td><?php echo $user['city'] . "/" . $user['state']. "/" . $user['country'];?></td>
                                  <td><a href="/cotizador/mcv5/historico.php?id=<?php echo $user['id']; ?>" class="glyphicon glyphicon-edit"></a></td>
                                </tr>
                                <?php endforeach;  ?>
                              </tbody>
                          </table>
                          </section>
                       
                  </div><!-- /content-panel -->
               </div><!-- /col-lg-4 -->	  
                  <?php  else: ?>
                <br />Sin Posbiles Clientes Asigandos...
                 <?php endif; ?>                
                 
                 