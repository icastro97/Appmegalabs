 $(document).ready(function() {
     
        
        $('#alerta2').hide();
        $('#alerta3').hide();
        $('#boton').attr("disabled", true);
        $('#boton').hide();
        $('#codigo').hide();
        $('#code1').hide();
        $('#as').hide();
        prueba();
        $('#alertaMala').hide();
        $('#fecha').hide();
        $('#fecha1').hide(); 
 });
 
 function prueba()
 {
 
        	   let nit =  $('#nit').val();
        	   $('#nitEscondido').val(nit);
        	   let correo = $('#correo').val();
        	   let codigo = $('#codigo').val();
        	    $.ajax({
        			url:'busqueda.php',
        			dataType: 'json',
        			type:'POST',
        			data:{nit, correo},
        			success: function (e) 
        			{
                       
                        
                      
                           if(e.length !== 0)
                           {
                                 for(var i = 0; i < e.length; i++){
                                   let nit1 = e[i]['nit'];
                                   let correo1 = e[i]['correo'];
                                if(nit == nit1 && correo == correo1)
                                {
                                    
                                    $('#alerta2').hide();
                                    $('#alerta3').hide();
                                    
                                    $.ajax
                                    ({
                                        url:'comparacion.php',
                            			type:'POST',
                            			data:{nit, correo},
                            			success:function(response)
                            			{
                            			    let json = JSON.parse(response);
                            			    for (var i = 0; i < json.length; i++) 
                            			    {
                            			        
                                             let codigoAxapta = json[i]['codigo'];
                                             $('#Axapta').val(codigoAxapta);
                                              $.ajax({
                                                 url:'envioCorreo.php',
                                                 data:{codigoAxapta, correo1, nit1},
                                                 type:'POST',
                                                 success:function(response)
                                                 {
                                                    $('#valida').hide();
                                                    $('#alerta1').hide();
                                                    $('#alerta2').hide();
                                                    $('#alerta3').hide();
                                                    
                                                    
                                                     if(response == "ok ")
                                                     {
                                                         $('#nit').attr("disabled", true);
                                                        $('#correo').attr("disabled", true);
                                                        $('#boton').attr("disabled", true);
                                                        $('#boton').hide();
                                                        $('#as').show();
                                                        $('#codigo').show();
                                                        $('#code1').show();
                                                        $('#fecha').show(); 
                                                        $('#fecha1').show();
                                                        if(nit == nit1 && correo == correo1)
                                                        {
                                                            if(codigo.length >0)
                                                             {
                                                                if(codigo == codigoAxapta)
                                                                {
                                                                    
                                                                    validarCodigo();
                                                                }
                                                                else
                                                                {
                                                                    
                                                                    //console.log("no habilitado");
                                                                }
                                                             }
                                                             else
                                                             {
                                                                 swal ( "Información!" ,  "Se realizó el envío del codigo al correo electronico." ,  "success");	
                                                                 //console.log("no hay nada para comparar");
                                                             }
                                                        }
                                                        else
                                                        {
                                                            console.log("deshabilitado");
                                                            $('#boton').attr("disabled", true);
                                                        }
                                                        
                                                     }
                                                     else
                                                     {
                                                           $('#boton').hide();
                                                            $('#codigo').hide();
                                                            $('#code1').hide();
                                                     }
                                                 }
                                                 
                                                 
                                              });
                                              
                                            }
                            			    
                            			}
                                        
                                    });
                                }
                                else
                                {
                                    $('#alerta1').hide();
                                    $('#alerta2').show();
                                    $('#alerta3').hide();
                                    $('#prueba').focus();
                                    $('#boton').attr("disabled", true);
                                }
                           }
                           }
                           else
                           {
                             $('#alerta1').hide();
                             $('#alerta2').hide();
                             $('#alerta3').show();
                             $('#prueba').focus();
                             $('#boton').attr("disabled", true);
                           }
                       
                        
                       
                        
        			}
        		});
	
 }
 
 function validarCodigo()
 {
    
       
      let codigoDespues = $('#codigo').val();
      let codigoDb = $('#Axapta').val();
                                                                         
     if(codigoDb == codigoDespues)
     {
         
         $('#as').hide(); 
         $('#boton').show(); 
         
          $('#boton').attr("disabled", false);
          $('#alertaMala').hide();
     }
     else
     {
         $('#boton').hide();  
         $('#as').show(); 
          $('#boton').attr("disabled", true);
          $('#alertaMala').show();
          $('#fecha').show(); 
          $('#fecha1').show();
     }
     
     
 }
 
 

