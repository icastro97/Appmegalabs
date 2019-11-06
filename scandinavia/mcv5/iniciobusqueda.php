
<script type="text/javascript" src="../assets/js/jquery-1.9.1.min.js"></script>
<script>


$(document).ready(function() {
    $("#resultadoBusqueda").html('<p>Sin Datos de Busqueda Actualmente</p>');
});

function buscar() {
    var textoBusqueda = $("input#busqueda").val();
	var tablaBusqueda = $('input:radio[name=table]:checked').val()

    if (textoBusqueda != "") {
        $.post("buscar.php", {valorBusqueda: textoBusqueda, tbus:tablaBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
        }); 
    } else { 
       $("#resultadoBusqueda").html('<p>Sin Datos de Busqueda Actualmente</p>');
	};
};
</script>
<h3><i class="fa fa-search"></i>.:: Busquedas ::. </h3> 
  <form accept-charset="utf-8" method="POST">
    <table width="50%" border="0" class="table table-striped" >
    <thead>
      <tr>
        <td  align="left" valign="middle">&nbsp;</td>
        <td  align="left" valign="middle"><div align="left">
          <p>
            <label>
              <input name="table" type="radio" id="TablaaBuscar_0" value="vwx2_contacts" checked="checked" />
              Clientes</label>
            <br />
            <label>
              <input type="radio" name="table" value="vw_llamadas" id="TablaaBuscar_1" />
              Llamadas</label>
            <br />
            <label>
              <input type="radio" name="table" value="seguimientos" id="TablaaBuscar_2" />
              Visitas</label>
            <br />
            <br />
          Digite Nombres o Identificacion:<br>
          <input name="busqueda" type="text" class="form-contro" id="busqueda" placeholder="" autocomplete="off" onKeyUp="buscar();" value="" size="60" maxlength="60" />
        </p>
        </div></td>
      </tr>
      </thead>
    </table>    
    </form>
</div>
 <div class="row">
		<div class="col-sm-12">
<table width="50%" border="0" class="table table-striped">
<thead>
<tbody id="userData">
  <tr>
    <td width="3%">&nbsp;</tf>
    <td width="94%"><div  id="resultadoBusqueda"></div></tf>
  </tr>
  </tbody>
</thead>  
</table>
</div>
</div>
