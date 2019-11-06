<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */




// getting total number records without any search
$sql = "SELECT * FROM lg_det_cabeza where id = " . $_POST['varidentificadounico'];
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if($totalData > 0){
$sql = "select a.id, a.moneda,sum(a.valor) as suma from lg_det_cabeza a  where id = " . $_POST['varidentificadounico'] . " group by a.id, a.moneda	";
$query2=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems   " . $_POST['varidentificadounico']);
$totalData2 = mysqli_num_rows($query2);	
	

?>



<div> <h3 align="center">Datos Ingresados  </h3> </div>
<table width="80%" class="table table-condensed table-bordered table-hover">
 
<tr>
  <td><strong>No</strong></td>
    <td><strong>Fecha</strong></td>
    <td><strong>Factura</strong></td>
    <td><strong>NIT</strong></td>
    <td><strong>Establecimiento</strong></td>
    <td><strong>Tipo Gasto</strong></td>
    <td><strong>Valor</strong></td>

</tr>

<?php

while( $row_Transacciones=mysqli_fetch_array($query) ) {  // preparing an array

echo "	<tr>";
	echo " 		<td>".$row_Transacciones['id']."</td>";
	echo " 		<td>".$row_Transacciones['fecfact']."</td>";
	echo " 		<td>".$row_Transacciones['factura']."</td>";
	echo " 		<td>".$row_Transacciones['nit']."</td>";
	echo " 		<td>".$row_Transacciones['establecimiento']."</td>";
	echo " 		<td>".$row_Transacciones['tipogasto']."</td>";
    echo " 		<td align=\"right\">".$row_Transacciones['moneda']?> $<?=number_format($row_Transacciones['valor'],2)."</td>";
	
	echo "	</tr>";
    
}

?>
<tr>
  <td colspan="7"><a class="btn btn-success" href="finalizadoc.php?op=LISTADO LEGALIZACIONES&amp;documento=<?=$_POST['varidentificadounico']?>" role="button">Finalizar Documento</a></td>
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

