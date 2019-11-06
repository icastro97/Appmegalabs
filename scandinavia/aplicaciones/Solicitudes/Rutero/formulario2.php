<?php
        include("bd.php");
		include("formulario.php");
		include('datos.php');

        
      
        if(isset($_POST['enviar']))
        {  
            $fechaActual = $_POST['fechaActual'];
            $descripcion = $_POST['descripcion'];
            $direccion = $_POST['direccion'];
            $diligencia = $_POST['diligencia'];
            $uno = $_POST['uno'];
            $dos = $_POST['dos'];
            
           
						
        	$registro = new dato();
			$registro->registrarDato($fechaActual, $descripcion, $direccion, $diligencia, $uno, $dos);
            
           
						
        }				


?>