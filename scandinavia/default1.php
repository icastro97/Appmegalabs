<?php


 require_once("seguridad/config.php");
 require('mcv5/clases/DB.class.php');
 require_once("sesion.php");

 $variablegrupo = "";
if (isset($_REQUEST["group"])) {
	 $variablegrupo = $_REQUEST["group"];
}
 
$usuario = $_SESSION["user_id"];

//$sql20="select * FROM module order by  mod_modulegroupname, mod_moduleorder  ";
$sql20= "select a.id, a.mod_modulegroupcode,a.mod_modulegroupname, a.mod_modulecode, a.mod_modulename, a.mod_modulepagename,  a.icon,b.rr_rolecode, b.status, c.u_userid, c.full_name, c.u_rolecode FROM module a inner join role_rights b on a.mod_modulecode = b.rr_modulecode inner join system_users c on c.u_rolecode = b.rr_rolecode where c.u_userid = " . $_SESSION["user_id"] . " and mod_modulegroupname = '$variablegrupo ' order by a.mod_modulegrouporder,  a.mod_moduleorder ";

$Obser=mysqli_query($mysqli, $sql20);
$row_Obser = mysqli_fetch_assoc($Obser);
$rowcount=mysqli_num_rows($Obser);


$consulta = "SELECT respuesta, modulo FROM `matrizaprobacion` where modulo = 'Anticipos' and sesion =". $usuario;
$sql = mysqli_query($mysqli, $consulta);

while($row = mysqli_fetch_assoc($sql))
{
	 $estados = $row['respuesta'];
	 $modulo = $row['modulo'];
}

$consulta1 = "SELECT respuesta, modulo FROM `matrizaprobacion` where modulo = 'Legalizaciones' and sesion =". $usuario;
$sql1 = mysqli_query($mysqli, $consulta1);

while($row = mysqli_fetch_assoc($sql1))
{
	 $estados1 = $row['respuesta'];
	 $modulo1 = $row['modulo'];
}


?>

<script src="https://code.jquery.com/jquery-1.9.1.js"></script>

<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script>
 $(document).ready(function() 
 {
	$('#pri').trigger('click');
		
		
 });
</script>
<?php require_once("cabeza.php");?>
 <a href="https://appmegalabs.com/scandinavia/default.php" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         <br> 

 <img src="assets/img/app/favoritos.png">


 <?php
 $grupo = $_REQUEST['group'];
	 if($grupo == "Legalizaciones" && $estados1 == "1")
	 { ?>
		
		
<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          
        </button>
      </div>
      <div class="modal-body">
			<h3>Módulo de Legalizaciones</h3>
											Se realizaron las siguientes actualizaciones en el módulo de legalizaciones:
											<br><br>
											<ol>
											<h4>Dar de Baja</h4>
												<li class='prueba'>Encontrarás el botón  <input type='button' class='btn btn-danger' value='Dar baja'> , su función es dar de baja a todas las legalizaciones que no se enviaran para aprobación y que se encuentren en el módulo <strong>ABIERTAS</strong>.</li>																								
												<br>
												<h4>Cambios antes de finalizar</h4>												
												<li class='prueba'>
											
												En el módulo <strong>	ABIERTAS</strong> <img src='assets/img/app/folder.png' width='50px' height='50px'> podrás hacer correcciones en el <strong>Tipo de Legalización</strong> y en las <strong>Observaciones generales. </strong></li>												
												<br>
												<h4>Cambio de aprobador</h4>	
												<li class='prueba'>Ahora podrás cambiar el aprobador de la legalización.  
												<ul>
													<li >Debes ir al segmento de <strong>Selección Aprobador</strong></li>
													<li>Seleccionar cambiar aprobador  <input type='checkbox' checked> .</li>
													<li>Confirmar el cambio dando aceptar en la alerta.</li>
													<li>Buscar el aprobador en el recuadro y selecciona.</li>
													
												</ul>
												</li>
												<br>
												<h4>Rehacer legalizaciones</h4>
												<li class='prueba'>
												Ahora podrás rehacer las legalizaciones que te han rechazado.
													<ul>
													 <li>Debes dar click en el botón <input type='button' class='btn btns'  value='Rehacer'> (Esta acción creara una nueva legalización)</li>
													 <li>Inmediatamente podrás cambiar datos como <strong>Tipo de Legalización, Observaciones, Cambiar aprobador</strong>, eliminar y cargar de nuevo los registros errados. </li>
													 <li>Luego de realizar los ajustes finalizas el documento y este entrara en el ciclo de aprobación habitual. </li>
													 
													</ul>

												</li>
													<form action="prueba2.php" method="post">
													
													 <input type="hidden" name="grupo" value="<?=$grupo?>">
													 <input type="hidden" name="usuario" value="<?=$usuario?>">
													 <input type="hidden" value="<?=$modulo1?>">
													 <input type="hidden" value="<?=$estados1?>">
													 <br>
													 <h5>Confirmo que he leido las actualizaciones publicadas: </h5>
													 <div class="row">
													     
													     <div class="col-md-3"></div>
													     <div class="col-md-2"></div>
													     <div class="col-md-5">	<input type="checkbox" name="checkLeg" value="true" required></div>
													     <div class="col-md-2"></div>
													 	
													 </div>
													 <br>
													 <div class="row">
													     <div class="col-md-2"></div>
													     <div class="col-md-2"></div>
													     <div class="col-md-2">	<input type="submit"  class="btn btns" value="Enviar"></div>
													     <div class="col-md-2"></div>
													 	
													 </div>
													
														
												</form>		
											</ol>
											
											
      </div>
      
    </div>
  </div>
</div>
    
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<!--script para javascript para que carga el modal -->
<script>
        
   $(document).ready(function()
   {
      $("#Modal").modal("show");
   });
</script>
		<?php
		
		echo "
					<div id='feedback'>
						<a href='#popup1'>Actualizaciones</a>
						</div>


						<div id='popup1' class='overlay'>
							<div class='popup'>
									<div class='div1' id='div1'>

									<a class='close' href='#'></a>
									<br><br>
											<div class='' id='quickenquire'>
											<h3>Módulo de Legalizaciones</h3>
											Se realizaron las siguientes actualizaciones en el módulo de legalizaciones:
											<br><br>
											<ol>
											<h4>Dar de Baja</h4>
												<li class='prueba'>Encontrarás el botón  <input type='button' class='btn btn-danger' value='Dar baja'> , su función es dar de baja a todas las legalizaciones que no se enviaran para aprobación y que se encuentren en el módulo <strong>ABIERTAS</strong>.</li>																								
												<br>
												<h4>Cambios antes de finalizar</h4>												
												<li class='prueba'>
											
												En el módulo <strong>	ABIERTAS</strong> <img src='assets/img/app/folder.png' width='50px' height='50px'> podrás hacer correcciones en el <strong>Tipo de Legalización</strong> y en las <strong>Observaciones generales. </strong></li>												
												<br>
												<h4>Cambio de aprobador</h4>	
												<li class='prueba'>Ahora podrás cambiar el aprobador de la legalización.  
												<ul>
													<li >Debes ir al segmento de <strong>Selección Aprobador</strong></li>
													<li>Seleccionar cambiar aprobador  <input type='checkbox' checked> .</li>
													<li>Confirmar el cambio dando aceptar en la alerta.</li>
													<li>Buscar el aprobador en el recuadro y selecciona.</li>
													
												</ul>
												</li>
												<br>
												<h4>Rehacer legalizaciones</h4>
												<li class='prueba'>
												Ahora podrás rehacer las legalizaciones que te han rechazado.
													<ul>
													 <li>Debes dar click en el botón <input type='button' class='btn btns'  value='Rehacer'> (Esta acción creara una nueva legalización)</li>
													 <li>Inmediatamente podrás cambiar datos como <strong>Tipo de Legalización, Observaciones, Cambiar aprobador</strong>, eliminar y cargar de nuevo los registros errados. </li>
													 <li>Luego de realizar los ajustes finalizas el documento y este entrara en el ciclo de aprobación habitual. </li>
													 
													</ul>

												</li>
													
											</ol>
											</div>
									</div>
							</div>
					</div>

			";
		
		
	 }
	 else
	 {
			echo "
					<div id='feedback'>
						<a href='#popup1'>Actualizaciones</a>
						</div>


						<div id='popup1' class='overlay'>
							<div class='popup'>
									<div class='div1' id='div1'>

									<a class='close' href='#'></a>
									<br><br>
											<div class='' id='quickenquire'>
											<h3>Módulo de Legalizaciones</h3>
											Se realizaron las siguientes actualizaciones en el módulo de legalizaciones:
											<br><br>
											<ol>
											<h4>Dar de Baja</h4>
												<li class='prueba'>Encontrarás el botón  <input type='button' class='btn btn-danger' value='Dar baja'> , su función es dar de baja a todas las legalizaciones que no se enviaran para aprobación y que se encuentren en el módulo <strong>ABIERTAS</strong>.</li>																								
												<br>
												<h4>Cambios antes de finalizar</h4>												
												<li class='prueba'>
											
												En el módulo <strong>	ABIERTAS</strong> <img src='assets/img/app/folder.png' width='50px' height='50px'> podrás hacer correcciones en el <strong>Tipo de Legalización</strong> y en las <strong>Observaciones generales. </strong></li>												
												<br>
												<h4>Cambio de aprobador</h4>	
												<li class='prueba'>Ahora podrás cambiar el aprobador de la legalización.  
												<ul>
													<li >Debes ir al segmento de <strong>Selección Aprobador</strong></li>
													<li>Seleccionar cambiar aprobador  <input type='checkbox' checked> .</li>
													<li>Confirmar el cambio dando aceptar en la alerta.</li>
													<li>Buscar el aprobador en el recuadro y selecciona.</li>
													
												</ul>
												</li>
												<br>
												<h4>Rehacer legalizaciones</h4>
												<li class='prueba'>
												Ahora podrás rehacer las legalizaciones que te han rechazado.
													<ul>
													 <li>Debes dar click en el botón <input type='button' class='btn btns'  value='Rehacer'> (Esta acción creara una nueva legalización)</li>
													 <li>Inmediatamente podrás cambiar datos como <strong>Tipo de Legalización, Observaciones, Cambiar aprobador</strong>, eliminar y cargar de nuevo los registros errados. </li>
													 <li>Luego de realizar los ajustes finalizas el documento y este entrara en el ciclo de aprobación habitual. </li>
													 
													</ul>

												</li>
													
											</ol>
											</div>
									</div>
							</div>
					</div>

			";

	 }
	 
	 
	 
	 if ($grupo == "Anticipos" && $estados == "1") 
	 { ?>
		
<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        
          
        </button>
      </div>
      <div class="modal-body">
			<h3>Módulo de Anticipo</h3>
											Se realizaron las siguientes actualizaciones en el módulo de anticipos:
											<br><br>
											<ol>
											<h4>Dar de Baja</h4>
												<li class='prueba'>Encontrarás el botón  <input type='button' class='btn btn-danger' value='Dar baja'> , su función es dar de baja a todos los anticipos que no se enviaran para aprobación y que se encuentren en el módulo <strong>Anticipos Abiertos</strong>.</li>																								
												<br>
												<h4>Cambios antes de finalizar</h4>												
												<li class='prueba'>
											
												En el módulo <strong>	ABIERTAS</strong> <img src='assets/img/app/folder.png' width='50px' height='50px'> podrás hacer correcciones en la <strong>Fecha de reembolso</strong></li>												
												<br>
												<h4>Cambio de aprobador</h4>	
												<li class='prueba'>Ahora podrás cambiar el aprobador del anticipo.  
												<ul>
													<li >Debes ir al segmento de <strong>Selección Aprobador</strong></li>
													<li>Seleccionar cambiar aprobador  <input type='checkbox' checked> .</li>
													<li>Confirmar el cambio dando aceptar en la alerta.</li>
													<li>Buscar el aprobador en el recuadro y selecciona.</li>
													
												</ul>
												</li>
												<br>
												<h4>Nuevo ciclo politica de compras</h4>
												<li>Ahora todos los anticipos de proveedor deberan pasar por revisión de compras y/o gerencia financiera según la politica.</li>
												<form action="prueba2.php" method="post">
													
													 <input type="hidden" name="grupo" value="<?=$grupo?>">
													 <input type="hidden" name="usuario" value="<?=$usuario?>">
													 <input type="hidden" value="<?=$modulo?>">
													 <input type="hidden" value="<?=$estados?>">
													 <br>
													 <h5>Confirmo que he leido las actualizaciones publicadas: </h5>
													 <div class="row">
													     <div class="col-md-3"></div>
													     <div class="col-md-2"></div>
													     <div class="col-md-2"><input type="checkbox" name="checkAnt" value="true" required></div>
													     <div class="col-md-2"></div>
													 	
													 </div>
													 <br>
													 
													 <div class="row">
													     <div class="col-md-2"></div>
													     <div class="col-md-2"></div>
													     <div class="col-md-2">	<input type="submit"  class="btn btns" value="Enviar"></div>
													     <div class="col-md-2"></div>
													 	
													 </div>
													
														
												</form>	
													
											</ol>
      </div>
      
    </div>
  </div>
</div>
  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<!--script para javascript para que carga el modal -->
<script>
        
   $(document).ready(function()
   {
      $("#Modal").modal("show");
   });
</script>
	 <?php
	  	echo "
						<div id='feedback'>
							<a href='#popup1'>Actualizaciones</a>
							</div>


							<div id='popup1' class='overlay'>
								<div class='popup'>
										<div class='div1' >

										<a class='close' href='#'></a>
										<br><br>
												<div class='' id='quickenquire'>
													 <h3>Módulo de Anticipos</h3>
												</div>												
											Se realizaron las siguientes actualizaciones en el módulo de anticipos:
											<br><br>
											<ol>
											<h4>Dar de Baja</h4>
												<li class='prueba'>Encontrarás el botón  <input type='button' class='btn btn-danger' value='Dar baja'> , su función es dar de baja a todos los anticipos que no se enviaran para aprobación y que se encuentren en el módulo <strong>Anticipos Abiertos</strong>.</li>																								
												<br>
												<h4>Cambios antes de finalizar</h4>												
												<li class='prueba'>
											
												En el módulo <strong>	ABIERTAS</strong> <img src='assets/img/app/folder.png' width='50px' height='50px'> podrás hacer correcciones en la <strong>Fecha de reembolso</strong></li>												
												<br>
												<h4>Cambio de aprobador</h4>	
												<li class='prueba'>Ahora podrás cambiar el aprobador del anticipo.  
												<ul>
													<li >Debes ir al segmento de <strong>Selección Aprobador</strong></li>
													<li>Seleccionar cambiar aprobador  <input type='checkbox' checked> .</li>
													<li>Confirmar el cambio dando aceptar en la alerta.</li>
													<li>Buscar el aprobador en el recuadro y selecciona.</li>
													
												</ul>
												</li>
												
													
											</ol>
										</div>
								</div>
						</div>

				";	 
	 }
	 else
	 {
	    echo "
						<div id='feedback'>
							<a href='#popup1'>Actualizaciones</a>
							</div>


							<div id='popup1' class='overlay'>
								<div class='popup'>
										<div class='div1' >

										<a class='close' href='#'></a>
										<br><br>
												<div class='' id='quickenquire'>
													 <h3>Módulo de Anticipos</h3>
												</div>												
											Se realizaron las siguientes actualizaciones en el módulo de anticipos:
											<br><br>
											<ol>
											<h4>Dar de Baja</h4>
												<li class='prueba'>Encontrarás el botón  <input type='button' class='btn btn-danger' value='Dar baja'> , su función es dar de baja a todos los anticipos que no se enviaran para aprobación y que se encuentren en el módulo <strong>Anticipos Abiertos</strong>.</li>																								
												<br>
												<h4>Cambios antes de finalizar</h4>												
												<li class='prueba'>
											
												En el módulo <strong>	ABIERTAS</strong> <img src='assets/img/app/folder.png' width='50px' height='50px'> podrás hacer correcciones en la <strong>Fecha de reembolso</strong></li>												
												<br>
												<h4>Cambio de aprobador</h4>	
												<li class='prueba'>Ahora podrás cambiar el aprobador del anticipo.  
												<ul>
													<li >Debes ir al segmento de <strong>Selección Aprobador</strong></li>
													<li>Seleccionar cambiar aprobador  <input type='checkbox' checked> .</li>
													<li>Confirmar el cambio dando aceptar en la alerta.</li>
													<li>Buscar el aprobador en el recuadro y selecciona.</li>
													
												</ul>
												</li>
												
													
											</ol>
										</div>
								</div>
						</div>

				";	
	 }
	 
 ?>




 <br>




<?php if($rowcount>0){?>
 <table width="80%" border="0" align="center">
    <tr>
      <td><table width="100%" >
        <tr>
          <?php
$Obser_endRow = 0;
$Obser_columns = 3; // number of columns
$Obser_hloopRow1 = 0; // first row flag
do {   
    if($Obser_endRow == 0  && $Obser_hloopRow1++ != 0) echo "<tr>";
   ?>
          <td><br><table width="100%" border="0" cellpadding="15" cellspacing="15">           
            <tr>
              <td align="center">  <a href="<?php echo $row_Obser['mod_modulepagename']; ?>?op=<?php echo $row_Obser['mod_modulename']; ?>"> <img src="assets/img/app/<?php echo $row_Obser['icon']; ?>"></a></td>
            </tr>
            <tr>
              <td align="center"><?php echo ucwords(strtolower($row_Obser['mod_modulename'])); ?></td>
            </tr>
          </table><br><br></td>
          <?php  $Obser_endRow++;
if($Obser_endRow >= $Obser_columns) {
  ?>
 
        </tr>
        <?php
 $Obser_endRow = 0;
  }
} while ($row_Obser = mysqli_fetch_assoc($Obser));
if($Obser_endRow != 0) {
while ($Obser_endRow < $Obser_columns) {
    echo("<td>&nbsp;</td>");
    $Obser_endRow++;
}
echo("</tr>");
}?>
      </table></td>
    </tr>
  </table>

<?php
 }
 else{   echo "<br><br><br>Sin Aplicaciones asignadas a su perfil"; }
require_once("pie.php");
?>
