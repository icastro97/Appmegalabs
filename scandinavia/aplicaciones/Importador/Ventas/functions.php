<?php
//Ventas
// la tabla en la que se sube informacion temporal
function insertarDatos($DataAreaID, $RPT_CatCod, $RPT_Step, $RPT_Fecha, $PedCreEl, $PedCrePor, $PedModEl, $PedModPor, $PedNro, $PedCod, $PedOperaCod, $PedModoCod, $PedStatusCod, $PedVtaRespCod, $PagoCondicion, $PagoForma, $PrecioGrupo, $OCExt_Origen, $OCExt_CliCod, $OCExt_NroLin, $EmplCod, $EmplDes, $EmplDimDeparCod, $EmplDimCCtosCod, $EmplDimPropoCod, $LinCreEl, $LinCrePor, $LinModEl, $LinModPor, $LinNro, $CliFacCod, $CliEntCod, $CliEntPais, $CliEntCond, $CliEntModo, $CliEnvFecha, $CliEntFecha, $CliEnvFechaConf, $CliEntFechaConf, $CliEntLTime, $Ruta, $CliEntFinCod, $ArtCod, $InvAlmacen, $InvPalletNro, $InvLoteNro, $InvDUA, $InvBultoNro, $InvLoteVto, $InvLoteVtoMM, $InvLoteVtoMMRes, $FacNro, $FacFecha, $FacFechaHs, $FacFechaVto, $FacEntFecha, $FacEntFechaVto, $FacMonOrig, $FacMonLoc, $FacMonSec, $Un, $CantVta, $CantBon, $CantVta_Bon, $VtaBMonLoc, $ImpMonLoc, $DtoCMonLoc, $BoniMonLoc, $VtaNMonLoc, $VtaBMonSec, $ImpMonSec, $DtoCMonSec, $BoniMonSec, $VtaNMonSec, $PedDes, $PedGruCod, $PedGruDes, $PedTipoCod, $PedTipoDes, $PedOperaDes, $PedModoDes, $PedStatusDes, $PedVtaRespDes, $PedVtaCCtoDes, $PedVtaCCtoRes, $CliFacDes, $CliFacGrupo, $CliFacDimCanal, $CliFacPais, $CliFacMail, $CliFacZona, $CliEntDes, $CliEntGrupo, $CliEntDimCanal, $CliEntCarteraCod, $CliEntMail, $CliEntZona, $CliEntFinDes, $CliEntFinGrupo, $CliEntFinDimCanal, $CliEntFinPais, $CliEntFinMail, $CliEntFinZona, $ArtDes, $ArtGrupoCod, $ArtGrupoDes, $ArtDimPropi, $ArtDimLinea, $ArtCarteraCod, $ArtOTC_MPH, $FacFecAA, $FacFecAM, $MMMov, $AAAct, $MMObj, $AAObj, $MMVig, $PreMonLoc, $PreMonSec, $GrupoClasificacion, $GrupoVentaComisionCod, $GrupoVentaComisionName, $CodRegion, $CliCadena, $SubSegmentId, $IdentificationNumber, $PreprintedRef_MPH, $DimEstadist)
{
        global $bd;
        $sql = "INSERT INTO reporteVentas(DataAreaID, RPT_CatCod, RPT_Step, RPT_Fecha, PedCreEl, PedCrePor, PedModEl, PedModPor, PedNro, PedCod, PedOperaCod, PedModoCod, PedStatusCod, PedVtaRespCod, PagoCondicion, PagoForma, PrecioGrupo, OCExt_Origen, OCExt_CliCod, OCExt_NroLin, EmplCod, EmplDes, EmplDimDeparCod, EmplDimCCtosCod, EmplDimPropoCod, LinCreEl, LinCrePor, LinModEl, LinModPor, LinNro, CliFacCod, CliEntCod, CliEntPais, CliEntCond, CliEntModo, CliEnvFecha, CliEntFecha, CliEnvFechaConf, CliEntFechaConf, CliEntLTime, Ruta, CliEntFinCod, ArtCod, InvAlmacen, InvPalletNro, InvLoteNro, InvDUA, InvBultoNro, InvLoteVto, InvLoteVtoMM, InvLoteVtoMMRes, FacNro, FacFecha, FacFechaHs, FacFechaVto, FacEntFecha, FacEntFechaVto, FacMonOrig, FacMonLoc, FacMonSec, Un, CantVta, CantBon, CantVta_Bon, VtaBMonLoc, ImpMonLoc, DtoCMonLoc, BoniMonLoc, VtaNMonLoc, VtaBMonSec, ImpMonSec, DtoCMonSec, BoniMonSec, VtaNMonSec, PedDes, PedGruCod, PedGruDes, PedTipoCod, PedTipoDes, PedOperaDes, PedModoDes, PedStatusDes, PedVtaRespDes, PedVtaCCtoDes, PedVtaCCtoRes, CliFacDes, CliFacGrupo, CliFacDimCanal, CliFacPais, CliFacMail, CliFacZona, CliEntDes, CliEntGrupo, CliEntDimCanal, CliEntCarteraCod, CliEntMail, CliEntZona, CliEntFinDes, CliEntFinGrupo, CliEntFinDimCanal, CliEntFinPais, CliEntFinMail, CliEntFinZona, ArtDes, ArtGrupoCod, ArtGrupoDes, ArtDimPropi, ArtDimLinea, ArtCarteraCod, ArtOTC_MPH, FacFecAA, FacFecAM, MMMov, AAAct, MMObj, AAObj, MMVig, PreMonLoc, PreMonSec, GrupoClasificacion, GrupoVentaComisionCod, GrupoVentaComisionName, CodRegion, CliCadena, SubSegmentId, IdentificationNumber, PreprintedRef_MPH, DimEstadist) VALUES ('$DataAreaID' , '$RPT_CatCod' , '$RPT_Step' , '$RPT_Fecha' , '$PedCreEl' , '$PedCrePor' , '$PedModEl' , '$PedModPor' , '$PedNro' , '$PedCod' , '$PedOperaCod' , '$PedModoCod' , '$PedStatusCod' , '$PedVtaRespCod' , '$PagoCondicion' , '$PagoForma' , '$PrecioGrupo' , '$OCExt_Origen' , '$OCExt_CliCod' , '$OCExt_NroLin' , '$EmplCod' , '$EmplDes' , '$EmplDimDeparCod' , '$EmplDimCCtosCod' , '$EmplDimPropoCod' , '$LinCreEl' , '$LinCrePor' , '$LinModEl' , '$LinModPor' , '$LinNro' , '$CliFacCod' , '$CliEntCod' , '$CliEntPais' , '$CliEntCond' , '$CliEntModo' , '$CliEnvFecha' , '$CliEntFecha' , '$CliEnvFechaConf' , '$CliEntFechaConf' , '$CliEntLTime' , '$Ruta' , '$CliEntFinCod' , '$ArtCod' , '$InvAlmacen' , '$InvPalletNro' , '$InvLoteNro' , '$InvDUA' , '$InvBultoNro' , '$InvLoteVto' , '$InvLoteVtoMM' , '$InvLoteVtoMMRes' , '$FacNro' , '$FacFecha' , '$FacFechaHs' , '$FacFechaVto' , '$FacEntFecha' , '$FacEntFechaVto' , '$FacMonOrig' , '$FacMonLoc' , '$FacMonSec' , '$Un' , '$CantVta' , '$CantBon' , '$CantVta_Bon' , '$VtaBMonLoc' , '$ImpMonLoc' , '$DtoCMonLoc' , '$BoniMonLoc' , '$VtaNMonLoc' , '$VtaBMonSec' , '$ImpMonSec' , '$DtoCMonSec' , '$BoniMonSec' , '$VtaNMonSec' , '$PedDes' , '$PedGruCod' , '$PedGruDes' , '$PedTipoCod' , '$PedTipoDes' , '$PedOperaDes' , '$PedModoDes' , '$PedStatusDes' , '$PedVtaRespDes' , '$PedVtaCCtoDes' , '$PedVtaCCtoRes' , '$CliFacDes' , '$CliFacGrupo' , '$CliFacDimCanal' , '$CliFacPais' , '$CliFacMail' , '$CliFacZona' , '$CliEntDes' , '$CliEntGrupo' , '$CliEntDimCanal' , '$CliEntCarteraCod' , '$CliEntMail' , '$CliEntZona' , '$CliEntFinDes' , '$CliEntFinGrupo' , '$CliEntFinDimCanal' , '$CliEntFinPais' , '$CliEntFinMail' , '$CliEntFinZona' , '$ArtDes' , '$ArtGrupoCod' , '$ArtGrupoDes' , '$ArtDimPropi' , '$ArtDimLinea' , '$ArtCarteraCod' , '$ArtOTC_MPH' , '$FacFecAA' , '$FacFecAM' , '$MMMov' , '$AAAct' , '$MMObj' , '$AAObj' , '$MMVig' , '$PreMonLoc' , '$PreMonSec' , '$GrupoClasificacion' , '$GrupoVentaComisionCod' , '$GrupoVentaComisionName' , '$CodRegion' , '$CliCadena' , '$SubSegmentId' , '$IdentificationNumber' , '$PreprintedRef_MPH' , '$DimEstadist')";
        $ejecutar = mysqli_query($bd,$sql);
        return $ejecutar;
    
    
}

function limpiarDatos()
{
    global $bd;
    $sql = "truncate table reporteVentas";
    $ejecutar = mysqli_query($bd,$sql);
    return $ejecutar;
    
}


function datosArchivo($ruta,$ArchivoGuardado, $fechaActual, $userid )
{
    global $bd;
    $sql="INSERT INTO tbl_archivos(ruta, nombre_Archivo,fechaActual, usuario) VALUES('$ruta','$ArchivoGuardado', '$fechaActual', $userid )";
    mysqli_query($bd, $sql);
    
    
}


//Trae los datos de la tabla reporteVentas
// La tabla fija 
function insertarTablaFija()
{
        global $bd;
        $sql = "INSERT INTO reporteMesesVenta ( `DataAreaID`, `RPT_CatCod`, `RPT_Step`, `RPT_Fecha`, `PedCreEl`, `PedCrePor`, `PedModEl`, `PedModPor`, `PedNro`, `PedCod`, `PedOperaCod`, `PedModoCod`, `PedStatusCod`, `PedVtaRespCod`, `PagoCondicion`, `PagoForma`, `PrecioGrupo`, `OCExt_Origen`, `OCExt_CliCod`, `OCExt_NroLin`, `EmplCod`, `EmplDes`, `EmplDimDeparCod`, `EmplDimCCtosCod`, `EmplDimPropoCod`, `LinCreEl`, `LinCrePor`, `LinModEl`, `LinModPor`, `LinNro`, `CliFacCod`, `CliEntCod`, `CliEntPais`, `CliEntCond`, `CliEntModo`, `CliEnvFecha`, `CliEntFecha`, `CliEnvFechaConf`, `CliEntFechaConf`, `CliEntLTime`, `Ruta`, `CliEntFinCod`, `ArtCod`, `InvAlmacen`, `InvPalletNro`, `InvLoteNro`, `InvDUA`, `InvBultoNro`, `InvLoteVto`, `InvLoteVtoMM`, `InvLoteVtoMMRes`, `FacNro`, `FacFecha`, `FacFechaHs`, `FacFechaVto`, `FacEntFecha`, `FacEntFechaVto`, `FacMonOrig`, `FacMonLoc`, `FacMonSec`, `Un`, `CantVta`, `CantBon`, `CantVta_Bon`, `VtaBMonLoc`, `ImpMonLoc`, `DtoCMonLoc`, `BoniMonLoc`, `VtaNMonLoc`, `VtaBMonSec`, `ImpMonSec`, `DtoCMonSec`, `BoniMonSec`, `VtaNMonSec`, `PedDes`, `PedGruCod`, `PedGruDes`, `PedTipoCod`, `PedTipoDes`, `PedOperaDes`, `PedModoDes`, `PedStatusDes`, `PedVtaRespDes`, `PedVtaCCtoDes`, `PedVtaCCtoRes`, `CliFacDes`, `CliFacGrupo`, `CliFacDimCanal`, `CliFacPais`, `CliFacMail`, `CliFacZona`, `CliEntDes`, `CliEntGrupo`, `CliEntDimCanal`, `CliEntCarteraCod`, `CliEntMail`, `CliEntZona`, `CliEntFinDes`, `CliEntFinGrupo`, `CliEntFinDimCanal`, `CliEntFinPais`, `CliEntFinMail`, `CliEntFinZona`, `ArtDes`, `ArtGrupoCod`, `ArtGrupoDes`, `ArtDimPropi`, `ArtDimLinea`, `ArtCarteraCod`, `ArtOTC_MPH`, `FacFecAA`, `FacFecAM`, `MMMov`, `AAAct`, `MMObj`, `AAObj`, `MMVig`, `PreMonLoc`, `PreMonSec`, `GrupoClasificacion`, `GrupoVentaComisionCod`, `GrupoVentaComisionName`, `CodRegion`, `CliCadena`, `SubSegmentId`, `IdentificationNumber`, `PreprintedRef_MPH`, `DimEstadist`)
SELECT `DataAreaID`, `RPT_CatCod`, `RPT_Step`, `RPT_Fecha`, `PedCreEl`, `PedCrePor`, `PedModEl`, `PedModPor`, `PedNro`, `PedCod`, `PedOperaCod`, `PedModoCod`, `PedStatusCod`, `PedVtaRespCod`, `PagoCondicion`, `PagoForma`, `PrecioGrupo`, `OCExt_Origen`, `OCExt_CliCod`, `OCExt_NroLin`, `EmplCod`, `EmplDes`, `EmplDimDeparCod`, `EmplDimCCtosCod`, `EmplDimPropoCod`, `LinCreEl`, `LinCrePor`, `LinModEl`, `LinModPor`, `LinNro`, `CliFacCod`, `CliEntCod`, `CliEntPais`, `CliEntCond`, `CliEntModo`, `CliEnvFecha`, `CliEntFecha`, `CliEnvFechaConf`, `CliEntFechaConf`, `CliEntLTime`, `Ruta`, `CliEntFinCod`, `ArtCod`, `InvAlmacen`, `InvPalletNro`, `InvLoteNro`, `InvDUA`, `InvBultoNro`, `InvLoteVto`, `InvLoteVtoMM`, `InvLoteVtoMMRes`, `FacNro`, `FacFecha`, `FacFechaHs`, `FacFechaVto`, `FacEntFecha`, `FacEntFechaVto`, `FacMonOrig`, `FacMonLoc`, `FacMonSec`, `Un`, `CantVta`, `CantBon`, `CantVta_Bon`, `VtaBMonLoc`, `ImpMonLoc`, `DtoCMonLoc`, `BoniMonLoc`, `VtaNMonLoc`, `VtaBMonSec`, `ImpMonSec`, `DtoCMonSec`, `BoniMonSec`, `VtaNMonSec`, `PedDes`, `PedGruCod`, `PedGruDes`, `PedTipoCod`, `PedTipoDes`, `PedOperaDes`, `PedModoDes`, `PedStatusDes`, `PedVtaRespDes`, `PedVtaCCtoDes`, `PedVtaCCtoRes`, `CliFacDes`, `CliFacGrupo`, `CliFacDimCanal`, `CliFacPais`, `CliFacMail`, `CliFacZona`, `CliEntDes`, `CliEntGrupo`, `CliEntDimCanal`, `CliEntCarteraCod`, `CliEntMail`, `CliEntZona`, `CliEntFinDes`, `CliEntFinGrupo`, `CliEntFinDimCanal`, `CliEntFinPais`, `CliEntFinMail`, `CliEntFinZona`, `ArtDes`, `ArtGrupoCod`, `ArtGrupoDes`, `ArtDimPropi`, `ArtDimLinea`, `ArtCarteraCod`, `ArtOTC_MPH`, `FacFecAA`, `FacFecAM`, `MMMov`, `AAAct`, `MMObj`, `AAObj`, `MMVig`, `PreMonLoc`, `PreMonSec`, `GrupoClasificacion`, `GrupoVentaComisionCod`, `GrupoVentaComisionName`, `CodRegion`, `CliCadena`, `SubSegmentId`, `IdentificationNumber`, `PreprintedRef_MPH`, `DimEstadist`  FROM reporteVentas;";
        $result = mysqli_query($bd,$sql);
         if($result)
        {
            
            echo  "<div class='alert alert-success' role='alert'>Se realizo el cierre en correctamente!</div>";
        }
        else
        {
            echo  "<div class='alert alert-danger' role='alert'>¡OH! Ocurrio un error realizar el cierre!</div>";
        }
              
}


?>