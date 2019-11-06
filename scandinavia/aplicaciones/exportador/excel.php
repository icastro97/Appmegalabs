<?php

include("../../mcv5/clases/DB.class.php");   
$opcion = $_REQUEST['opcion'];

$sql= "SELECT * FROM vw_comentarioform where opcion = '$opcion'";
$rs = mysqli_query($mysqli, $sql);
$listausuarios=array();
while ($row=mysqli_fetch_row($rs)){
	$item = array("opcion"     =>$row[1],
	          "codigo"    =>$row[2],
		      "producto"    =>$row[3],
			  "fechaingreso"    =>$row[4],
			  "comentario"    =>$row[5],
			  "cantidad"    =>$row[6],
			  "full_name"    =>$row[8],
			  "created"    =>$row[10]			  
			  );
	array_push($listausuarios,$item);
}

$tbHtml = "<table>
             <header>
                <tr>
                  <th>Reporte</th>                  
                  <th>Codigo</th>
                  <th>Producto</th>
				  <th>Fecha Ingreso</th>
				  <th>Comentario</th>
				  <th>Cantidad</th>
				  <th>Usuario</th>
				  <th>Creacion Real</th>				                   
                </tr>
            </header>";

foreach($listausuarios as $row)
  $tbHtml .= "<tr>
		  <td>$row[opcion]</td>
		  <td>$row[codigo]</td>
		  <td>$row[producto]</td>
		  <td>$row[fechaingreso]</td>
		  <td>$row[comentario]</td>
		  <td>$row[cantidad]</td>
		  <td>$row[full_name]</td>
		  <td>$row[created]</td>
	     </tr>";
$tbHtml .= "</html>";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=reporte.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
?>