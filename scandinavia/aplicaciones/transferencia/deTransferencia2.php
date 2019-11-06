<?php 
    require_once "estilos.php";
    require_once("../../seguridad/config.php");
    $parametro = $_REQUEST['id'];
	$cedulaSesion = $_SESSION['identificacion'];
	$user_id = $_SESSION['id'];


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

	$condicional['where'] = array('id_factura'=> $sid,); 
    $codigo = $db->getRows('codigos_transferencia',$condicional);
    
    $conditions1['where'] = array('u_userid'=> $detalle[0]['aprobador'],); 
	$apr = $db->getRows('system_users',$conditions1);
	
	$condicionesFact['where'] = array('id_factura'=> $sid,); 
	$facturas = $db->getRows('HistorialFacturas',$condicionesFact);
	
    $condicion['where'] = array('id_factura'=> $sid,); 
	$cond = $db->getRows('codigos_transferencia',$condicion);

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
            <a href="https://appmegalabs.com/scandinavia/aplicaciones/transferencia/listados/aprobador/index.php?op=Aprobacion" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
                 <br> 
                
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
										<th rowspan="2" valign="bottom"><div align="center">Factura</div></th>
										<th rowspan="2" align="center" ><div align="center">NIT</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Establecimiento </div></th>
										<th rowspan="2" valign="bottom"><div align="center">Codigo de inversión </div></th>
										<th rowspan="2" valign="bottom"><div align="center">Tipo Gasto</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Base</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Iva</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Impo Consumo</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Adjunto</div></th>																				
										<th rowspan="2" valign="bottom"><div align="center">Ver</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Novedad Factura</div></th>
									
										
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
											<?=($user['factura']) ?></td>
										<td align="center">
											<?=($user['nit']) ?></td>
											
										<td align="center">
											<?=$user['establecimiento']; ?>
											<input type="hidden" id="ides" value="<?=$user['id_transferencia'];?>">
											</td>
										<td align="center">
											<?php if ($user['estado'] != "APR") {
										
											 ?>
										<a href="" class="btn btn-primary botonarr" data-id="<?php echo $usuario?>" data-toggle="modal" data-target="#exampleModal1"><i class="glyphicon glyphicon-plus"></i></a>
										<?php
											}
																				
										
										else{
											echo "";
										}
									
										$sql = "SELECT * FROM codigosinversion where id_factura = ".$user['id_transferencia'];
										$query = mysqli_query($mysqli, $sql);
										$numero = mysqli_num_rows($query);
										
										if($numero > 0)
										{
										?>
										<a href="" class="btn btn-primary botonarr" data-id="<?php echo $usuario?>" data-toggle="modal" data-target="#exampleModal1" onclick="traecodigos2(<?php echo $user['id_transferencia'];?>)"><i class="glyphicon glyphicon-zoom-in"></i></a>
										<input type="hidden" class="btn btn-primary" data-toggle="modal" data-target="#largeModal">
										<?php
										}
										else
										{
										    
										}
										?>

    </td>
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
										
										
										
										<?php

										
										 

												$consulta="SELECT Cliente FROM medicos WHERE cedula_usuario = ". $cedulaSesion;
												$sql = mysqli_query($mysqli, $consulta);
													
												$array = array();
													while($row = mysqli_fetch_array($sql))
													{
														$equipo = utf8_encode($row['Cliente']);														
														array_push($array, $equipo);
													}


											?> 	
										<?php
									 if ($user['estado'] == "ACEPTADO" || $user['estado'] == "APR") {
										
											 
										$usuarios = $user['id_transferencia'];
											echo "<input type='hidden' id='$usuarios' value='$usuarios'>"; 
										?>
																				
										
										<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Módulo asistencia</h4>
														<button type="button" class="close" data-dismiss="modal"></button>
													</div>
													<div class="modal-body" >
														<div class="row">
															<div class="col-md-4">
																<input type="checkbox" name="panel" id="panel" onChange="deshabilitarUno()">
																<input type="hidden" id="idhp" value="<?php echo $user['id_transferencia']; ?>">
																<h5>Panel</h5>						

															</div>
																														
															<div class="col-md-5 ui-front" >
																<input type="text" name="paneles"  class="form-control" id="pan1" placeholder="Nombre del médico">
																<div id="alertaC"></div>
																<input type="text" name="cedulapanel1" id="panel1">
																<input type="hidden" name="" id="panel2">
																<input type="hidden" name="" id="panel3">
															</div>
                                                    

														<!-- Inicio Panel General -->
													
															<div class="col-md-4">
																<input type="checkbox" name="panelCompleto" id="panelcom" onChange="deshabilitarSeis()">
																
																<h5>Panel Megalabs</h5>						

															</div>
																														
															<div class="col-md-3 ui-front" >
																<input type="text" name="paneles"  class="form-control" id="pan2" placeholder="Cédula del médico" onkeyup="buscarCC()">
																<div id="alertaC"></div>
																
																<input type="hidden" name="" id="panel4">
																<input type="hidden" name="" id="panel5">
															</div>
															<div class="col-md-4">
																	
																	
															<input type="text" name="cedulapanel2" id="panel10" class="form-control" placeholder="Nombre del médico">
																	
															</div>
														<!-- Fin Panel General -->


														<div class="col-md-4">
															<input type="checkbox" name="nopanel" id="nopanel" onClick="deshabilitarDos()" >
															<h5>No panel</h5>
														</div>
															<div class="col-md-4">
																	
															<input type="text" name="nopaneles2" class="form-control"  id="nopaneles2" placeholder="Cédula" onkeyup="prueba()">
															<div id="alertaT"></div>
															</div>
															<div class="col-md-3">
																	
																	
																	<input type="text" name="nopaneles" class="form-control"  id="nopaneles1" placeholder="Nombre Médico">
																	
															</div>
															
															<?php

										
										 

																$consulta="SELECT nombres FROM empleadolg";
																$sql = mysqli_query($mysqli, $consulta);
																	
																$arrayempleado = array();
																	while($row = mysqli_fetch_array($sql))
																	{
																		$nombreempleado = utf8_encode($row['nombres']);														
																		array_push($arrayempleado, $nombreempleado);
																	}


																?> 	
														
														<div class="col-md-4">
															<input type="checkbox" name="empleado" id="empleado" onClick="deshabilitarTres()" >													
															<h5>Empleado</h5>																										
														</div>
															<div class="col-md-4">
																	<input type="text" name="empleados" class="form-control"  id="empleados1" placeholder="Nombre Empleado">
																	<input type="hidden" name="cedulaempleado" id="panel4">
																	
															</div>
															
														<!-- inicio codigo  Importador -->
														
															<div class="col-md-4">
																																									
															</div>
																<div class="col-md-4">
																		
																		<input type="checkbox" name="importador" id="importadorM" onClick="deshabilitarCuatro()" >													
																		<h5>Importador</h5>	
																</div>
																<div class="col-md-4">
																<a href="importadorAsistentes.php?ide=<?=$user['id_transferencia'];?>" target="_blank" id="importador1" class="btn btn-azure">Importador</a>
																
																</div>
																<div class="col-md-1">																																								
															</div>
														<!-- Fin codigo  importador -->	

														<!-- inicio codigo  farmacias -->

															<div class="col-md-4">
															<input type="checkbox" name="farmacia" id="farm" onClick="deshabilitarCinco()" >													
															<h5>Farmacias</h5>																										
														</div>
															<div class="col-md-2">
																	<h5 id="cantidad">Cantidad:</h5>
																	<input type="number" name="numero" class="form-control form-control-sm"  id="num" placeholder="Cantidad">
															</div>				
														<!-- fin codigo  farmacias -->
												
											</div>

											<!-- Modal footer -->
											
											<div class="modal-footer">		
                                          	      								
												<button type="submit" class="btn btn-success" data-dismiss="modal" onclick="registrar()">Registrar</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
											</div>
											
											</div>
											</div>
										</div>
										</div>
										
										</td>	
												<?php

													}
											?>	
										
										
										<?php
										$identificadorDet = $user['id_transferencia'];		
										$sqls = "SELECT identificadordet from asistencia_trans_valor where identificadordet = ". $identificadorDet;					
										$query = mysqli_query($mysqli, $sqls);
										$numero = mysqli_num_rows($query);
										
										$asistencia = $user['asistencia'];							

										if($asistencia != "" && $numero > 0)
										{	
										
									        echo "<td align='center'> <a href='mostrarAsistentes2.php?documento=$identificadorDet' class='btn' style='background-color:#00AB84;' target='_blank'><i class='menu-icon glyphicon glyphicon-search' style='color:white;'></i></a> </td>";
										
										
										}	
									
									else {
										echo " ";
									}									
										?>
										
										<td align='center'>
										    <?php
										    if($user['novedadFacturaDespues'] == NULL)
										    {
										    ?>
										     
										     <button type="button" class="btn btn-danger" style="color: white;" data-toggle="modal" data-target="#exampleModalCenter"><i class="glyphicon glyphicon-bell"></i>    </button>


										     
										    <?php
										    }
										    else
										    {
										        
										     
										     echo $user['novedadFacturaDespues'];
										     }
										     ?>
										</td>
										
									</tr>
										
										
										
										
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
            

            
		     
          </form> 
            
            

 
            
                      
		</div>
	
         <?php
$usuario = $user['id_transferencia'];
?>
<a href='#' class='btn btn-sm tablaHistoricos' data-toggle='modal' data-id='<?=$usuario;?>' data-target='#largeModal1' style='background-color:#00AB84; justify-content:center;' ><i class='glyphicon glyphicon-search icono' style='color:white;'></i></a><br><br>

<div class="modal fade bd-example-modal-lg" " id="largeModal1" tabindex="-1" role="dialog" aria-labelledby="largeModal1" aria-hidden="true">
										<div class="modal-dialog modal-lg">
									
											<div class="modal-content">
												<div class="modal-header">
												<h4>Historial Factura</h4>
													<button type="button" class="close" data-dismiss="modal" ></button>
													
												</div>
												<div class="modal-body1 ">

													<div class="row">
															<div class="col-md-4"><input type="hidden" id="ide" value="<?=$usuario;?>"></div>	
															
															
													</div>
													
												
												</div>
												<table class="table">
                                                  <thead class="thead-dark">
                                                    <tr>
                                                      <th scope="col">Fecha cambio</th>
                                                      <th scope="col">Responsable</th>
                                                      <th scope="col">Estado</th>
                                                      <th scope="col">Observacion</th>
                                                      
                                                    </tr>
                                                  </thead>
                                                  <tbody id="columna">
                                                    
                                                  </tbody>
                                                </table>

												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
													
												</div>
											</div>
										</div>
									</div>
                      
        </div>
</div>
</div>
 
                
<div class="modal fade" id="largeModal2" tabindex="-1" role="dialog" aria-labelledby="largeModal2" aria-hidden="true">
										<div class="modal-dialog modal-lg">
									
											<div class="modal-content">
												<div class="modal-header">
												<h4>Asistentes ingresados</h4>
													<button type="button" class="close" data-dismiss="modal" ></button>
													
												</div>
												<div class="modal-body1">

													<div class="row">
															<div class="col-md-4"></div>	
															
															
													</div>
													
												
												</div>
												<table class="table" width="100%">
															
															<thead>
															<th>ID</th>
															<th>Tipo</th>
															<th>Cantidad</th>
															<th>Nombre Asistente</th>
															<th>Cedula Asistente</th>
															<th width="30px;">Consentimiento</th>
															
															</thead>
														
															
															<tbody id="columna2" >
																
															</tbody>
															<input type="hidden" id="ide" value="<?php echo $user['id_transferencia']; ?>">
													</table>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
													
												</div>
											</div>
										</div>
									</div>
                      
        </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Importar Codigos Inversion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="buscar();">
        </button>
      </div>
      <div class="modal-body">
      <div class="col-sm-6">
		  <div class="botonn">
		  <input type="hidden" name="dato" id="idd" value="<?php echo $sid; ?>">
									
	  <a href="importadorCodigos.php?ide=<?=$user['id_transferencia']?>" target="_blank" class="btn btn-azure">Importador</a>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
			<input type="text" placeholder="Codigo Inversion" class="form-control" id="codigo_inversion" name="codigo_inversion">
			<input type="number" placeholder="Porcentual" class="form-control" id="porcentaje" name="porcentaje">
		</div>
		</div>
</div>
      <div class="modal-footer">
		<button type="button" class="btn btn-success" data-dismiss="modal" onclick="ingresoCod()">Registrar</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="buscar();">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Codigos Inversion</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
	  </div>
	  <div class="modal-body">
		  <div class="table-responsive">	
	  <table class="table " width="100%">
															
		<thead>
			<th>ID Factura</th>
			<th>Codigo Inversion</th>
			<th>Valores</th>
			
		</thead>
																										
		<tbody  id="trans_v1">
														
		</tbody>
		<input type="hidden" id="ide" value="<?php echo $user['id_transferencia']; ?>">
	</table>
	</div>
	  </div>
	  <div class="modal-footer">
		
	  </div>
    </div>
  </div>
</div>


<input type="hidden" id="porcentual" value="<?php echo $cond[0]['porcentual']?>">




<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 align="center"><strong>Novedad factura</strong></h5>
        <button type="button" class="close" data-dismiss="modal" >
          
        </button>
      </div>
      <div class="modal-body">
          
        <textarea  cols="40" rows="3" id="test1"></textarea><br>
        
      </div>
      <div class="modal-footer">
          
          <button type="button" class="btn btn-success" data-dismiss="modal" onClick="pruebaTexto()">Enviar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        
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


<script>
$(document).ready(function () {

	
  var items = <?= json_encode($array)?>
  
  $("#pan1").autocomplete({
		 source: items,
		 select: function (event, item) {
			 var params = { equipo:item.item.value};
			 $.get("getdatos2.php", params, function (response) {
				 var json = JSON.parse(response);
				 if(json.status == 200)
				 {						
						$('#panel1').val(json.id_cliente);
						if(json.transferenciaValor == "Si")
						{
							$('#alertaC').html('<div class="alert alert-success" role="alert"><h5>Tiene transferencia de valor</h5></div>');
						}
						else
						{
							$('#alertaC').html('<div class="alert alert-danger" role="alert"><h5>No tiene transferencia de valor</h5></div>');
						}
				 }
				 else
				 {

					$('#alertaC').html('<h5>No existe.</h5>');
				 }
			 });
		 },
		 minLength: 2
	});
	
	
  
	


	var opciones = <?= json_encode($arrayempleado)?>

	$("#empleados1").autocomplete({
		 source: opciones,
		 minLength: 2,
		 select:function (event, item) {
			 var params = { nombreempleado:item.item.value};
			 $.get("getdatos3.php", params, function (response) {
				 var json = JSON.parse(response);
				 if(json.status == 200)
				 {						
						$('#panel4').val(json.cedula);
						console.log(json);
				 }
				 else
				 {

				 }
			 });
		 }
  });


});


</script>
<?php
function eliminar_tildes($cadena){
 
	//Codificamos la cadena en formato utf8 en caso de que nos de errores
	$cadena = utf8_encode($cadena);

	//Ahora reemplazamos las letras
	$cadena = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
	);

	$cadena = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );

	$cadena = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );

	$cadena = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$cadena );

	$cadena = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );

	$cadena = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C'),
			$cadena
	);

	return $cadena;
}


?>
		
				


    <?php

    require_once('../../pie.php'); 
    ?>