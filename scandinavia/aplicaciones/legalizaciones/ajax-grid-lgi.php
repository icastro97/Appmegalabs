<style>
.boton{background-color:#337ab7;}
.glyphicon{font-size: 20px; color:white;}
.ui-front{
    z-index: 9999999999;
}
</style>

<?php

require_once("../../mcv5/clases/DB.class.php");
require_once("../../seguridad/config.php");
$cedulaSesion = $_SESSION['identificacion'];
/* Database connection end */

?>

    
	

<?php
$arreglo = [];

$sql1 = "SELECT * FROM lg_cabeza where id_cabeza = " . $_POST['varidentificadounico'];
$query33 = mysqli_query($mysqli,$sql1);
while($row = mysqli_fetch_assoc($query33))
{
	$id_cabeza =  $row['id_cabeza'];
}

$sqls = "SELECT * FROM lg_det_cabeza where id = " . $_POST['varidentificadounico'];
$query32 = mysqli_query($mysqli,$sqls);
while($row = mysqli_fetch_array($query32))
{ 
	$arreglo [] = $row;
}



// getting total number records without any search
$sql = "SELECT * FROM lg_det_cabeza where id = " . $_POST['varidentificadounico'];
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if($totalData > 0){
$sql = "select a.id, a.moneda,sum(a.valor) as suma from lg_det_cabeza a  where id = " . $_POST['varidentificadounico'] . " group by a.id, a.moneda	";
$query2=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']);
$totalData2 = mysqli_num_rows($query2);	
	
$sql20= "select a.factura,a.nit ,a.fichero as name, a.tipo as type, a.id as legalizacion, b.ico from lg_det_cabeza a inner join rc_mime b on a.tipo = b.type where a.id =   " . $_POST['varidentificadounico'];
$Obser=mysqli_query($mysqli, $sql20);
$row_Obser = mysqli_fetch_assoc($Obser);
$rowcount=mysqli_num_rows($Obser);
?>


<input type="hidden" id="lgcabeza" value="<?= $_POST['varidentificadounico'];?>">
<div> <h3 align="center">Datos Ingresados  </h3> </div>

<table width="80%" class="table table-condensed table-bordered table-hover">
 
<tr>
  <td><strong>No</strong></td>
    <td><strong>Fecha</strong></td>
    <td><strong>Factura</strong></td>
    <td><strong>NIT</strong></td>
    <td><strong>Establecimiento</strong></td>
		<td><strong>Codigo de Inversion</strong></td>
    <td><strong>Tipo Gasto</strong></td>
    <td><strong>Valor</strong></td>
		<td><strong>Adjunto</strong></td>
	<td><strong>Accion</strong></td>
	<td><strong>Asistentes</strong></td>
	<td><strong>Ver</strong></td>
	
</tr>

<?php

while( $row_Transacciones=mysqli_fetch_array($query) ) {  // preparing an array

echo "	<tr>";
	echo " 		<td>".$row_Transacciones['id']."</td>";
	echo " 		<td>".$row_Transacciones['fecfact']."</td>";
	echo " 		<td>".$row_Transacciones['factura']."</td>";
	echo " 		<td>".$row_Transacciones['nit']."</td>";
	echo " 		<td>".$row_Transacciones['establecimiento']."</td>";
	echo " 		<td>".$row_Transacciones['cinversion']."</td>";
	echo " 		<td>".$row_Transacciones['tipogasto']."</td>";
	echo " 		<td align=\"right\">".$row_Transacciones['moneda']?> $<?=number_format($row_Transacciones['valor'],2)."</td>";
	echo "    <td align='center'>";
	if($row_Transacciones['tipo'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
	{
		echo "<a href=\"uploads/" . $row_Transacciones['fichero'] . " \"target=\"\_blank\">";
		echo "<img src='/scandinavia/assets/images/ico/ico_word.png' width='20' height='20' />"; 
	}
	else if($row_Transacciones['tipo'] == "image/png")
	{
		echo "<a href=\"uploads/" . $row_Transacciones['fichero'] . " \"target=\"\_blank\">";
		echo "<img src='/scandinavia/assets/images/ico/ico_png.png' width='20' height='20' />"; 
		
	}  
	else if ($row_Transacciones['tipo'] == "application/pdf")
	{
		echo "<a href=\"uploads/" . $row_Transacciones['fichero'] . " \"target=\"\_blank\">";
		echo "<img src='/scandinavia/assets/images/ico/ico_pdf.png' width='20' height='20' />";                   
	}
	else if($row_Transacciones['tipo'] == "image/jpg" or $row_Transacciones['tipo'] == "image/jpeg")
	{
		echo "<a href=\"uploads/" . $row_Transacciones['fichero'] . " \"target=\"\_blank\">";
		echo "<img src='/scandinavia/assets/images/ico/ico_jpg.png' width='20' height='20' />"; 
	}	
	else if($row_Transacciones['tipo'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
	{
		echo "<a href=\"uploads/" . $row_Transacciones['fichero'] . " \"target=\"\_blank\">";
		echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' />"; 
	}
	else if($row_Transacciones['tipo'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
	{
		echo "<a href=\"uploads/" . $row_Transacciones['fichero'] . " \"target=\"\_blank\">";
		echo "<img src='/scandinavia/assets/images/ico/ico_powerpoint.png' width='20' height='20' />"; 
	}
	
	echo "    </td>";	
	echo " 		<td align=\"center\"><input type=\"button\" value=\"Eliminar\" class=\"btn btn-danger\" onclick=\"javascript:
	eliminarsolicitud2('".$row_Transacciones['identificador']."' , '".$row_Transacciones['id']."')\"></td>";

echo "<td align=\"center\">";
if($row_Transacciones['tipoCodigo'] == "SI")
{
 
	?>
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
		$usuario = $row_Transacciones['identificador'];
		echo "<input type='hidden' id='$usuario' value='$usuario'>"; 		
		?>
	<a href="" class="btn boton monohp" data-toggle="modal" data-id="<?php echo $usuario?>" data-target="#largeModal" disabled><i class="glyphicon glyphicon-plus"></i></a>
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
										
										
<?php
	echo "</td>";
	echo "</tr>";
	}	
}									
?>


<?php
 $cabeza = $id_cabeza;
 $sql = "SELECT id, asistencia, tipoCodigo FROM `lg_det_cabeza` WHERE id = '$cabeza'  and asistencia IS NULL and tipoCodigo = 'SI'";
									
 $query = mysqli_query($mysqli,$sql);
 
 while($row = mysqli_fetch_assoc($query))
 {
	 $ids =  $row['id'];		
						 
 }
 foreach ($arreglo as $key) 
 {
	  $identificadordetlg = $key['identificador'];   
	 
	  
	  $sqla = "SELECT * FROM `asistencia` WHERE identificadordet IN('$identificadordetlg')";									
	  $querys = mysqli_query($mysqli,$sqla);
	  $resultado = mysqli_num_rows($querys);
  
  }
  if($resultado == 0 || $ids == $arreglo[0]['id'])
  {		
			
?>
<tr>
  <td colspan="2"><a class="btn" style="background-color:#337ab7; color:white;" href="index2.php?documento=<?=$_POST['varidentificadounico']?>" role="button">Actualizar </a></td>
  </tr>
  <?php	
	}
	else 
	{
		
?>
<tr>
	<td colspan="2"><a class="btn" style="background-color:#00AB84; color:white;" href="finalizadoc.php?op=LISTADO LEGALIZACIONES&amp;documento=<?=$_POST['varidentificadounico']?>" role="button">Finalizar </a></td>
	</tr>
	<?php
		}
		
	?>	
</tr>

</table>



<table align="right" width="20%" table table-striped>
 
<tr>
  <td><strong>Moneda</strong></td>
    <td><strong>Valor</strong></td>
  
</tr>

<?php

while( $row_Transacciones2=mysqli_fetch_array($query2) ) {  // preparing an array

echo "	<tr>";
	echo " 		<td>".$row_Transacciones2['moneda']."</td>";
	echo " 		<td align=\"right\">$".number_format($row_Transacciones2['suma'], 2) . "</td>";
	
	echo "	</tr>";   
}
}
?>

</table>

<script>




function deshabilitarUno() 
{
	let checkeado = $('#panel').prop('checked');
	if(checkeado )
	{
		document.getElementById("nopanel").disabled=true;	
		document.getElementById("empleado").disabled=true;
		document.getElementById("importadorM").disabled=true;
		document.getElementById("farm").disabled=true;
		document.getElementById("panelcom").disabled=true;	
		$('#pan1').show();

		
	}
	else
	{
		document.getElementById("nopanel").disabled=false;	
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#pan1').hide();
		$('#alertaC').hide();
	}

}



function deshabilitarDos() 
{
	let checkeado = $('#nopanel').prop('checked');
	if(checkeado )
	{
		document.getElementById("panel").disabled=true;	
		document.getElementById("empleado").disabled=true;
		document.getElementById("importadorM").disabled=true;
		document.getElementById("farm").disabled=true;
		document.getElementById("panelcom").disabled=true;	
		$('#nopaneles1').show();
		$('#nopaneles2').show();
		$('#alertaT').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#nopaneles1').hide();
		$('#nopaneles2').hide();
		$('#alertaT').hide();
	}

}


function deshabilitarTres() 
{
	let checkeado = $('#empleado').prop('checked');
	if(checkeado )
	{
		document.getElementById("panel").disabled=true;	
		document.getElementById("nopanel").disabled=true;
		document.getElementById("importadorM").disabled=true;
		document.getElementById("farm").disabled=true;
		document.getElementById("panelcom").disabled=true;	
		$('#empleados1').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#empleados1').hide();
	}

}


function deshabilitarCuatro()
{

	let checkeado = $('#importadorM').prop('checked');
	if(checkeado )
	{
		document.getElementById("panel").disabled=true;	
		document.getElementById("nopanel").disabled=true;
		document.getElementById("empleado").disabled=true;
		document.getElementById("farm").disabled=true;
		document.getElementById("panelcom").disabled=true;	
		$('#importador1').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("empleado").disabled=false;
		document.getElementById("farm").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#importador1').hide();
	}

}


function deshabilitarCinco()
{

	let checkeado = $('#farm').prop('checked');
	if(checkeado )
	{
		
		document.getElementById("panelcom").disabled=true;	
		document.getElementById("panel").disabled=true;	
		document.getElementById("nopanel").disabled=true;
		document.getElementById("empleado").disabled=true;
		document.getElementById("importadorM").disabled=true;
		$('#num').show();
		$('#cantidad').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;
		document.getElementById("panelcom").disabled=false;	
		$('#num').hide();
		$('#cantidad').hide();
	}

}


function deshabilitarSeis()
{

	let checkeado = $('#panelcom').prop('checked');
	if(checkeado )
	{
		document.getElementById("panel").disabled=true;	
		document.getElementById("nopanel").disabled=true;
		document.getElementById("empleado").disabled=true;
		document.getElementById("importadorM").disabled=true;
		document.getElementById("farm").disabled=true;
		$('#panel10').show();
				$('#pan2').show();
	}
	else
	{
		document.getElementById("panel").disabled=false;	
		document.getElementById("nopanel").disabled=false;
		document.getElementById("empleado").disabled=false;
		document.getElementById("importadorM").disabled=false;		
		document.getElementById("farm").disabled=false;
		$('#panel10').hide();
				$('#pan2').hide();
	}

}


</script>


<script>
$(document).ready(function () {
	$('#num').hide();
				$('#panel10').hide();
				$('#pan2').hide();
				$('#cantidad').hide();
				$('#importador1').hide();			
				$('#nopaneles2').hide();
				$('#empleados1').hide();
				$('#nopaneles1').hide();
				$('#pan1').hide();
	
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
					console.log(json);
				 }
			 });
		 },
		 minLength: 2
  });


});

$(".monohp").click(function(){
	let id = $(this).data('id');
	$(".modal-body #idhp").val(id);
})

$(".tabla").click(function(){
	let ide = $(this).data('id');	
	$(".modal-body1 #ide").val(ide);
	let lgcabeza = $('#lgcabeza').val();
	$.ajax({
		 type: 'POST',
		 url: 'traerAsistentes.php',
		 data:{ide, lgcabeza},
		 success:function(r)
			{
				let json = JSON.parse(r);
				let template = '';
				
					json.forEach(dato => {
				 	
					template += `
					<div class="row">
					<div class='col-sm-1'></div>
					<div class='col-sm-1'><h5>${dato.id_asistencia}</h5></div>					
					<div class='col-sm-1'><h5>${dato.tipo}</h5></div>	
					<div class='col-sm-1'><h5>${dato.cantidad}</h5></div>	
					<div class='col-sm-2'><h5>${dato.nombreAsistente}</h5></div>
					<div class='col-sm-2'><h5>${dato.cedulaAsistente}</h5></div>
					<div class='col-sm-2'><h5>${dato.transferenciaValor}</h5></div>
					<div class='col-sm-1'><a href="#" class="btn btn-danger" onclick="eliminarAsistentes(${dato.id_asistencia}, ${dato.consecutivo})"><i class="glyphicon glyphicon-trash"></i></a></div>
					</div>`;
 				});
				
				$('#columna').html(template);
				
			}
	});



})

function eliminarAsistentes(asistencia, consecutivo)
{	

	swal({
  title: "Estas seguro ?",
  text: "se removera el asistente",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    $.ajax({
		url:'eliminarAsistentes.php',
		type:'POST',
		data:{asistencia, consecutivo},
		success: function (response)
		{
			if(response == "true")
			{
				swal("Bien", {
      			icon: "success",
    		});
				
			}
			else
			{
				swal("Mals :(",{
					icon:"error",
				});	
			}
		}
	});
  } else {
    swal("Cancelado :(",{
					icon:"error",
				});	
  }
});
	
}

function registrar()
{
	
	let lgcabeza = $('#lgcabeza').val();
	let id = $(".modal-body #idhp").val();
	let panel = $('#pan1').val();
	let cedulapanel = $('#panel1').val();
	let nopanel = $('#nopaneles1').val();
	let nopanelcedula = $('#nopaneles2').val();
	let empleado = $('#empleados1').val();	
	let cedulaempleado = $('#panel4').val();
	let cantidad = $('#num').val();
	let primercheck;
	let segundocheck;
	let tercercheck;
	let cuartocheck;
	let quintocheck;
	if($('#panel').prop('checked'))
	{
		primercheck = "panel";
		
	}
	else
	{
		primercheck = " ";
		
	}
	if($('#nopanel').prop('checked'))
	{
		segundocheck = "nopanel";
		
	}
	else
	{
		segundocheck = " ";
		
	}
  if($('#empleado').prop('checked'))
	{
		tercercheck = "empleado";
		
	}
	else
	{
		tercercheck = " ";
		
	}
	if($('#importadorM').prop('checked'))
	{
		cuartocheck = "importado";
	}
	else
	{
		cuartocheck = "";
	}
	if($('#farm').prop('checked'))
	{
		quintocheck = "Farmacia";
	}
	else
	{
		quintocheck = "";
	}
	$.ajax({
			type:"POST",
			url: "insertar.php",
			data:{lgcabeza, id, cantidad, panel, nopanel, nopanelcedula, empleado, primercheck, segundocheck, tercercheck, quintocheck, cedulapanel, cedulaempleado},
			success:function(r)
			{
				if(r == "Insertado")
				{
					
					swal ( "Agregado correctamente" ,  "Se agrego la información correctamente" ,  "success");
					
				}
				else
				{
					swal ( "Fallo en el server" ,  "No se realizó la inserción." ,  "error");
					
					
				}
			}
	});
 
}


function buscarCC() 
{
	
	$("#pan2").autocomplete({
		source: 'buscarCedulam.php', 
		response: function(e, ui){	
			ui.content.map(i => i.label = i.cedula);			
		},
		minLength: 2,		
		select: function(event, ui) {
			
			event.preventDefault();		
			
			$('#panel10').val(ui.item.nombremedico);
			$('#pan2').val(ui.item.cedula);		 
		}
	});
}


function prueba()
{
	let cedulanopanel = $('#nopaneles2').val();
	$.ajax({
		url:'cedulaConsentimiento.php',
		data:{cedulanopanel},
		type:'POST',
		success: function (response)
		{
				
				let json = JSON.parse(response);
				let template = '';
					json.forEach(dato => {
					template += `${dato.transferenciaValor}`
					

				});
				if(template != '')
				{
					
					$('#alertaT').html("<div class='alert alert-success' role='alert'><h5>"+template+"</h5></div>");
				}
				else
				{
					$('#alertaT').html("<div class='alert alert-danger' role='alert'><h5>No tiene transferencia de valor para este medico</h5></div>");
					
				}
		}

	});
}

// function importar()
// {
// 	$.ajax({
// 			type:"POST",
// 			url: "pruebas.php",
// 			data:{lgcabeza, id, nombre, },
// 			success:function(r)
// 			{
// 				if(r)
// 				{
// 					alert("Agregado con exito");
					
// 				}
// 				else
// 				{
// 					alert("Fallo el server");
// 				}
// 			}
// 	});
// }
	function pruebaDatos()
	{
		
				let codigo = $('#cinversion1').val();
					
					let dato = new String();

					dato = codigo;

					
					 var conversion = dato.substring(8,10);

					
				if(conversion != "")
				{
				 $.ajax({
				 			type:'POST',
				 			url:'transferencia.php',
				 			data:{conversion},					
				 			success: function (response)
				 			{
								 let json = JSON.parse(response);
								 
				 				let template = '';
								 json.forEach(dato => {
									template += `					
									<input name='tipoCodigo' id='code' type='hidden' value="${dato.tipo}"> <input name='codigoTipo' id='codedos' type='hidden'  value='${dato.codigo}'>`
						
					
									});
										$('#tipo').html(template);

				 			}

				 });
				}	
				else
				{
					$('#codes').val('');
					$('#codesdos').val('');
					$('#code').val('');
					$('#codedos').val('');
				} 
	
	}

</script>