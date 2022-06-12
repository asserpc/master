<?php
// Initialize the session
session_start();

 /* obtencion del primer acceso */
//log
$archivo="miarchivo.txt";
//fecha y hora
$fecha=  date('m-d-Y h:i:s a', time()); 
//dir del cliente
$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
file_put_contents($archivo, " Se cierra sesion ".$_SESSION['username']." en: $fecha desde: $ip \n",  FILE_APPEND | LOCK_EX);
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: login.php");
exit;
?>