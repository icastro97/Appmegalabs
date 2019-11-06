<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require '../../../scandinavia/seguridad/config.php';
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$usr = $_GET['user'];
$user = $_SESSION['user_id'];

$products = [];
$sql = "SELECT `id_transferencia`, `tipoFactura`, `radicado`, `fecfact`, `factura`, `nit`,
`establecimiento`, `ciudad`, `cinversion`, `tipogasto`, `concepto`, `descripcion`, `moneda`,
`valorSinImpuesto`, `valorImpuesto`, `valorIca`, `tipo`, `asistencia`, `tipoCodigo`, `fecha_registro`,
T2.full_name AS aprobador, `estado`, `user_id`, `descrip`, `novedad`, `observacion`, `observacionContabilidad`,
`descripC`, `novedadC`, `observacionG`, `pago_especial`, `facturaDeposito`, `inv_comercial`, `novedadFacturaDespues`,
`aprContabilidad`, `proceContabilidad`, `tipoApr`, `observacionAc`, `observacionRevision`, `ultimoCambioEstado`, `corregido`,
`observacionTesoreria`, `recibido`, `observacionCartera`, `fechaCartera`
FROM transferencia_val T1 
INNER JOIN system_users T2 on T1.aprobador = T2.u_userid where T1.aprobador = '$user'";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id_transferencia']    = $row['id_transferencia'];
    $products[$i]['tipoFactura']    = $row['tipoFactura'];
    $products[$i]['radicado']    = $row['radicado'];
    $products[$i]['fecfact']    = $row['fecfact'];
    $products[$i]['factura']    = $row['factura'];
    $products[$i]['nit']    = $row['nit'];
    $products[$i]['fecha_registro']    = $row['fecha_registro'];
    $products[$i]['establecimiento'] = $row['establecimiento'];
    $products[$i]['ciudad']    = $row['ciudad'];
    $products[$i]['cinversion']    = $row['cinversion'];
    $products[$i]['tipogasto']    = $row['tipogasto'];
    $products[$i]['concepto']    = $row['concepto'];
    $products[$i]['descripcion'] = $row['descripcion'];
    $products[$i]['moneda']    = $row['moneda'];
    $products[$i]['valorSinImpuesto']    = $row['valorSinImpuesto'];
    $products[$i]['valorImpuesto']    = $row['valorImpuesto'];
    $products[$i]['valorIca']    = $row['valorIca'];
    $products[$i]['tipo']    = $row['tipo'];
    $products[$i]['asistencia']    = $row['asistencia'];
    $products[$i]['tipoCodigo']    = $row['tipoCodigo'];
    $products[$i]['aprobador']    = $row['aprobador'];
    $products[$i]['estado'] = $row['estado'];
    $products[$i]['user_id']    = $row['user_id'];
    $products[$i]['descrip']    = $row['descrip'];
    $products[$i]['novedad']    = $row['novedad'];
    $products[$i]['observacion']    = $row['observacion'];
    $products[$i]['observacionContabilidad']    = $row['observacionContabilidad'];
    $products[$i]['aprContabilidad']    = $row['aprContabilidad'];
    $products[$i]['proceContabilidad']    = $row['proceContabilidad'];
    $products[$i]['tipoApr']    = $row['tipoApr'];
    $products[$i]['observacionAc']    = $row['observacionAc'];
    $products[$i]['observacionRevision']    = $row['observacionRevision'];
    $products[$i]['ultimoCambioEstado']    = $row['ultimoCambioEstado'];
    $products[$i]['corregido']    = $row['corregido.'];
    $products[$i]['descripC']    = $row['descripC'];
    $products[$i]['novedadC']    = $row['novedadC'];
    $products[$i]['observacionG']    = $row['observacionG'];
    $products[$i]['pago_especial']    = $row['pago_especial'];
    $products[$i]['facturaDeposito']    = $row['facturaDeposito'];
    $products[$i]['inv_comercial']    = $row['inv_comercial'];
    $products[$i]['novedadFacturaDespues']    = $row['novedadFacturaDespues'];
    $products[$i]['observacionTesoreria']    = $row['observacionTesoreria'];
    $products[$i]['recibido']    = $row['recibido'];
    $products[$i]['observacionCartera']    = $row['observacionCartera'];
    $products[$i]['fechaCartera']    = $row['fechaCartera'];
    
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}

?>