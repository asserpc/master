<?php

/* Database credentials. Assuming you are running MySQL

server with default setting (user 'root' with no password) */

define('DB_SERVER', 'localhost');

define('DB_USERNAME', 'puerpjmx_bkd');

define('DB_PASSWORD', 'AC#root#009');

define('DB_NAME', 'puerpjmx_bkboon');

 

/* Attempt to connect to MySQL database */

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

 

// Check connection

if($link === false){

    die("ERROR: No se puede conectar. " . mysqli_connect_error());

}



define('PREFIJO_BD', 'wpth_')

?>