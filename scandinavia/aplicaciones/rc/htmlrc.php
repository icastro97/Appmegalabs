<?php 
require_once('montoescrito.php'); 
$id=1;
if(isset($id_byinclude)){
	$id=$id_byinclude;
}

$parametro = $id; //$_REQUEST['id'];
$status = FALSE;

//start session
//session_start();

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from empresa
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar

//cabeza de recibo
$conditionscabeza['where'] = array('DocumentID '=> $parametro,); 
$cabeza = $db->getRows('vw_recibos',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('DocumentID'=> $parametro,); 
$detalle = $db->getRows('vw_recibosdetalle',$conditionsdetalle); //ojo se pone tabla a consultar
?>
	
<table width="100%" border="0">
	  <tr>
	    <td align="center">&nbsp;</td>
	    <td align="center"><h3>Recibo de Caja No: RC<?php echo $detalle[0]['DocumentID']; ?></h3></td>
	    <td align="center" valign="top">&nbsp;</td>
      </tr>
	  <tr>
	    <td width="26%" align="center"><img src="/scandinavia/assets/img/logobig.png" alt="" width="154" height="90" /></td>
	    <td width="50%" align="center"><?php echo $empresa[0]['resolucion']; ?></td>
	    <td width="24%" align="center" valign="top"><img src="/scandinavia/assets/img/icontec.png" alt="" width="108" height="88" /></td>
      </tr>
</table>	

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="20%">Recibimos de:</td>
                  <td width="20%"><?php echo $cabeza[0]['razonsocial']; ?></td>
                  <td width="4%">&nbsp;</td>
                  <td width="36%">Descuento Financiero:</td>
                  <td width="20%"><?php if($cabeza[0]['Descuento1']== "1")  echo "Si: " . $cabeza[0]['ValorDes1'] ; else  echo "No"; ?></td>
  </tr>
                <tr>
                  <td width="20%">Fecha de Pago:</td>
                  <td width="20%"><?php echo $cabeza[0]['Fecha']; ?></td>
                  <td width="4%">&nbsp;</td>
                  <td width="36%">Descuento Adicional por Negociación:</td>
                  <td width="20%"><?php if($cabeza[0]['Descuento2']== "1")  echo "Si: " . $cabeza[0]['ValorDes2']; else  echo "No"; ?></td>
                </tr>
                <tr>
                  <td width="20%">Codigo Cartera:</td>
                  <td width="20%"><?php echo $cabeza[0]['Cliente']; ?></td>
                  <td width="4%">&nbsp;</td>
                  <td width="36%">% Descuento Adicional:</td>
                  <td width="20%"><?php echo $cabeza[0]['ValorDes3']; ?></td>
                </tr>
                <tr>
                  <td width="20%">Banco:</td>
                  <td width="20%"><?php echo $cabeza[0]['descripcion']; ?></td>
                  <td width="4%">&nbsp;</td>
                  <td width="36%">&nbsp;</td>
                  <td width="20%">&nbsp;</td>
                </tr>
</table>
<br /><br />
<table width="100%" border="1" cellpadding="1"  cellspacing="0" >
              
                    <tr>                      
                        <th rowspan="2" valign="bottom"><div align="center"> Cod </div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Documento</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Emision</div></th>
                        <th rowspan="2" valign="bottom" ><div align="center">V/r Ant   IVA</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Ret<br />
                        Imp</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Desc <br />
                        P.Pago</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Desc <br />
                        Adicional</div></th>
                        <th rowspan="2" valign="bottom"><div align="center">Otro <br />
                        Descuento</div></th>
                        <th colspan="2" align="center"><div align="center">Descuentos Cliente</div></th>                       
                        <th rowspan="2"><div align="center">Neto</div></th>
                    </tr>
                    <tr>
                      <th><div align="center">No Nota</div></th>
                      <th><div align="center">Valor</div></th>
  </tr>

               
                    <?php $sumaneto = 0; $sumaretimpo = 0; $sumdespago = 0; $sumdesadi=0; $sumotros =0; $sumvalnota= 0;
					if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
                    <tr>
                       
                        <td><div align="center"><?php echo $user['cod']; ?> </div></td>
                        <td><?php echo $user['Documento']; ?></td>
                        <td><div align="center"><?php echo $user['OpeFecha']; ?></div></td>
                        <td align="right">$<?=number_format($user['ValorDocumento'], 0,".",",") ?></td>
                        <td align="right">$<?=number_format($user['RetImpositiva'], 0,".",",") ?></td>
                       
                        <td align="right">$<?=number_format($user['DesPPago'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['DesAdicional'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['OtrosDescuentos'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['NoNota'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['ValNota'], 0,".",","); ?></td>
                        <td align="right">$<?=number_format($user['ValNeto'], 0,".",",");?></td>
                        <?php $sumaneto = $sumaneto + $user['ValNeto'];
						      $sumaretimpo = $sumaretimpo + $user['RetImpositiva'];
							  $sumdespago  = $sumdespago  + $user['DesPPago'];
							  $sumdesadi   = $sumdesadi   + $user['DesAdicional'];
							  $sumotros    = $sumotros    + $user['OtrosDescuentos'];
							  $sumvalnota  = $sumvalnota  + $user['ValNota'];?>
                    </tr>
                    
                   
                    <?php endforeach; else: ?>
                     
                    <tr><td colspan="5">No existen documentos para mostrar......</td></tr>
                    <?php endif; ?>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="2">Totales --</td>
                      <td align="right">&nbsp;</td>
                      <td align="right">$<?=number_format($sumaretimpo, 0,".",",");?></td>
                      <td align="right">$<?=number_format($sumdespago, 0,".",",");?></td>
                      <td align="right">$<?=number_format($sumdesadi, 0,".",",");?></td>
                      <td align="right">$<?=number_format($sumotros, 0,".",",");?></td>
                      <td align="right">&nbsp;</td>
                      <td align="right">$<?=number_format($sumvalnota, 0,".",",");?></td>
                      <td align="right">&nbsp;</td>
                    </tr>
  <br />
<br />
               
            </table>
            
            <br />
            <br />
            <table width="100%" border="0" cellpadding="1"  cellspacing="0" >
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2">&nbsp;</td>
                 <td align="right">&nbsp;</td>
                 <td align="right">____________</td>
                 <td align="right">____________</td>
                 <td align="right">____________</td>
                 <td align="right">____________</td>
                 <td align="right">&nbsp;</td>
                 <td align="right">____________</td>
                 <td align="right">____________</td>
               </tr>
               <tr>
                      <td>&nbsp;</td>
                      <td colspan="2">Totales --</td>
                      <td align="right">&nbsp;</td>
                      <td align="right">$<?=number_format($sumaretimpo, 0,".",",");?></td>
                      <td align="right">$<?=number_format($sumdespago, 0,".",",");?></td>
                      <td align="right">$<?=number_format($sumdesadi, 0,".",",");?></td>
                      <td align="right">$<?=number_format($sumotros, 0,".",",");?></td>
                      <td align="right">&nbsp;</td>
                      <td align="right">$<?=number_format($sumvalnota, 0,".",",");?></td>
                      <td align="right">$<?=number_format($sumaneto, 0,".",",");?></td>
                    </tr>
              
            </table>
            <br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="56%" colspan="3">VALOR NETO: <em><B>
    <?php  echo strtoupper(num2letras($sumaneto));?></B></em></td>
    <td width="34%">&nbsp;</td>
    <td width="10%" align="right">&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="48%" rowspan="3" valign="top">OBSERVACIONES VENDEDOR: <?php echo $cabeza[0]['Observaciones']; ?></td>
    <td width="52%" colspan="3">VIA POR LA QUE REALIZÓ EL PAGO:<?php echo strtoupper($cabeza[0]['TipoPago']); ?></td> 
  </tr>
  <tr>
    <td>CHEQUE NO. <?php echo $cabeza[0]['Cheque']; ?> <br />      <br /></td>
    <td>VALOR: $<?php echo number_format($cabeza[0]['Valor']); ?></td>
   
  </tr>
  <tr>
    <td colspan="2">FECHA CHEQUE: <?php echo $cabeza[0]['FechaCheque']; ?></td>
  </tr>
  <tr>
    <td valign="top">OBSERVACIONES CARTERA:<?php echo $cabeza[0]['ObservacionesCartera']; ?></td>
    <td colspan="3">VENDEDOR QUE LEGALIZÓ EL PAGO: <?php echo strtoupper($cabeza[0]['full_name']); ?> <br /></td>
  </tr>
</table>
<p align="center">NOTA: SCANDINAVIA PHARMA SE RESERVA EL DERECHO DE APROBACION Y VALIDACIÓN DEL PRESENTE RECIBO<br />
  Scandinavia Pharma Ltda. 800.133.807-1 / Calle 106 No 18A-45 / Tel: (+571) 6461700 e-mail scandinavia@scandinavia.com.co<br />
  www.scandinavia.com.co / Bogotá - Colombia
  <br />
  <br />
</p>
      

                  



           
           