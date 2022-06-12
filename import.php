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
        file_put_contents($archivo, " Se intenta ingresar : $fecha desde: $ip\n",  FILE_APPEND | LOCK_EX);
        header("location: login.php");
          exit;
      }   
      file_put_contents($archivo, " Ingresando a Carga de Productos con  usario:". $_SESSION['username']."  en: $fecha desde: $ip\n",  FILE_APPEND | LOCK_EX);
      
      include_once("config.php");
    include_once("db_connect.php");
    include 'cargarAtributos.php';
    include_once ('funciones.php');
    //if(!isset($_POST['paso'])){
        formulario("Carga de Vendedores y Marcas","import.php");
   // }

    $Productos=-99;
    $Vendor=-99;
    $consulta= 'INSERT INTO '.PREFIJO_BD.'term_relationships (object_id, term_taxonomy_id) VALUES ';
    if(isset($_POST['import_data'])){
         // validate to check uploaded file is a valid csv file
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
            if(is_uploaded_file($_FILES['file']['tmp_name'])){
                $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
                
                         $i=1;$j=-1;
                // get data records from csv file
                while(($emp_record = fgetcsv($csv_file)) !== FALSE){
                   /* var_dump($emp_record);
                    //parte superior de la tabla
                    echo " ------------------------------------------------------<br>";*/
                   
                    if ($i==1){  
                       echo '<div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>'.$emp_record[0].'</th>
                                    <th>'.$emp_record[1].'</th>
                                    <th>'.$emp_record[17].'</th>
                                    <th>'.$emp_record[18].'</th>
                                </tr>
                            </thead>
                         <tbody>';
                        $i++;
                    }else{
                        /* datos del archivo columna, sku, nombre, marca, vendedor */
                      /*  $j++;
                         $carga[$j]['sku']=$emp_record[0];
                         $carga[$j]['nombre']=$emp_record[1];
                         $carga[$j]['marca']=$emp_record[17];
                         $carga[$j]['vendedor']=$emp_record[18];*/
                        $Vendor= buscarIdVendedor($emp_record[18]);
                        $Producto=buscarProductoxSku($emp_record[0]);
                        $marca=buscarMarcaID($emp_record[17]);
                         $consulta.=' ( '.$Producto.','.$Vendor.'),';
                         $consulta.=' ( '.$Producto.','.$marca.'),';
                        // echo $consulta. " <br>+ ... +<br>";
                         //echo agregaVendedor($Productos,$Vendor);
                         $j++;
                             
                          echo '<tr>
                                                    <td>'.$emp_record[0].'</td>
                                                    <td>'.$emp_record[1].'</td>
                                                    <td>'.$emp_record[17].'</td>
                                                    <td>'.$emp_record[18].'</td>
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
              //  echo "<br>++<br>";
                
                file_put_contents($archivo, " Se realizo una carga de productos $consulta en : $fecha desde: $ip \n",  FILE_APPEND | LOCK_EX);
               
                $tt=$conn->query($consulta);
                
                //$import_status = '?import_status=success';
            } else {
               // $import_status = '?import_status=error';
            }
        } else {
           // $import_status = '?import_status=invalid_file';
        }
       
    }
   
    $cnn=null;
    $tt=null;
?>