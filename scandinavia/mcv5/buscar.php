<?php

require('clases/DB.class.php');
//Variable de búsqueda
$consultaBusqueda = $_POST['valorBusqueda'];
$consultaTablaBusqueda = $_POST['tbus'];


//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";
$consultaCampos =  "";
$Campos =  "";

switch ($consultaTablaBusqueda) {
    case "vwx2_contacts":
	    $cabeceras = array("Nombre", "Email", "Telefono");
	    $Campos = "id as c, name as c1, email as c2, phone as c3";
        $consultaCampos = " WHERE name  LIKE '%$consultaBusqueda%' 
							OR email  LIKE '%$consultaBusqueda%'
							OR phone  LIKE '%$consultaBusqueda%'
							OR CONCAT(name,' ',email,' ',phone)  LIKE '%$consultaBusqueda%'";
        break;
    case "vw_llamadas":
	$cabeceras = array("De", "Tema", "Comentario");
	    $Campos = "id as c,de as c1, subject as c2, comment as c3";	
        $consultaCampos = " WHERE de  LIKE '%$consultaBusqueda%' 
							OR subject  LIKE '%$consultaBusqueda%'
							OR comment  LIKE '%$consultaBusqueda%'
							OR CONCAT(de,' ',subject,' ',comment)  LIKE '%$consultaBusqueda%'";
        break;
    case "seguimientos":
   	    $cabeceras = array("Fecha Visita", "Tema", "Contacto");	
	    $Campos = "id as c, fechavisita as c1, subject as c2, contacto as c3";	
        $consultaCampos = " WHERE fechavisita  LIKE '%$consultaBusqueda%' 
							OR subject  LIKE '%$consultaBusqueda%'
							OR contacto  LIKE '%$consultaBusqueda%'
							OR CONCAT(fechavisita,' ',subject,' ',contacto)  LIKE '%$consultaBusqueda%'";

        break;
    default:
        echo "";
}



$consultaxx = "SELECT " . $Campos. " FROM " . $consultaTablaBusqueda . $consultaCampos ;

//Comprueba si $consultaBusqueda está seteado
if (isset($consultaBusqueda)) {
	$consulta = mysqli_query($mysqli, $consultaxx);

	//Obtiene la cantidad de filas que hay en la consulta
	$filas = mysqli_num_rows($consulta);

	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas === 0) {
		$mensaje = "<p>No hay ningún registro</p>" ;
		
	} else {
		//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
		echo '<BR><BR>Resultados para la Busqueda de: <strong>'.$consultaBusqueda.'</strong><BR><BR>';

		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		while($resultados = mysqli_fetch_array($consulta)) {
			$c1 = $resultados['c1'];
			$c2 = $resultados['c2'];
			$c3 = $resultados['c3'];
			$c  = $resultados['c'];

			//Output
			$sd =  '<a href="javascript:void(0);" data-id="<?php echo $c;?>" >Editar </a>' ;  
			$mensaje .= '
			<p>
				<span>' . $cabeceras[0] . ': ' .$c1 . ' </span><br>
				<span>' . $cabeceras[1] . ': ' .$c2 . ' </span><br>
				<span>' . $cabeceras[2] . ': ' .$c3 . '</span><br>
				<a class="edit" href="#" data-id= "'.$c.'" >Ver </a>'. '</span><br>			
			</p>';		
		};//Fin while $resultados

	}; //Fin else $filas

};//Fin isset $consultaBusqueda

//Devolvemos el mensaje que tomará jQuery
echo  $mensaje;

?>