<?php
   /*
     este script permite la carga en lote de ymma a un producto a traves de un cvs
     requiere que el archivo cvs 
      // 0: sku, 1: año, 2:marca, 3:modelo 4:motor
                   
     *   consideraciones:
     *   si marca=modelo=motor=0 entonces se agregaran todos las marcas, modelos y motores de dicho año
     *   si modelo=moto=0  se agregagran todos los modelos de la marca y año indicado
     *   si motor=0 se agregaran todos los motores del año, marca y modelo indicado
     * 
     *   desarrollado por: Andri Chirigüita
     *   Derechos: Deitotec.com - 2022
     *   Licencia a Boonparts.com solo de uso

   */
    
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
        file_put_contents($archivo, " Se intenta ingresar directamente : $fecha desde: $ip \n",  FILE_APPEND | LOCK_EX);

        header("location: login.php");
        exit;
    }   
    
    include ('config.php');
    include_once("db_connect.php");
    include 'cargarAtributos.php';
    include_once ('funciones.php');
    
    if(!isset($_POST['paso'])){
        formulario("Los YMMA",'cargar-ymma-de-producto.php');
    }

    
    $consulta= 'INSERT INTO '.PREFIJO_BD.'term_relationships (object_id, term_taxonomy_id) VALUES ';
    if(isset($_POST['import_data'])){
         // validate to check uploaded file is a valid csv file
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
            if(is_uploaded_file($_FILES['file']['tmp_name'])){
                $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
                
                         $i=1;$j=-1;
                // get data records from csv file
                while(($registro_ymma = fgetcsv($csv_file)) !== FALSE){
                   /* var_dump($registro_ymma);
                    //parte superior de la tabla
                    echo " ------------------------------------------------------<br>";*/
                    if ($i==1){  
                       echo '<div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>'.$registro_ymma[0].'</th> 
                                    <th>'.$registro_ymma[1].'</th>
                                    <th>'.$registro_ymma[2].'</th>
                                    <th>'.$registro_ymma[3].'</th>
                                    <th>'.$registro_ymma[4].'</th>
                                </tr>
                            </thead>
                         <tbody>';
                        $i++;
                    }else{
                        /* datos del archivo columna, sku, yy, marca, modelo,motor */
                        $prod=buscarProductoxSku($registro_ymma[0]);
                        $grupos= idxymma($prod,$registro_ymma[1],$registro_ymma[2],$registro_ymma[3],$registro_ymma[4]);
                        /*foreach ($grupos as $par){
                            //echo "<br> $par";
                            $nvPar= ;
                        }*/
                        
                        foreach ($grupos as $par){
                            //echo "<br> $par";
                            $consulta.= '('.$par.'),';
                        }
                       
                     /*    $consulta.=' ( '.$Producto.','.$Vendor.'),';
                         $consulta.=' ( '.$Producto.','.$marca.'),';*/
                        // echo $consulta. " <br>+ ... +<br>";
                         //echo agregaVendedor($Productos,$Vendor);
                        // $j++;
                             
                          echo '<tr>
                                                    <td>'.$prod.'</td>
                                                    <td>'.$registro_ymma[1].'</td>
                                                    <td>'.$registro_ymma[2].'</td>
                                                    <td>'.$registro_ymma[3].'</td>
                                                    <td>'.$registro_ymma[4].'</td>
                                                </tr>
                                ';
                             
                    }//fin_else
                    
                }// fin_while
                // final de la tabla
                //cierre del archivo       
                fclose($csv_file);
                //variable de control
                //echo $consulta[strlen($consulta)-1];
                
               // echo "<br>++<br>";
                $consulta[strlen($consulta)-1]=';';
               // echo $consulta;
                //echo "<br>++<br>";
                file_put_contents($archivo, " carga de YMMA $consulta en: $fecha desde: $ip \n",  FILE_APPEND | LOCK_EX);
               $tt=$conn->query($consulta);
                
               
            } 
        
        }
       
    }
   
    $cnn=null;
    $tt=null;
?>