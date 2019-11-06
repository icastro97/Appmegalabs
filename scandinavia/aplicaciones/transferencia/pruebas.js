$(document).ready(function() {
    $('#pruebass').hide();
    $('#pruebass').focus();
    $('#pruebass').val('');
    $('#cambio').hide();

});

 function compara(){
    let prueba =   $('#pruebass').val();
    let codFactura = prueba.indexOf('FecFacÑ ');
    let fechaA =  prueba.substr(+codFactura + 8, 4);
    let fechaB = prueba.substr(+codFactura + 12,2);
    let fechaC = prueba.substr(+codFactura + 14,2);
    let resFecha = fechaC + '/' + fechaB + '/' + fechaA;
    let cadenaIni = prueba.indexOf('ValFacÑ ');///limitar con indexOf de titulo 1 a titulo 2
    let cadenaFin = prueba.indexOf('.00ValIvaÑ ');
    let cadenaIvaFin = prueba.indexOf('.00ValOtroImÑ ');
    let  nit = prueba.indexOf('NitFacÑ ');
    let CUFE = prueba.indexOf('CUFEÑ ');
    
//operaciones
    let comparar = prueba.substr(+nit + 17, 1)
    let diferencia =  (+cadenaIni + 8 - +cadenaFin) * -1;
    let IVA = (+cadenaFin + 8 - +cadenaIvaFin) * -1;

    
     if(comparar == "D"){
        $('#nit1').val(prueba.substr(+nit + 8 ,9));
    }
    else{
        $('#nit1').val(prueba.substr(+nit + 8,9) +'-'+ prueba.substr(+nit + 17,1));
    }
    let valor = CUFE;
    
    $('#cufe').val(prueba.substr(+CUFE + 6, 100));
    $('#dateArrival1').val(resFecha);
    $('#factura1').val(prueba.substr(7,+codFactura - 7));
    $('#valor1').val(prueba.substr(+cadenaIni + 8, diferencia));
    $('#valor2').val(prueba.substr(+cadenaFin + 11 , +IVA - 3 ));

 }
 
 function llenaNombre(){
     let valor = $('#nit1').val();
    $.ajax({
    url:'traeProveedor.php',
    type: 'POST',
    data: {valor},
    success: function (response) 
    {
        $('#establecimiento1').val(response);
        
    }
})
 }
 
 function esconde(){
    let opcion = $('#opciones').val();
    if(opcion == 'ClienteF' || opcion == 'Fisica' || opcion == 'Cobro' || opcion == 'Importacion'){
        $('#pruebass').hide();
        $('#cambio').show();
    }
    else if(opcion == 'ClienteE' || opcion == 'Electronica') {
    $('#pruebass').show();
    $('#cambio').hide();
    $('#cambio').val('NO');
    $('#pruebass').focus();
    }
    else{
    $('#pruebass').hide();
    $('#cambio').hide();
    }
 }
 function pruebas(){
    let cadenaS = $('#pruebass').val();
    let cadenaTr = cadenaS.trim();
    let numeroFact = cadenaTr.indexOf('NumFacÑ');
    let fechaFactS = cadenaTr.indexOf('FecFacÑ');
    let nit = cadenaTr.indexOf('NitFacÑ');
    let mes = cadenaTr.substr(+fechaFactS + 12 , 2);
    let dia = cadenaTr.substr(+fechaFactS + 14, 2);
    let añoP = cadenaTr.substr(+fechaFactS + 8  , 4);
    let muestraNit = cadenaTr.substr(nit , 8);
    let numeroFactura = cadenaTr.substr(+numeroFact + 7 , +fechaFactS -7);//factura
    let fechaFact = dia + "/" + mes + "/" + añoP;//fecha ya parseada
    console.log("NIT" + muestraNit);
    
 }




