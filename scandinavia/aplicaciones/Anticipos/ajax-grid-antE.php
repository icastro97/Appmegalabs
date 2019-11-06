
<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */

$consulta = "SELECT identificacion FROM anticipo where consecutivo = " . $_POST['varidentificadounico']; 
$query=mysqli_query($mysqli, $consulta) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']);







// getting total number records without any search
$sql = "SELECT * FROM anticipo where consecutivo = " . $_POST['varidentificadounico']; 
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



if($totalData > 0){
$sql = "select  identificacion,consecutivo, moneda,sum(monto) as suma from anticipo  where consecutivo = " . $_POST['varidentificadounico'] . " group by consecutivo, moneda	";
$query2=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']); 
$totalData2 = mysqli_num_rows($query2);	
	
 
?>

<div> <h3 align="center">Datos Ingresados  </h3> </div>
<table width="80%" class="table table-condensed table-bordered table-hover">
 
<tr>
  <td><strong>No</strong></td>
    <td><strong>Fecha</strong></td>
    <td><strong>Tipo</strong></td>
    <td><strong>Identificación</strong></td>
    <td><strong>Nombre</strong></td>
    <td><strong>Valor</strong></td>
    <td><strong>Accion</strong></td>
</tr>

<?php

while( $row_Transacciones=mysqli_fetch_array($query) ) {  // preparing an array

	echo "	<tr>";
	echo " 		<td>".$row_Transacciones['consecutivo']."</td>"; 
	echo " 		<td>".$row_Transacciones['fechaActual']."</td>";
	echo " 		<td>".$row_Transacciones['tipo']."</td>";
	echo " 		<td>".$row_Transacciones['identificacion']."</td>";
	echo " 		<td>".$row_Transacciones['nombre']."</td>";
	echo " 		<td align=\"right\">".$row_Transacciones['moneda']?> $<?=number_format($row_Transacciones['monto'],2)."</td>";	
	echo " 		<td align=\"center\"><input type=\"button\" value=\"Eliminar\" class=\"btn btn-danger\" onclick=\"javascript:
	eliminarsolicitud2('".$row_Transacciones['id_anticipo']."', '".$row_Transacciones['consecutivo']."')\"></td>"; 
	echo "	</tr>";
    
}

?>

 	<tr>
	
	<input  name="consecutivo" type="hidden" value="<?=$_POST['varidentificadounico']?>">
		</td> 
	</tr>
	
  
</table>



<table align="right" width="15%" table table-striped>
 
<tr>
  <td><strong>Moneda</strong></td>
    <td><strong>Valor</strong></td>
  
</tr>



<?php

while( $row_Transacciones2=mysqli_fetch_array($query2) ) {  // preparing an array

	echo "	<tr>";
	echo " 		<td>".$row_Transacciones2['moneda']."</td>";
	echo " 		<td align=\"right\" id=\"total\">$".number_format($row_Transacciones2['suma'], 2) . "</td>";
	
	echo "	</tr>"; 
	
	$total = floatval($row_Transacciones2['suma']);

		
		



$sqlx = "SELECT * FROM system_users WHERE cedula=". $row_Transacciones2['identificacion'];
$consults = mysqli_query($mysqli, $sqlx);
while ($fila = mysqli_fetch_array($consults)) 
{
	$cedula = $fila['cedula'];
	$imagen = $fila['ubicacionFirma'];

	if($imagen == null)
	{
		
		?>
		<div class="alert alert-danger" role="alert">
			No cuenta con una firma, por favor presione el botón CREAR FIRMA para contar con una.		
		</div>
		<div class="col-md-6">
			<a class="btn" style="background-color:#00AB84; color:white;" href="firmar.php?documento=<?=$_POST['varidentificadounico']?>" role="button">Crear firma</a>
		</div>
		<?php
	}
	else
	{
		
		?>
		<div class="alert alert-success" role="alert">
			Ya cuenta una firma, por favor presione el botón FINALIZAR DOCUMENTO para enviar el anticipo.		
		</div>
		<input  name="imagen" type="hidden" value="<?=$imagen?>">
		<a class="btn" style="background-color:#00AB84; color:white;" href="finalizadocEmp2.php?op=Listado Anticipos&imagen=<?=$imagen?>&identificacion=<?=$cedula?>&documento=<?=$_POST['varidentificadounico']?>" role="button">Finalizar documento</a>		
		<?php		
		
	}
	
}

		/*echo "<br>";
	echo "<br>";		
		*/
	}	
}
?>




</table>