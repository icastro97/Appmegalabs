

<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */




// getting total number records without any search
$sql = "SELECT * FROM anticipo where consecutivo = " . $_POST['varidentificadounico']; 
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



if($totalData > 0){
$sql = "select consecutivo, moneda,sum(monto) as suma from anticipo  where consecutivo = " . $_POST['varidentificadounico'] . " group by consecutivo, moneda	";
$query2=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']); 
$totalData2 = mysqli_num_rows($query2);	
	
 
?>
<form method="post" action="finalizadocPro.php" enctype="multipart/form-data"> 




<div> <h3 align="center">Datos Ingresados  </h3> </div>
<table width="80%" class="table table-condensed table-bordered table-hover">
 
<tr>
  <td><strong>No</strong></td>
    <td><strong>Fecha</strong></td>
    <td><strong>tipo</strong></td>
    <td><strong>Identificacion</strong></td>
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

	if($total >= 7000000)
	{
		
		echo "<label for='ex2' id='ar'>Adjuntar póliza</label>";
		echo "<input name='file' id='file' type='file' required='required'>";
		echo "<br>";
		echo "<br>";		
		echo "<button type='submit' class='btn btn-success' disabled='disabled'>Finalizar documento</button>";
		
	}
	else
	{
		echo "<button type='submit' class='btn btn-success'>Finalizar documento</button>";
	}

}
}
?>
 
 
 
 
 
 </table>
 	


</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
$("#file").change(function(){
$("button").prop("disabled", this.files.length == 0);
});
</script>