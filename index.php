<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
         
        function insertFactura($array){
            $path = "http://localhost/Lic/tarea06/hello.php/facturas";
            $options = array(
                    'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($array),
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents($path, false, $context);
        }        
        
        function insertProducto($array){
            $path = "http://localhost/Lic/tarea06/hello.php/productos";
            $options = array(
                    'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($array),
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents($path, false, $context);
        }
        
        function selectFactura() {
            $path = "http://localhost/Lic/tarea06/hello.php/facturas";
            $data = file_get_contents($path);
            $json = json_decode($data, true);

            return $json;
        }
        
        function selectProducto($fact) {
            $path = "http://localhost/Lic/tarea06/hello.php/productos?fact=" . $fact;
            $data = file_get_contents($path);
            $json = json_decode($data, true);

            return $json;
        }
        
        function deleteProd($prod) {
             $path = "http://localhost/Lic/tarea06/hello.php/delProd";
            $options = array(
                    'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($prod),
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents($path, false, $context);
        }
        
        
        $facturas = selectFactura();
        //
        //$productos = selectProducto();
        //insertFactura([], ["cliente" => 'LOL', "fecha"=> '1995']);
        //insertProducto([], ["cantidad" => 5, "uvalor"=> 100, "descripcion"=> 'estan buenas', "factura_id" => 0]);
        
        if(isset($_POST['addFact'])){
            $array = ["id"=> count($facturas), "cliente" => $_POST['cliente'], "fecha"=> $_POST['fecha']];
            insertFactura($array);
        }
        
        if(isset($_POST['addProd'])){
            $array = ["cantidad" => $_POST['cantidad'], "uvalor"=> $_POST['uvalor'], "descripcion"=> $_POST['descripcion'], "factura_id" => $_GET['fact']];
            insertProducto($array);
        }
        
        if(isset($_POST['delProd'])){
            $prod = $_POST['prodID'];
            //echo $prod;
            deleteProd(["id" => $prod]);
            //echo var_dump($productos);
        }
        
        
        //echo var_dump($facturas);
        ?>
        
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>                
            </thead>
            <tbody>
                <?php if(isset($facturas)){
                    foreach($facturas as $key => $row) {
                        echo '<tr><td>' . $row['id'] . '</td>';
                        echo '<td>' .$row['cliente']. '</td>'; 
                        echo '<td>' .$row['fecha']. '</td>';
                        echo '<td><a target="_self" href="?fact='. $row['id'] .'">Ir a ..</a></td></tr>';
                    }    
                }
                ?>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        <form method="post">
            <label>Client</label>
            <input type="text" name="cliente" value=""/>
            <label>Date</label>
            <input type="date" name="fecha" value=""/>
            
            <input type="submit" name="addFact" value="Add Factura"/>
        </form>
        
        <!----         -->        
        <br>
        <br>
        <br>
        
        <?php if(isset($_GET['fact'])) { 
            $fact = $_GET['fact'];
            $productos = selectProducto($fact);
            
            //filter by fact
            $productos = array_filter($productos, function($value) use ($fact) {
                return $value['factura_id'] == $fact;
            });
            $subTotalArray = array_map(function($prod){
                return $prod['cantidad']*$prod['uvalor'];
            }, $productos);
            $subTotal = array_reduce($subTotalArray, function($acc, $sub){
                return $acc + $sub;
            });
            $impuesto = $subTotal * 0.13;
            $total = $subTotal + $impuesto;
            ?>
            <table>
            <thead>
                <tr>
                    <th>Cant</th>
                    <th>Description</th>
                    <th>Unit Value</th>
                    <th>Sub Total</th>
                    <th>Action</th>                    
                </tr>                
            </thead>
            <tbody>
                <tr>
                    <?php 
                    foreach($productos as $key => $row) {
                        echo '<tr><td>' .$row['cantidad']. '</td>';
                        echo '<td>' .$row['descripcion']. '</td>'; 
                        echo '<td>' .$row['uvalor']. '</td>';
                        echo '<td>' .$row['cantidad']*$row['uvalor']. '</td>';
                        echo '<td><form method="post">'
                        . '<input type="hidden" value="'. $row['id'] .'" name="prodID"><input type="submit" value="delete" name="delProd">'
                                . '</form></td></tr>';
                    }
                    ?>
                    
                    <form method="post">
                        <td>
                            <input type="text" name="cantidad" value=""/>
                        </td>
                        <td>
                            <input type="text" name="descripcion" value=""/>
                        </td>  
                        <td>
                            <input type="text" name="uvalor" value=""/>
                        </td>
                        <td>
                            <input type="hidden" value="<?php echo isset($_GET['fact']) ? $_GET['fact'] : ''?>">
                        </td>
                        <td>
                            <input type="submit" name="addProd" value="add"/>
                        </td>
                    </form>                    
                </tr>
            </tbody>            
        </table>    
        <h4>Impuesto : <?php echo $impuesto?></h4>
        <h4>SubTotal : <?php echo $subTotal?></h4>
        <h4>Total : <?php echo $total?></h4>
         <?php  } else { ?>
            <h3>Seleccione una Factura para mas opciones</h3>
        <?php }?>
    </body>
</html>
