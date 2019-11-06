<?php 
    require_once "estilos.php";
    require_once("../../seguridad/config.php");
    $parametro = $_REQUEST['id'];
    $cedulaSesion = $_SESSION['identificacion'];

    $status = FALSE;


    require_once("../../seguridad/arraypermiso.php");
    unset($_SESSION['uId']);

    //start session
    //session_start();

    //get session data
    $sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

    $modulo = 'Legalizaciones';


    if (isset($_REQUEST['documento'])) {
        $sid = $_REQUEST['documento'];  		
    }


    //load and initialize database class
    require_once '../../mcv5/clases/DB.class.php';
    $db = new DB();

    //get users from database
    $conditionsempresa['where'] = array('id '=> 1,); 
    $empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar


    $bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar


    $condition['where'] = array('cedulaSesion'=> $cedulaSesion,); 
    $usuario = $db->getRows('matrizaprobacion',$condition);

    $condition['where'] = array('id_transferencia'=> $sid,); 
    $detalle = $db->getRows('transferencia_val',$condition);

    
    $conditions1['where'] = array('u_userid'=> $detalle[0]['aprobador'],); 
    $apr = $db->getRows('system_users',$conditions1);


    //get status message from session
    if(!empty($sessData['status']['msg'])){
        $statusMsg = $sessData['status']['msg'];
        $statusMsgType = $sessData['status']['type'];
        unset($_SESSION['sessData']['status']);
    }
    ?>


    <?php  require_once('../../cabeza.php'); 

require_once('estilos.php');
    if(!isset($_SESSION["session_username"])) {	
    header("location:../../prueba.php");
    } 
    else {?>
        <!-- Main content -->
        
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />	
<script src="assets/jquery.maskMoney.js" type="text/javascript"></script>
<script src="main.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="estilostranfer.css">



 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
            <a href="https://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/listadolegalizacionesproceso.php?op=ABIERTAS" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
                 <br> 
				 <div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6"></div>
						<div class="col-md-3"></div>
						

					</div>
                    <div class="panel panel-default users-content" id="seleccion">
    <div class="panel-body">
	<div class="panel" style="border:1px solid #00AB84;" >            
			<div class="panel-heading text-center form-control" >Seleccion Aprobador</div> 

            <input name="docupdate" type="hidden" id="docupdate" value="<?=$_REQUEST['documento'];?>" />
			<td >&nbsp;</td>
			<td >&nbsp;</td>
			<div class="row">
                <div class="col-md-4" id="">
                <div class="col-md-6" id="apro1">               
                    </div>
</div>	       
				<input type="hidden" name="nombreaprobador" id="" value="<?php echo $apr[0]['u_userid']; ?>">				
			</div>
			<div class="row">
				<div class="col-md-4" id=""></div>
				<div class="col-md-5" id="apro3" > <h4>El aprobador es : <strong><?php echo $apr[0]['full_name'] ?></strong></h4>

               
         
				</div>				
				
			</div>			
			<div class="row">
			<div class="col-md-4" id=""></div>
			<div class="col-md-6" id="apro2">

            </div>			
			</div>
			<div class="row">
			<div class="col-md-4" id=""></div>	
			<div class="col-md-5" id="aprobadores">
				
							
			</div>			
			</div>
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-5">
				<div id="valida"></div>
				</div>
			</div>
			

	</div>
	</div>
	</div>  
			<td >&nbsp;</td><td >&nbsp;</td>
			<div class="table-responsive">  
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
              
                <td colspan="2"><div id="resultado1">
                 
                </div></td>
              </tr>
              <tr>
                <td><div id="resultadotemporal">

						 
								<table class="table table-striped table-bordered">
								
								<tbody id="userData">
									<tr></tr>
								</tbody>
								<thead>
									<tr>
										<th rowspan="2">No</th>									
										<th rowspan="2" valign="bottom"><div align="center">Fecha</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Tipo factura</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Radicado</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Factura</div></th>
										<th rowspan="2" align="center" ><div align="center">NIT</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Establecimiento </div></th>										
										<th rowspan="2" valign="bottom"><div align="center">Tipo Gasto</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Base</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Iva</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Impo Consumo</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Adjunto</div></th>																				
										
										
									</tr>
									<tr></tr>
								</thead>
								<tbody id="userData2">
									<?php $sumaneto = 0;
									if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
									<tr>
									<td><?php echo $user['id_transferencia']; ?></td>
									
										<td align="center"><?php echo $user['fecfact']; ?></td>
												<td align="center">
											<?=($user['tipoFactura']) ?></td>
										<td align="center">
											<?=($user['radicado']) ?></td>
										
										<td align="center">
											<?=($user['factura']) ?></td>
										<td align="center">
											<?=($user['nit']) ?></td>
											
										<td align="center">
											<?=$user['establecimiento']; ?></td>
									
										<td align="center">
											<?=$user['tipogasto']; ?></td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($user['valorSinImpuesto'],2); ?></td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($user['valorImpuesto'],2); ?></td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($user['valorIca'],2); ?></td>
										<td align="center">
											<?php 
											if($user['tipo'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_word.png' width='20' height='20' />"; 
											}
											else if($user['tipo'] == "image/png")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_png.png' width='20' height='20' />"; 
												
											}  
											else if ($user['tipo'] == "application/pdf")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_pdf.png' width='20' height='20' />";                   
											}
											else if($user['tipo'] == "image/jpg" or $user['tipo'] == "image/jpeg")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_jpg.png' width='20' height='20' />"; 
											}	
											else if($user['tipo'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' />"; 
											}
											else if($user['tipo'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_powerpoint.png' width='20' height='20' />"; 
											}
											?>
										</td>
										<?php if($user['estado'] == 'NO ACEPTO' || $user['estado'] == 2){?>
										<td><button data-toggle="modal" data-target="#edicion" class="btn btn-sm" style ="  background-color: #00965e; color: white;"><i class="glyphicon glyphicon-pencil" style ="font-size: 15px;"></i></button></td>
										
										
										
										<?php
										} 
										else{
										    
										}
										?>
										
										
										
									</tr>
									
									
									<?php endforeach; else: ?>
									<tr>
										<td colspan="7">No existen documentos para mostrar......</td>
									</tr>
									<?php endif; ?>
									
									
                               
								</tbody>
								
								<tbody>

								</tbody>
								
									
									
								</table>
							
								</div> 
                </div>
								</td>
              </tr>
						
              

              
            </table>
            <?php if($user['estado'] == 'NO ACEPTO'){?>

    <label>Motivo Rechazo</label>
        <textarea class="form-control" id="motivo" name="motivo"  disabled><?php echo $user['observacionG']; ?></textarea>
         		<?php
										} 
										else{
										    
										}
										?>   
		     
          </form> 
            

            
                      
        </div>
<div class="modal fade" id="edicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edicion Factura</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <form action ="actualizaFactura.php" method="POST" enctype="multipart/form-data">
                    <label>Radicado</label>
                    <input type="text" name="radicado" class="form-control" value ="<? echo $user['radicado']; ?>">
                    <input type="hidden" name="transf" value ="<?php echo $user['id_transferencia']; ?>"></input>
                    <input type="hidden" name="userSess" value ="<?php echo $_SESSION['user_id']; ?>">
                <label>Fecha</label>
                <input type="text"  class="form-control inputstl" name="fecha" id="s" placeholder="Seleccionar Fecha" value="<?php echo $user['fecfact']; ?>">
                <label>Establecimiento</label>
                <input type="text" id="nombreM" name="nombre" class="form-control" value="<? echo $user['establecimiento']; ?>"></input>
                <label>Tipo Factura</label>
                <select id="gastoM" class="form-control form-control-lg" name="tipoGasto" >
                                <option value="<?= $user['tipoFactura'];?>"><?= $user['tipoFactura'];?></option>
                                <option value="ClienteF">Factura cliente Fisica</option>
                                <option value="ClienteE">Factura cliente Electronica</option>
                                <option value="Electronica">Factura electronica</option>
                                <option value="Fisica">Factura fisica</option>
			    			     </select>
                <label>IVA</label>
                <input id="ivaM" type="text" name="iva" class="form-control" value="<?= $user['valorImpuesto'];?>"></input>
            </div>
            <div class="col">
                <label>Factura</label>
                <input id="facturaM" type="text" name="factura" class="form-control" value="<?= $user['factura'];?>"></input>
                <label>NIT</label>
                <input id="nitM" type="text" class="form-control" name="nit" value="<?= $user['nit'];?>"></input>
                <label>Base</label>
                <input id="baseM" type="text" name="base" class="form-control" value="<?= $user['valorSinImpuesto'];?>"></input>
                <label>IPOCONSUMO</label>
                <input id="consumoM" type="text" name="consumo" class="form-control" value="<?= $user['valorIca'];?>"></input>
            </div>
            <input name="archivo" id="archivoM" type="file" class="form-control-file" value="<?= $user['fichero'];?>"></input><br>
            
            <label>Descripcion</label>
            <textarea class="form-control" name ="descripcion"><?= $user['descripcion'];?></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
      </div>
    </div>
  </div>
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

