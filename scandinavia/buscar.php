
<?php
require('mcv5/clases/DB.class.php');
//Variable de búsqueda
$consultaBusqueda = $_POST['valorBusqueda'];


//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";
$consultaCampos =  "";
$Campos =  "";
$cabeceras= array("icono", "Modulo", "url");


$consultaxx = "SELECT icon, mod_modulename, mod_modulepagename from module WHERE mod_modulename  LIKE '%$consultaBusqueda%'  " ;

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
			$c  = $resultados['icon'];
			$c1 = $resultados['mod_modulename'];
			$c2 = $resultados['mod_modulepagename'];
		

			//Output
			$sd =  '<a href="javascript:void(0);" data-id="<?php echo $c;?>" >Editar </a>' ;  
			$mensaje .= '
			<p>
				<span>' . $c . ' </span><br>
				<span>' . $cabeceras[1] . ': ' .$c1 . ' </span><br>	
				<span>' . $cabeceras[2] . ': ' .$c2 . ' </span><br>		
				<a class="edit" href="#" data-id= "'.$c1.'" >Ver </a>'. '</span><br>			
			</p>';		
		};//Fin while $resultados

	}; //Fin else $filas

};//Fin isset $consultaBusqueda

//Devolvemos el mensaje que tomará jQuery
echo  $mensaje;

?>
<a href="<?php echo $row_Obser['mod_modulepagename']; ?>?op=<?php echo $row_Obser['mod_modulecode']; ?>"> <img src="assets/img/app/<?php echo $row_Obser['icon']; ?>"></a>