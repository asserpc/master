<?php
    include ('config.php');
    /*
    * el presente script permite agregar los vendedores y las marcas a productos recien cargados en grupo 
    * desarrollado por Andri chiriguita                                                                   
    * Derechos reservados Deitotec.com                                                                    
    * Licenciado su uso a Boomparts.com
    */
    
    /*obtiene el id de venderdor dado un id de usuario*/
    function buscarIdVendedor($ve){
        include ('conectar-bd-pdo.php');
        //datos a ingresar
        $id_vendedor=0;
        $sql='SELECT user_id, meta_value FROM '.PREFIJO_BD.'usermeta
        where  meta_key = "_vendor_term_id" and user_id="'.$ve.'"';

        //echo $sql;
        // Utilizar la conexión aquí
        $res = $bd->query($sql);
        //ciclo para recorrer la base de datos
        foreach($res as $datas)
        {
           $id_vendedor=$datas['meta_value'];
        }
        // Ya se ha terminado; se cierra
        $res = null;
        $bd = null;
        return $id_vendedor;
       
    }
      /* obtenie un ID de producto dado un sku*/
    function buscarProductoxSku($val){
        include ('conectar-bd-pdo.php');
        //datos a ingresar
        $pd=0;
        // Utilizar la conexión aquí
        $sql='SELECT post_id, meta_value FROM '.PREFIJO_BD.'postmeta 
        where meta_key="_sku" and meta_value="'.$val.'"';
        $res = $bd->query($sql);
        foreach($res as $datas)
        {

           $pd=$datas['post_id'];
           
        }

        // Ya se ha terminado; se cierra
        $res = null;
        $bd = null;
        return $pd;
       
    }
    /* retorna el ID dado el nombre de una marca*/
    function buscarMarcaID($mark){
        include ('conectar-bd-pdo.php');
        //datos a ingresar
        $idm=0;
        // Utilizar la conexión aquí
        $sql='SELECT term_id FROM '.PREFIJO_BD.'term_taxonomy
        where taxonomy = "product_brand" and description="'.$mark.'"';
        $res = $bd->query($sql);
        foreach($res as $dat)
        {

           $idm=$dat['term_id'];
           
        }

        // Ya se ha terminado; se cierra
        $res = null;
        $bd = null;
        return $idm;
       
    }

    /* recibe un registro de cvs de ymma y retorna un arreglo de termino ymma*/
    function idxymma($sku,$yy,$mk=0,$md=0,$mt=0){
        include ('conectar-bd-pdo.php');
   
        $pares[]="";
        

        $sql="";
        // Utilizar la conexión aquí
        if (!empty($yy) && ($yy>1830)){
            $sql='SELECT y_id,Marca_ID,modelo_ID,motor_ID 
            FROM Amm_datos
            where anno="'.$yy.'"';
            
            if (!$mk=='0' && !empty($mk)){
                $sql.= ' and marca="'.$mk.'"';
                if ($md!='0' && !empty($md)){
                    $sql.= ' and modelo="'.$md.'"';
                    if ($mt!='0' && !empty($mt)){
                        $sql.= ' and  motor="'.$mt.'"';
                    }else{
                        //echo "<br> todos los motores de un modelo <br>";
                    }
                }else{
                   // echo "<br> todos los modelos de una marca <br>";
                }
            }else{
                //echo "<br> todas las marcas de un año <br>";
            }
        }else {
                //$sql= " el valor esta fuera de rango";
        }
      /*
        echo  "<br> CONSULTA: <br>";
        echo  $sql;
        echo  "<br> FIN_consulta <br>";
        echo  "<br> FIN_***** FIN <br>";
        */
        
       $res = $bd->query($sql);
       $j=0;
        foreach($res as $dat)
        {
            if ($dat['y_id']!=$yy){
               //$pares[$j++]='"'.$sku.'","'.$dat['y_id'].'"';
               $pares[$j++]=$dat['y_id'];
               $yy=$dat['y_id'];
               
            }
            if ($dat['Marca_ID']!=$mk){
               // $pares[$j++]='"'.$sku.'","'.$dat['Marca_ID'].'"';
               $pares[$j++]=$dat['Marca_ID'];
                $mk=$dat['Marca_ID'];
            }
            if ($dat['modelo_ID']!=$md){
               // $pares[$j++]='"'.$sku.'","'.$dat['modelo_ID'].'"';
               $pares[$j++]=$dat['modelo_ID'];
                $md=$dat['modelo_ID'];
            }
            if ($dat['motor_ID']!=$mt){
               // $pares[$j++]='"'.$sku.'","'.$dat['motor_ID'].'"';
               $pares[$j++]=$dat['motor_ID'];
                $mt=$dat['motor_ID'];
            }
            
           
        }
        /*
        foreach ($pares as $par){
            echo "<br> $par";
        }
        */

        // Ya se ha terminado; se cierra*/
        $res = null;
        $bd = null;
        return parymma($sku,$pares);
       
    }
   
    /* 
      esta funcion recibe un arreglo de pares de post y termino ymma, 
      valida que terminos estan en la BD y los quita de modo 
      que el insert no de error
      
      */
    function parymma($pn,$lista){
        include ('conectar-bd-pdo.php');
        //datos a ingresar
        /*
        echo "<br> lo que se envia <br>";
        var_dump($lista);
        echo "<br> el sku : $pn <br>";
        */
        $dw[]="";
        $sql= 'SELECT count(*) as n FROM '.PREFIJO_BD.'term_relationships
        where ';
        // Utilizar la conexión aquí
        
       $ress= "";
       $j=0;
        foreach($lista as $registro)
        {
            $qv=$sql.' object_id="'.$pn.'" and term_taxonomy_id="'.$registro.'";';
            $ress = $bd->query($qv);
           // echo "<br> la query : $qv <br>";
            //var_dump($ress);
            foreach ($ress as $dt){
                if ($dt["n"]==0){
                    $dw[$j++]='"'.$pn.'","'.$registro.'"';
                }
            }
            //echo "<br> ahora : $ress[0] <br>";
            //echo '<br> el count:'.$ress['n'].' <br>';
           /* if ($ress['n']==0){
                $dw[$j++]='"'.$pn.'","'.$registro.'"';
            }*/
            $qv="";
            //$res =null;
            
        }
        /*
        foreach ($dw as $pp){
            echo "<br> $pp";
        }
        */

        // Ya se ha terminado; se cierra*/
        //$ress = null;
        $bd = null;
        return $dw;
       
    }

/* permite exportar los productos de la BD de productos */
  function exportarproducto(){
         include ('conectar-bd-pdo.php');

         $query = "SELECT * 
            FROM ".PREFIJO_BD."posts
            where post_type ='product' 
            and  post_status='publish'
            order by ID desc";
            //limit 10";
        //echo $query;
        //echo "<br>";
        $result = $bd->query($query);
    
       /* esto es para el archivo*/

        $csv_file = "db_Productos_".date('Ymd s') . ".csv";
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$csv_file");
        $fh = fopen( 'php://output', 'w' );
        $is_coloumn = true;
        
               
    foreach($result as $registro)
    {
        $listados=otrosDatosProducto($registro['ID']);
        foreach($listados as $datos)
        {
            $tt[$datos['meta_key']]=$datos['meta_value'];
           $registro=array_merge($registro,$tt);

        }
        $lista2[]=$registro;
        
    }
    
    $cabecera=array('ID','Sku','Titulo','Resumen','Contenido','Precio_regular','precio','stock','weight','length','width','height','imagen_galery','imagen_portada');
    
    foreach ($lista2 as $regist){
        $valores =array($regist['ID'], $regist['_sku'], $regist['post_title'], $regist['post_excerpt'],$regist['post_content'],$regist['_regular_price'],$regist['_price'],
                    $regist['_stock'],$regist['_weight'],$regist['_length'],$regist['_width'],$regist['_height'],$regist['_product_image_gallery'],$regist['_thumbnail_id'] );
       if($is_coloumn) {
            //fputcsv($fh, array_keys($regist), ";");
            fputcsv($fh, $cabecera, ";");
                $is_coloumn = false;
            }
        //fputcsv($fh, array_values($regist),";");
            fputcsv($fh, $valores,",");
        
      // var_dump($valores);
       //echo "<br>";
    }
   // echo "<br> recorrido interno............ <br>  ";
   fclose($fh);
    $bd = null;
    exit;
}


function otrosDatosProducto($idp){
    include ('conectar-bd-pdo.php');

    $qy = "SELECT meta_key, meta_value FROM ".PREFIJO_BD."postmeta 
    where post_id in (SELECT ID
    FROM ".PREFIJO_BD."posts
    where post_type ='product' 
            and  post_status='publish'
            and post_id=$idp
            ) 
            ";
    echo $qy;
    echo "<br> ";
    $rs = $bd->query($qy);
    
        $w=1;
        $image="";
    foreach($rs as $datos)
    {
        echo $datos['meta_key'];
        echo "<br> ";
        if (($datos['meta_key']=='_product_image_gallery')||($datos['meta_key']=='_thumbnail_id')){
            if($datos['meta_key']=='_product_image_gallery'){
                $w++;
                $image=getImagen(explode(",",$datos['meta_value']));
            }
            if($datos['meta_key']=='_thumbnail_id'){
                $w++;
                $image.=getImagen($datos['meta_value'], $image);
            }
            $datos['imagen']=$imagen;
        }
        $tt[]=$datos;
        var_dump($tt);
        echo "<br> ";
    }
    $bd = null;
    return $tt;
}


function getImagen($dtkeys,$cadimg="" ){
    include ('conectar-bd-pdo.php');
    $remplazar="https://boonparts.com/wp-content/uploads/";
    
    foreach ($dtkeys as $tkey){
            $sql="Select guid from ".PREFIJO_BD."posts
            where id=$tkey";
            $ree = $bd->query($sql);
            $cadimg.=str_replace($remplazar, " ", $rs['guid'] ).",";
            $sql="";
    }
    $cadimg[strlen($cadimg)-1]=" ";
    
    $bd = null;
   
    return $cadimg;
}

$otros=otrosDatosProducto('80201');
foreach ($otros as $otro){
    var_dump($otro);
    echo "<br> ";
}

/* retorna los terminos adicionales de un producto */
function getmasProducto($idprd){
    include ('conectar-bd-pdo.php');
    $sql="SELECT object_id as prodID, term_taxonomy_id as terminoID, name 
    FROM ".PREFIJO_BD."term_relationships, ".PREFIJO_BD."terms
          where object_id=$idprd
          and term_taxonomy_id=wpmv_terms.term_id";

    $rs = $bd->query($sql);
    $bd = null;
    return $rs;
}





function masProductoscvs(){
    // esto es para el archivo
    
   $csv_file = "bd_adicionales_productos".date('Ymd s') . ".csv";
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$csv_file");
    $fh = fopen( 'php://output', 'w' );
    $is_coloumn = true;
    
    $cabeza= array('producto','termino','nombre');
    include ('conectar-bd-pdo.php');
        $nvsql= "SELECT ID from ".PREFIJO_BD."posts
                    where 
                        post_status='publish'
                        and post_type='product'";
        $resultado = $bd->query($nvsql);
       
        foreach ($resultado as $producto){
               $linea=getmasProducto($producto['ID']);
              // echo $producto['ID'];
              // echo "<br> ";
               foreach ($linea as $rt){
                   //var_dump($rt);
                   //echo "<br> ";
                   
                    if($is_coloumn) {
                        fputcsv($fh,$cabeza, ";");
                        $is_coloumn = false;
                    }
                    fputcsv($fh,array($rt['prodID'],$rt['terminoID'],$rt['name']),",");
                
                }
              $linea=null;
        }
        $bd = null;
    

    fclose($fh);
    exit; 

}

//exportarproducto();
//masProductoscvs(80201,2);
?>