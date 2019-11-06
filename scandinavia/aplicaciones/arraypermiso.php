<?php
require_once("config.php");

require_once("sesion.php");


session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    // not logged in send to login page
	 echo "<script type='text/javascript'>window.top.location='http://appscandinavia.com/scandinavia/seguridad/index.php';</script>";
	
}
$status = FALSE;


$armadodepermisos="";
$moduleinput = $_REQUEST['op'];

 $sql = "SELECT rr_rolecode,rr_modulecode, rr_create,  rr_edit, rr_delete, rr_view FROM role_rights "
                . " WHERE  rr_rolecode = :rc and rr_modulecode = :moduleinput"
                . " ORDER BY `rr_modulecode` ASC  ";

        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":rc", $_SESSION["rolecode"]);
		$stmt->bindValue(":moduleinput", $moduleinput );
        
        
        $stmt->execute();
        $userRights = $stmt->fetchAll();
		
		
        $sql = "SELECT  mod_modulegroupcode, mod_modulegroupname, mod_modulepagename,  mod_modulecode, mod_modulename FROM module "
                . " WHERE 1 and  mod_modulecode = :moduleinput"
                . " ORDER BY `mod_modulegrouporder` ASC, `mod_moduleorder` ASC  ";

        $stmt = $DB->prepare($sql);
		$stmt->bindValue(":moduleinput", $moduleinput );
        $stmt->execute();
        $allModules = $stmt->fetchAll();
				
		$moduloconsulto = $allModules[0]["mod_modulegroupcode"];
		$modulecodigo = $userRights[0]["rr_modulecode"];
		
$varses =  array("create", "edit", "view","delete");
$varpermiso= array();
$ii= 0;
 for ($j = 0, $c2 = count($userRights); $j < $c2; $j++) {
             //echo $userRights[$j]["rr_rolecode"] ." - ";
			//echo $userRights[$j]["rr_modulecode"]." <br> ";
			for($ii = 0; $ii<=3; $ii++ ){
				$cierre = " || <BR>";
				if($ii == 3){ $cierre = " <BR>"; }
				$varses[$ii];
			    $armadodepermisos .="authorize(\$_SESSION[\"access\"][" . "\"". $moduloconsulto . "\"" . "][" . "\"". $userRights[$j]["rr_modulecode"] . "\""."][" . "\"". $varses[$ii] . "\""."]) " . $cierre;			
				
				$varpermiso[$ii] = "authorize(\$_SESSION[\"access\"][" . "\"". $moduloconsulto . "\"" . "][" . "\"". $userRights[$j]["rr_modulecode"] . "\""."][" . "\"". $varses[$ii] ."\""."])";
				
            }
			
 }
 
 $armadodepermisos = substr($armadodepermisos, 0, -1);





?>