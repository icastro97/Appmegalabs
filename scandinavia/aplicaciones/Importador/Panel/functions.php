<?php

function insertarDatos($Reporte_Cat,$Reporte_Des,$Reporte_Paso ,$Fecha ,$FechaHs ,$Area ,$Empresa ,$FecMMFin ,$FecMMIni ,$FecAA ,$FecAM ,$FecAAMov ,$FecMMMov ,$FecAAAct ,$FecMMAct ,$ArtCod ,$ArtDes ,$ArtTipo ,$ArtGruCod ,$ArtGruDes ,$ArtPropi ,$ArtLinea ,$ArtUn ,$ArtATera ,$InvSitio ,$InvAlmaCod ,$InvAlmaDes ,$InvAlmaTipo ,$InvLugar ,$InvBulto ,$InvDUA ,$InvPallet ,$LoteNro ,$LoteVto ,$LoteVtoMM ,$LoteVtoRes ,$SubLoteNro ,$SubLoteNroDCod ,$SubLoteNroDDes ,$TrnOrigen ,$WIP_OP ,$WIP_OP_ArtCod ,$WIP_OP_ArtDes ,$WIP_OP_Qty ,$WIP_Tipo ,$WIP_FechaFis ,$WIP_FechaFin ,$WIP_Des ,$WIP_MAT_Can ,$WIP_MAT_Val ,$WIP_MOD_HS ,$WIP_MOD_Val ,$WIP_IND_Val ,$QtyPhysical ,$QtyPhysicalWMS ,$QtyPhysicalTotal ,$ValPhysical ,$Control ,$LineasEnCeroSiNo ,$ArtCarteraCod ,$ArtSubMarcaCod ,$ArtLineaGru ,$ArtProcedencia)
{
    global $bd;
    $sql = "INSERT INTO panelSaldosAX(id_Reporte,Reporte_Cat,Reporte_Des,Reporte_Paso ,Fecha ,FechaHs ,Area ,Empresa ,FecMMFin ,FecMMIni ,FecAA ,FecAM ,FecAAMov ,FecMMMov ,FecAAAct ,FecMMAct ,ArtCod ,ArtDes ,ArtTipo ,ArtGruCod ,ArtGruDes ,ArtPropi ,ArtLinea ,ArtUn ,ArtATera ,InvSitio ,InvAlmaCod ,InvAlmaDes ,InvAlmaTipo ,InvLugar ,InvBulto ,InvDUA ,InvPallet ,LoteNro ,LoteVto ,LoteVtoMM ,LoteVtoRes ,SubLoteNro ,SubLoteNroDCod ,SubLoteNroDDes ,TrnOrigen ,WIP_OP ,WIP_OP_ArtCod ,WIP_OP_ArtDes ,WIP_OP_Qty ,WIP_Tipo ,WIP_FechaFis ,WIP_FechaFin ,WIP_Des ,WIP_MAT_Can ,WIP_MAT_Val ,WIP_MOD_HS ,WIP_MOD_Val ,WIP_IND_Val ,QtyPhysical ,QtyPhysicalWMS ,QtyPhysicalTotal ,ValPhysical ,Control ,LineasEnCeroSiNo ,ArtCarteraCod ,ArtSubMarcaCod ,ArtLineaGru ,ArtProcedencia) VALUES (null,'$Reporte_Cat','$Reporte_Des','$Reporte_Paso ','$Fecha ','$FechaHs ','$Area ','$Empresa ','$FecMMFin ','$FecMMIni ','$FecAA ','$FecAM ','$FecAAMov ','$FecMMMov ','$FecAAAct ','$FecMMAct ','$ArtCod ','$ArtDes ','$ArtTipo ','$ArtGruCod ','$ArtGruDes ','$ArtPropi ','$ArtLinea ','$ArtUn ','$ArtATera ','$InvSitio ','$InvAlmaCod ','$InvAlmaDes ','$InvAlmaTipo ','$InvLugar ','$InvBulto ','$InvDUA ','$InvPallet ','$LoteNro ','$LoteVto ','$LoteVtoMM ','$LoteVtoRes ','$SubLoteNro ','$SubLoteNroDCod ','$SubLoteNroDDes ','$TrnOrigen ','$WIP_OP ','$WIP_OP_ArtCod ','$WIP_OP_ArtDes ','$WIP_OP_Qty ','$WIP_Tipo ','$WIP_FechaFis ','$WIP_FechaFin ','$WIP_Des ','$WIP_MAT_Can ','$WIP_MAT_Val ','$WIP_MOD_HS ','$WIP_MOD_Val ','$WIP_IND_Val ','$QtyPhysical ','$QtyPhysicalWMS ','$QtyPhysicalTotal ','$ValPhysical ','$Control ','$LineasEnCeroSiNo ','$ArtCarteraCod ','$ArtSubMarcaCod ','$ArtLineaGru ','$ArtProcedencia')";
    $ejecutar = mysqli_query($bd,$sql);
    return $ejecutar;
}

function limpiarDatos()
{
    global $bd;
    $sql = "truncate table panelSaldosAX";
    $ejecutar = mysqli_query($bd,$sql);
    return $ejecutar;
    
}


function datosArchivo($ArchivoGuardado, $fechaActual, $userid )
{
    global $bd;
    $sql="INSERT INTO tbl_archivos(nombre_Archivo,fechaActual, usuario) VALUES('$ArchivoGuardado', '$fechaActual', $userid )";
    mysqli_query($bd, $sql);
    
    
}


?>