<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script src="jquery-3.4.1.min.js"></script>
  <link rel="stylesheet" href="jquery-ui.css">
  <script src="jquery-ui.js"></script>
</head>

<style>

a.open
{
  background-color: #414141;
  border-radius:5px;
  color:#fff;
  font-size:1.5em;
  margin:20px;
  padding: 10px 20px;
  position:absolute;
  text-decoration:none;
  text-shadow:2px 2px 0px #000;
  -webkit-transition:background-color: 1s;

}
a.open:hover
{
  background-color:#111;

}

section.modalDialog
{
  background-color: rgba(0,0,0,.5);
  bottom:0;
  top:0;
  left:0;
  right:0;
  opacity:0;
  position:fixed;
  z-index: -2;
  -webkit-transition: opacity 0s;

}

section.modalDialog:target 
{
  opacity: 1;
}

a.close
{
  background-color:#414141;
  border-radius: 5px;
  color: #fff;
  font-size:14px;
  line-height:22px;
  position:absolute;
  right:5px;
  top:5px;
  text-align:center;
  text-decoration: none;
  width:28px;
}



a.close{
  background-color: #000;
}



section.modal{
  background-color:#111;
  box-shadow: 0px 0px 10px #000;
  border-radius: 5px;
  color: #fff;
  margin: 10% auto;
  padding: 20px;
  position: relative;
  width:400px;
}


h2{
  color:#fff;
  font-size:2em;
  margin-bottom: 10px; 
}

p{
  color:white;
  font-size:1.2em;
}
.ui-front{
    z-index: 9999999999;
}
</style>

<?php

require_once '../../scandinavia/mcv5/clases/DB.class.php';


	 $consulta="SELECT u_username FROM system_users";
	 $sql = mysqli_query($mysqli, $consulta);
    
   $array = array();
    while($row = mysqli_fetch_array($sql))
    {
       $equipo = utf8_encode($row['u_username']);
       array_push($array, $equipo);
    }


?> 


<body>
<div class="contenedor">
  <a href="#openmodal" class="open">Abrir Ventana</a>
  <section id="openmodal" class="modalDialog">
    <section class="modal" ui-front>
        <a href="#close" class="close">
          x 
        </a>
        <h2>Ventana Modal</h2>
        <input type="text" name="paneles"  class="form-control" id="pan1" onKeyUp="asistentespanel()"  onBlur="asistentespanel2()">
        <input type="text" name="pane"  class="form-control" id="pan2">
    </section>
  </section>
</div>

</body>
</html>
<script>

$(document).ready(function () {
  var items = <?= json_encode($array)?>
  
  $("#pan1").autocomplete({
     source: items
  });

});

</script>