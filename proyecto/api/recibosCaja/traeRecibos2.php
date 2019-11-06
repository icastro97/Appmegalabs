<?php
/**
 * Retorna lista de clientes.
 */
require '../precios/database.php';
$id = $_GET['id'];
$ped = [];
$sql = "SELECT T1.DocumentID, T1.Documento, T1.ValorDocumento, T1.RetImpositiva, T1.DesPPago, T1.DesAdicional, T1.OtrosDescuentos, T1.NoNota, T1.ValNota, T1.ValNeto, T1.DiasPago, T1.TiempoPago, T1.Habilitado, T2.Cliente, T2.cod, T2.ValAntesIva,T2.NIT, T2.Saldo, T2.VtoFecha FROM `rd_detalle` 
T1 INNER JOIN vw_basec_vendedores T2 ON T1.Documento = T2.Documento WHERE T1.DocumentID ='$id' GROUP BY T2.Cliente";
//var_dump($sql);
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $ped[$i]['DocumentID']    = $row['DocumentID'];
    $ped[$i]['Documento']    = $row['Documento'];
    $ped[$i]['ValorDocumento']    = $row['ValorDocumento'];
    $ped[$i]['RetImpositiva']    = $row['RetImpositiva'];
    $ped[$i]['DesPPago']    = $row['DesPPago'];
    $ped[$i]['DesAdicional']    = $row['DesAdicional'];
    $ped[$i]['OtrosDescuentos']    = $row['OtrosDescuentos'];
    $ped[$i]['NoNota']    = $row['NoNota'];
    $ped[$i]['ValNota']    = $row['ValNota'];
    $ped[$i]['ValNeto']    = $row['ValNeto'];
    $ped[$i]['DiasPago']    = $row['DiasPago'];
    $ped[$i]['TiempoPago']    = $row['TiempoPago'];
    $ped[$i]['Habilitado']    = $row['Habilitado'];
    $ped[$i]['Cliente']    = $row['Cliente'];
    $ped[$i]['cod']    = $row['cod'];
    $ped[$i]['ValAntesIva']    = $row['ValAntesIva'];
    $ped[$i]['Saldo']    = $row['Saldo'];
    $ped[$i]['VtoFecha']    = $row['VtoFecha'];
    $ped[$i]['NIT']    = $row['NIT'];
    $i++;
  }
  echo json_encode($ped);
}
else
{
  echo mysqli_error($con);
}

?>