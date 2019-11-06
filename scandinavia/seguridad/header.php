<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="shortcut icon" type="image/x-icon" href="icono.ico" />
        <meta name="author" content="HBT">
        <meta name="keywords" content="">

        <title>Portal de Aplicaciones </title>

        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-social.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
    </head>
    <style>

</style>
    <body>

<br>
<br>
<br>

   

        <div class="container mainbody">
            <div class="page-header">
                <h1><?php echo $title ?></h1>
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <div class="container-fluid">

                <?php if ($ERROR_MSG <> "") { ?>
                    <div class="col-lg-12">
                        <div class="alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
                            <button data-dismiss="alert" class="close" type="button">x</button>
                            <p><?php echo $ERROR_MSG; ?></p>
                        </div>
                        <div style="height: 10px;">&nbsp;</div>
                    </div>
                <?php } ?>