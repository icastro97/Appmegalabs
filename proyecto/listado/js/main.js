$(buscarDatos());



function buscarDatos(consulta) 
{
    $.ajax({
        url:'busqueda.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta:consulta},
    })
    .done(function(respuesta) {
        $('#datos').html(respuesta);
    })
    .fail(function () {
        console.log("error");
    })
   
    
}

$(document).on('keyup', '#caja', function () {
    var valor = $(this).val();
    if(valor != "")
    {
        buscarDatos(valor);
    }
    else
    {
        buscarDatos();
    }

    
})