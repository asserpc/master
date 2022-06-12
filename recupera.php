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
            file_put_contents($archivo, " Se intenta ingresar a recupera.php directamente : $fecha desde: $ip \n",  FILE_APPEND | LOCK_EX);
            header("location: login.php");
            exit;
        }   
       // include_once("db_connect.php");
        include 'cargarAtributos.php';
        include_once ('funciones.php');
       
         if (!isset($_GET['rt'])||empty($_GET['rt'])){
            formRecupera();
            
         }elseif ($_GET['rt']=='p'){
            $_GET['rt']=null;
            exportarproducto();
           // formRecupera();
         }elseif ($_GET['rt']=='y'){
            masProductoscvs();
            $_GET['rt']=null;
           // formRecupera();
         }
         
         
      