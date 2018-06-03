<?php

include './toro.php';

$file_db = new PDO('sqlite:tarea4.db');
    
$file_db->setAttribute(PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION);

function insertFactura($file_db, $array){
    $insert = "INSERT INTO factura (cliente, fecha) 
       VALUES (:cliente, :fecha)";
    $stmt = $file_db->prepare($insert);

    $stmt->bindParam(':cliente', $array['cliente']);
    $stmt->bindParam(':fecha', $array['fecha']);

     $stmt->execute();
}        

function insertProducto($file_db, $array){
    echo var_dump($array);
    $insert = "INSERT INTO producto (uvalor, cantidad, descripcion, factura_id) 
       VALUES (:uvalor, :cantidad, :descripcion, :factura_id)";
   $stmt = $file_db->prepare($insert);

   $stmt->bindParam(':uvalor', $array['uvalor']);
   $stmt->bindParam(':cantidad', $array['cantidad']);
   $stmt->bindParam(':descripcion', $array['descripcion']);
   $stmt->bindParam(':factura_id', $array['factura_id']);

     $stmt->execute();
}
//insertFactura($file_db, ["cliente" => "LOL", "fecha"=> 1995]);

function selectFactura($file_db) {
   $result = $file_db->query('SELECT * FROM factura');
   $array = [];
   foreach($result as $row) {
       $array[] = $row;
   }
   return $array;
}

function selectProducto($file_db, $fact) {
   $result = $file_db->query('SELECT * FROM producto where factura_id =' . $fact);
   $array = [];
   foreach($result as $row) {
       $array[] = $row;
   }
   return $array;
}

function deleteProd($file_db, $prod) {
   return $file_db->query('DELETE from producto WHERE id = '.$prod);
}
        
 class DBHandlerFact {

        function get($name=null) {
            try {
              $file_db = new PDO('sqlite:tarea4.db');
    
              $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
              die("Unable to connect: " . $e->getMessage());
            }
            try {
                $data = selectFactura($file_db);
                
                echo json_encode($data);
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function post($name=null) {
            try {
              $file_db = new PDO('sqlite:tarea4.db');
    
              $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
              die("Unable to connect: " . $e->getMessage());
            }
            try {
              $_POST=json_decode(file_get_contents('php://input'), True);
              echo var_dump($_POST);
              $cliente = $_POST['cliente'];
              $fecha = $_POST['fecha'];
              
              $array = ["cliente" => $_POST['cliente'], "fecha"=> $_POST['fecha']];
              
              insertFactura($file_db, $array);
              
              $file_db->commit();
              echo 'Successfull';
            } catch (Exception $e) {
              $file_db->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }
    }
    
    class DBHandlerProd {

        function get($name=null) {
            try {
              $file_db = new PDO('sqlite:tarea4.db');
    
              $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
              die("Unable to connect: " . $e->getMessage());
            }
            try {
                $fact = $_GET['fact'];
                $data = selectProducto($file_db, $fact);
                echo json_encode($data);
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function post($name=null) {
            try {
              $file_db = new PDO('sqlite:tarea4.db');
    
              $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
              die("Unable to connect: " . $e->getMessage());
            }
            try {
              $_POST=json_decode(file_get_contents('php://input'), True);
              $array = ["cantidad" => $_POST['cantidad'], "uvalor"=> $_POST['uvalor'], "descripcion"=> $_POST['descripcion'], "factura_id" => $_POST['factura_id']];
              
              insertProducto($file_db, $array);
              
              $file_db->commit();
              echo 'Successfull';
            } catch (Exception $e) {
              $file_db->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }
    }
    
    class DBHandlerDelProd {

        function post($name=null) {
            try {
              $file_db = new PDO('sqlite:tarea4.db');
    
              $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
              die("Unable to connect: " . $e->getMessage());
            }
            try {
              
              $array = ["id" => $_POST['id']];
              
              deleteProd($file_db, $_POST['id']);
              
              $file_db->commit();
              echo 'Successfull';
            } catch (Exception $e) {
              $file_db->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }
    }
Toro::serve(array(
    "/facturas" => "DBHandlerFact",
    "/delProd" => "DBHandlerDelProd",
    "/productos" => "DBHandlerProd"
));