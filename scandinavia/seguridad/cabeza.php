

<?php
/*
 * @author Shahrukh Khan
 * @website http://www.thesoftwareguy.in
 * @facebbok https://www.facebook.com/Thesoftwareguy7
 * @twitter https://twitter.com/thesoftwareguy7
 * @googleplus https://plus.google.com/+thesoftwareguyIn
 */
require_once("config.php");


// set page title
$title = "Dashboard";

// if the rights are not set then add them in the current session




?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
    
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="shortcut icon" href="https://cdn.sstatic.net/Sites/es/img/favicon.ico?v=a8def514be8a">
    <title>Aplicaciones :. <?php echo $row_Empresa['razonsocial']; ?> .:</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

   <!--
    <script src="/scandinavia/assets/js/require.min.js"></script>
    
    <script>
      requirejs.config({
          baseUrl: '.'
      });
    </script>-->
    <!-- Dashboard Core -->
    <link href="/scandinavia/assets/css/dashboard.css" rel="stylesheet" />
    <!-- c3.js Charts Plugin -->
    
    
    


<style>
	.typeahead { border: 2px solid #fff;border-radius: 4px;padding: 8px 12px;max-width: 300px;min-width: 290px;background:#00965e ;color: #FFF;}
	.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;border-bottom:#00965e  1px solid;color:#00965e ;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.lista-color {max-width: 450px;min-width: 290px;max-height:340px;
	border-radius:4px;text-align:left;margin:10px; margin-bottom:120px;}
	.Busca-pais {font-size:1.5em;color: #00965e ;font-weight: 700; text-align:left}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #337ab7;
		outline: 0;
	}
  .form-control{width:300px;}
  .texto
  {
     margin-left:50px;
     color:#337ab7;
  }
	</style>
</head>

  <body>
<body >
    <div >
      <div >
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="/scandinavia/seguridad/index.php">
                <img src="/scandinavia/assets/img/Megalabs_Logo.png" width="300" >                   
                  <div class="texto">
                    Scandinavia Pharma LTDA. 
                    <h6>Una compañia MegaLabs </h6>
                  </div>
                    
                     
              </a>
              
            </div>
          </div>
        </div>
        
        </div>
        <div class="my-3 my-md-5">
          <div class="container">
         
         
      
