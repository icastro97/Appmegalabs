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
										<th rowspan="2" valign="bottom"><div align="center">Valor</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Adjunto</div></th>																				
										<th rowspan="2" valign="bottom"><div align="center">Eliminar</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Asistentes</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Ver</div></th>
										
									</tr>
									<tr></tr>
								</thead>
								<tbody id="userData2">
									<?php $sumaneto = 0;
									if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
									<tr>
									<td><?php echo $user['id']; ?></td>
									
										<td align="center"><?php echo $user['fecfact']; ?></td>
										<td align="center">
											<?=($user['factura']) ?></td>
										<td align="center">
											<?=($user['nit']) ?></td>
											
										<td align="center">
											<?=$user['establecimiento']; ?></td>
										<td align="center">
											<?=$user['cinversion']; ?></td>	
										<td align="center">
											<?=$user['tipogasto']; ?></td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($user['valor'],2); ?></td>
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
										
										<td align="center">
											<a class="btn btn-danger" href="eliminadetallef.php?op=LISTADO LEGALIZACIONES&amp;documento=<?=$user['identificador']?> "> <i class="glyphicon glyphicon-trash"></i></a>
										</td>
										<?php 
										if($user['tipoCodigo'] == "SI")
													{
										?>
										
										<td align="center">
										
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
										$usuario = $user['identificador'];
											echo "<input type='hidden' id='$usuario' value='$usuario'>"; 
										?>
											<a href="" class="btn btn-primary monohp" data-toggle="modal" data-id="<?php echo $usuario?>" data-target="#largeModal"><i class="glyphicon glyphicon-plus"></i></a>
										<input type="hidden" class="btn btn-primary" data-toggle="modal" data-target="#largeModal">
										
										
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
																<input type="hidden" id="idhp" value="">
																<h5>Panel</h5>						

															</div>
																														
															<div class="col-md-5 ui-front" >
																<input type="text" name="paneles"  class="form-control" id="pan1" placeholder="Nombre del médico">
																<div id="alertaC"></div>
																<input type="hidden" name="cedulapanel1" id="panel1">
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
																<a href="importadorAsistentes.php?id_cabeza=<?= $users[0]['id_cabeza']; ?>&&identificador=<?=$user['identificador']?>" target="_blank" id="importador1" class="btn btn-azure">Importador</a>
																
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
										$identificadorDet = $user['identificador'];		
										$sqls = "SELECT identificadordet from asistencia where identificadordet = ". $identificadorDet;					
										$query = mysqli_query($mysqli, $sqls);
										$numero = mysqli_num_rows($query);
										
										$asistencia = $user['asistencia'];							

										if($asistencia != "" && $numero > 0)
										{	
										
										echo "<td align='center'> <a href='#' class='btn tabla' data-toggle='modal' data-id='$usuario' data-target='#largeModal1' style='background-color:#00AB84;' ><i class='menu-icon glyphicon glyphicon-search' style='color:white;'></i></a> </td>";
										
										
										}										
										?>
										
										
										
									</tr>
									
									
									<?php endforeach; else: ?>
									<tr>
										<td colspan="7">No existen documentos para mostrar......</td>
									</tr>
									<?php endif; ?>
									
									
                               <tr>
							   <?php
							   $cabeza = $users[0]['id_cabeza'];
							   $sql = "SELECT id, asistencia, tipoCodigo FROM `lg_det_cabeza` WHERE id = '$cabeza'  and asistencia IS NULL and tipoCodigo = 'SI'";
									
								$query = mysqli_query($mysqli,$sql);
								
								while($row = mysqli_fetch_assoc($query))
								{
									$ids =  $row['id'];		
														
								}
							   foreach ($detalle as $key) 
							   {
									$identificadordetlg = $key['identificador'];   
									
									
									$sqla = "SELECT * FROM `asistencia` WHERE identificadordet IN('$identificadordetlg')";									
									$querys = mysqli_query($mysqli,$sqla);
									$resultado = mysqli_num_rows($querys);
								
								}	
								if($resultado == 0 || $ids == $detalle[0]['id'] )
								{
							   
									
								
								?>
									<td>
										<a class="btn"style="background-color:#00AB84; color:white;" href="finalizadoc.php?op=LISTADO LEGALIZACIONES&amp;documento=<?=$user['id']?>&aprobador=<?=$users[0]['aprobador']?>&us=<?=$users[0]['identificacion']?>" role="button" disabled>Finalizar </a>
									</td>
							<?php	
								}
								else {
									
							?>		
									<td>
										<a class="btn"style="background-color:#00AB84; color:white;" href="finalizadoc.php?op=LISTADO LEGALIZACIONES&amp;documento=<?=$user['id']?>&aprobador=<?=$users[0]['aprobador']?>&us=<?=$users[0]['identificacion']?>" role="button">Finalizar </a>
										</td>
							
							<?php
									}
									
								?>
                              </tr>
								</tbody>
								
								<tbody>

								</tbody>
								
									
									
								</table>
							
								</div> 
                </div>
								</td>
              </tr>
						
              

              
            </table>


            <div class="modal fade" id="largeModal1" tabindex="-1" role="dialog" aria-labelledby="largeModal1" aria-hidden="true">
										<div class="modal-dialog modal-lg">
									
											<div class="modal-content">
												<div class="modal-header">
												<h4>Asistentes ingresados</h4>
													<button type="button" class="close" data-dismiss="modal" ></button>
													
												</div>
												<div class="modal-body1 ">

													<div class="row">
															<div class="col-md-4"></div>	
															
															
													</div>
													
												
												</div>
												<table class="table" width="150%">
															
															<thead>
															<div class="row">
															<div class="col-sm-1"></div>	
															<div class="col-sm-1"><h5><strong>Id</strong></h5></div>	
															<div class="col-sm-1"><h5><strong>Tipo</strong></h5></div>
															<div class="col-sm-1"><h5><strong>Cantidad</strong></h5></div>
															<div class="col-sm-2"><h5><strong>Nombre Asistente</strong></h5></div>
															<div class="col-sm-2"><h5><strong>Cedula Asistente</strong></h5></div>
															<div class="col-sm-2"><h5><strong>Consentimiento Trans. Valor</strong></h5></div>
															<div class="col-sm-1"><h5><strong>Eliminar</strong></h5></div>
															</div>
															</thead>
														
															
															<tbody id="columna" >
																
															</tbody>
															<input type="hidden" id="ide" value="">
													</table>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
													
												</div>
											</div>
										</div>
									</div>
                      
        </div>
</div>


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
						$('#panel1').val(json.cedula);
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
		
				

