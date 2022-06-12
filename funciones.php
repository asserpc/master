<?php

/* genera el formulario de carga de archivo 
   recibe nombre de la pagina y url de destino de proceso */
function formulario($text,$uri){
    
    echo '<html>
            <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
            <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
            <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
            <!--[if gt IE 8]><!--> 
            <!-- <html class="no-js" lang=""> <![endif]-->
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                    <title>'.$text.'</title>
                    <meta name="description" content=" Parte de conexion">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
                    <!-- <link rel="stylesheet" href="css/normalize.min.css">
                    <link rel="stylesheet" href="css/main.css"> -->
                    <!-- <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script> -->
                </head>
                <body>
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <br>
                                <div class="row">
                                    <form action="'.$uri.'" method="post" enctype="multipart/form-data" id="import_form">
                                        <div class="col-md-3">
                                            <input type="file" name="file" />
                                            <input type="hidden" name="paso" value="p" />
                                        </div>
                                        <div class="col-md-5">
                                            <input type="submit" class="btn btn-primary" name="import_data" value="IMPORT">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <a href="welcome.php" class="btn btn-primary">Menu</a>
                                <a href="logout.php" class="btn btn-danger">Salir</a>
                            </div>
                        </div>
                    </div>
                </body>
            </html>';
}

function formulario2($uri){
    
    echo '   <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <br>
                                <div class="row">
                                    <form action="'.$uri.'" method="post" enctype="multipart/form-data" id="import_form">
                                        <div class="col-md-3">
                                            <input type="file" name="file" />
                                            <input type="hidden" name="paso" value="p" />
                                        </div>
                                        <div class="col-md-5">
                                            <input type="submit" class="btn btn-primary" name="import_data" value="IMPORT">
                                        </div>
                                    </form>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>'
                ;
}


function formRecupera(){
    
    echo '<html>
            <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
            <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
            <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
            <!--[if gt IE 8]><!--> 
            <!-- <html class="no-js" lang=""> <![endif]-->
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                    <title> Recuperar Datos </title>
                    <meta name="description" content=" Parte de conexion">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
                    <!-- <link rel="stylesheet" href="css/normalize.min.css">
                    <link rel="stylesheet" href="css/main.css"> -->
                    <!-- <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script> -->
                </head>
                <body>
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <br>
                                <h2>Recuperacion de Productos</h2>
                                <p>En este apartado podras descargar la Bd de Productos y la BD de datos adicionales a los productos, recuerda debes descargar ambas
                                   para tener un producto completo</p>
                                <div class="row">
                                    <br>
                                    <a href="recupera.php?rt=p" class="btn btn-warning">Productos</a>
                                    <br>
                                    <a href="recupera.php?rt=y" class="btn btn-success">Adicionales</a>
                                </div>
                                <br>
                                <a href="welcome.php" class="btn btn-primary">Menu</a>
                                <a href="logout.php" class="btn btn-danger">Salir</a>
                            </div>
                        </div>
                    </div>
                </body>
            </html>';
}