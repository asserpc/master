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


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    file_put_contents($archivo, " Se intenta ingresar directamente : $fecha desde: $ip\n",  FILE_APPEND | LOCK_EX);
    header("location: login.php");
    exit;
}

file_put_contents($archivo, " ingreso al menu con ".$_SESSION['username']."  en: $fecha desde: $ip\n",  FILE_APPEND | LOCK_EX);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Master</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h4>Hola, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bienvenid@.</h4>
        <p> <br> En la Presente seccion puedes Hacer Cargas en lote tanto de productos a un Vendedor como de ymma a un producto a traves de archivos<br></p>
        
    </div>
    <p>
        <a href="import.php" class="btn btn-success">Carga Productos</a>
        <a href="cargar-ymma-de-producto.php" class="btn btn-primary">Carga YMMA</a>
        <a href="recupera.php" class="btn btn-warning">Recupera</a>
        <a href="logout.php" class="btn btn-danger">Salir</a>
        <br/>
    </p>
    <!-- <a href="register.php" class="btn btn-info">Registrar Usuario</a> -->


</body>
</html>