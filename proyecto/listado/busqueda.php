<?php

 $mysqli = new mysqli("localhost","root", "", "scandapp_app");

 $salida = "";
 $query = "SELECT T1.id_cabeza, T1.tipolegalizacion, T1.fecha, T1.nombre, T1.linea, T1.area, T2.regional, T1.estado, T4.descripcion, T1.identificacion FROM lg_cabeza T1 INNER JOIN empleadolg T2 ON T1.identificacion = T2.cedula INNER JOIN lg_det_cabeza T4 ON T1.id_cabeza = T4.id  WHERE if(T1.estado = '0', '' ,T1.aprobador = 193 OR T1.identificacion = '1010243943') GROUP BY T1.id_cabeza";

 if(isset($_POST['consulta']))
 {
    $q = $mysqli -> real_escape_string($_POST['consulta']);
    $query = " SELECT T1.id_cabeza, T1.tipolegalizacion, T1.fecha, T1.nombre, T1.linea, T1.area, T2.regional, T1.estado, T4.descripcion, T1.identificacion FROM lg_cabeza T1 INNER JOIN empleadolg T2 ON T1.identificacion = T2.cedula INNER JOIN lg_det_cabeza T4 ON T1.id_cabeza = T4.id  WHERE if(T1.estado = '0', '' ,T1.aprobador = 193 OR T1.identificacion = '1010243943') and T1.id_cabeza LIKE '%".$q."%' OR T1.tipolegalizacion LIKE '%".$q."%' OR T1.fecha LIKE '%".$q."%' OR T1.nombre LIKE '%".$q."%' OR T1.linea LIKE '%".$q."%' OR T1.area LIKE '%".$q."%' OR T1.estado LIKE '%".$q."%' OR T1.identificacion LIKE '%".$q."%'";
 }

 $resultado = $mysqli->query($query);


//  <html xmlns="http://www.w3.org/1999/xhtml">
// <head>
// <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
// <title>.:: Aplicaciones Scandinavia Pharma ::.</title>
// </head>

// <body>
// <div align="center"><img src="underconstruction.png"  /></div>
// </body>
// </html>

if($resultado ->num_rows > 0)
{
    $salida = " <table class='tabla'>
                <thead>
                <tr>
                    <td>numero</td>
                    <td>tipo</td>
                    <td>fecha</td>
                    <td>nombre</td>
                    <td>linea</td>
                    <td>area</td>
                    <td>estado</td>
                    <td>identificacion</td>
                </tr>
                </thead>
                <tbody>";
    while ($fila = $resultado->fetch_assoc()) 
    {
        $salida.="<tr>
        <td>".$fila['id_cabeza']."</td>
        <td>".$fila['tipolegalizacion']."</td>
        <td>".$fila['fecha']."</td>
        <td>".$fila['nombre']."</td>
        <td>".$fila['linea']."</td>
        <td>".$fila['area']."</td>
        <td>".$fila['estado']."</td>
        <td>".$fila['identificacion']."</td>
        </tr>";
    }

    $salida.="</tbody></table>";
}
else
{
    $salida.="No hay datos :(";

}

echo $salida;

$mysqli->close();

?>