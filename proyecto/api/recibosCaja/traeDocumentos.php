<?php
/**
 * Retorna lista de clientes.
 */
require '../precios/database.php';
$nit = $_GET['nit'];
$ped = [];
$sql = "SELECT `Cliente_Especial`, `Tipo`, `DocOrig`, `Documento`, `Cliente`, `cod`, `OpeFecha`, `VtoFecha`,
`Valor_original`, `Abono`, `Saldo`, `ValAntesIva`, `Descuento_pp`, `Zona`, `Ciudad`, `Canal`, `Fechas_Vencimiento_segun_convenios`,
`Fecha_Vencimiento_Plazo_Factura`, `Presupuesto_con_fechas_convenio`, `Presupuesto_con_fecha_factura`, `Presupuesto_Tesoreria`, `Presupuesto`, `Tipo3`, `Estado`,
`En_presupuesto`, `Canal2`, `NIT`, `razonsocial`, `condicionpago`, `cuentacliente`, `id`, `nombres`, `Impositiva`, `PPago`, `DAdicional`, `OtrosDescuentos`, `ValNota`, `ValNeto`
FROM `vw_basec_vendedores` WHERE NIT = '$nit' AND tipo <> 'AN'";

//var_dump($sql);
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $ped[$i]['Cliente_Especial']    = $row['Cliente_Especial'];
    $ped[$i]['Tipo']    = $row['Tipo'];
    $ped[$i]['DocOrig']    = $row['DocOrig'];
    $ped[$i]['Documento']    = $row['Documento'];
    $ped[$i]['Cliente']    = $row['Cliente'];
    $ped[$i]['cod']    = $row['cod'];
    $ped[$i]['OpeFecha']    = $row['OpeFecha'];
    $ped[$i]['VtoFecha']    = $row['VtoFecha'];
    $ped[$i]['Valor_original']    = $row['Valor_original'];
    $ped[$i]['Abono']    = $row['Abono'];
    $ped[$i]['Saldo']    = $row['Saldo'];
    $ped[$i]['ValAntesIva']    = $row['ValAntesIva'];
    $ped[$i]['Descuento_pp']    = $row['Descuento_pp'];
    $ped[$i]['Zona']    = $row['Zona'];
    $ped[$i]['Ciudad']    = $row['Ciudad'];
    $ped[$i]['Canal']    = $row['Canal'];
    $ped[$i]['Fechas_Vencimiento_segun_convenios']    = $row['Fechas_Vencimiento_segun_convenios'];
    $ped[$i]['Fecha_Vencimiento_Plazo_Factura']    = $row['Fecha_Vencimiento_Plazo_Factura'];
    $ped[$i]['Presupuesto_con_fechas_convenio']    = $row['Presupuesto_con_fechas_convenio'];
    $ped[$i]['Presupuesto_con_fecha_factura']    = $row['Presupuesto_con_fecha_factura'];
    $ped[$i]['Presupuesto_Tesoreria']    = $row['Presupuesto_Tesoreria'];
    $ped[$i]['Presupuesto']    = $row['Presupuesto'];
    $ped[$i]['Tipo3']    = $row['Tipo3'];
    $ped[$i]['Estado']    = $row['Estado'];
    $ped[$i]['En_presupuesto']    = $row['En_presupuesto'];
    $ped[$i]['Canal2']    = $row['Canal2'];
    $ped[$i]['NIT']    = $row['NIT'];
    $ped[$i]['razonsocial']    = $row['razonsocial'];
    $ped[$i]['condicionpago']    = $row['condicionpago'];
    $ped[$i]['cuentacliente']    = $row['cuentacliente'];
    $ped[$i]['id']    = $row['id'];
    $ped[$i]['nombres']    = $row['nombres'];
    $ped[$i]['Impositiva']    = $row['Impositiva'];
    $ped[$i]['PPago']    = $row['PPago'];
    $ped[$i]['DAdicional']    = $row['DAdicional'];
    $ped[$i]['OtrosDescuentos']    = $row['OtrosDescuentos'];
    $ped[$i]['ValNota']    = $row['ValNota'];
    $ped[$i]['ValNeto']    = $row['ValNeto'];
    
    $i++;
  }
  echo json_encode($ped);
}
else
{
  echo mysqli_error($con);
}

?>