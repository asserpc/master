<?php
	
	// Creamos las variables de conexión
	 
     $contraseña = "Boon2021";
     $usuario = "root";
     $nombre_base_de_datos = "boonweb";
     try{
         $bd = new PDO('mysql:host=localhost;dbname=' . $nombre_base_de_datos, $usuario, $contraseña);
     }catch(Exception $e){
            echo "Ocurrió algo con la base de datos: " . $e->getMessage();
     }
     
   

?>
