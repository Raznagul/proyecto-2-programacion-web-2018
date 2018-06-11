<?php
    require("./Toro.php");

    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:DB/TVPorCable.db');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                                PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    class AmplificadorSenal {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM amplificador_senal");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              if(isset($request['method']) && $request['method'] === 'put'){
                  return $this->put($request);
              }else if(isset($request['method']) && $request['method'] === 'delete'){
                  return $this->delete($request['amplificado_senal_id']);
              }

              $tipo_amplificado_senal = $request['tipo_amplificado_senal'];
              $numero_serie = $request['numero_serie'];
              $fecha_instalacion = $request['fecha_instalacion'];
              $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
              $marca = $request['marca'];
              $modelo = $request['modelo'];

              $insert = "INSERT INTO amplificador_senal (tipo_amplificado_senal, numero_serie, fecha_instalacion, fecha_proximo_mantenimiento, marca, modelo) VALUES (:tipo_amplificado_senal, :numero_serie, :fecha_instalacion, :fecha_proximo_mantenimiento, :marca, :modelo)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':tipo_amplificado_senal', $tipo_amplificado_senal);
              $stmt->bindParam(':numero_serie', $numero_serie);
              $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
              $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
              $stmt->bindParam(':marca', $marca);
              $stmt->bindParam(':modelo', $modelo);
              $stmt->execute();

              $stmt = $GLOBALS['file_db']->prepare("SELECT last_insert_rowid() as row");
              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function put($request){
            try {
                if ($request!=null) {
                    $amplificado_senal_id = $request['amplificado_senal_id'];
                    $tipo_amplificado_senal = $request['tipo_amplificado_senal'];
                    $numero_serie = $request['numero_serie'];
                    $fecha_instalacion = $request['fecha_instalacion'];
                    $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
                    $marca = $request['marca'];
                    $modelo = $request['modelo'];

                    $update = "UPDATE amplificador_senal SET tipo_amplificado_senal = :tipo_amplificado_senal, numero_serie = :numero_serie, fecha_instalacion = :fecha_instalacion, fecha_proximo_mantenimiento = :fecha_proximo_mantenimiento, marca = :marca, modelo = :modelo where amplificado_senal_id = :amplificado_senal_id";
                    
                    $stmt = $GLOBALS['file_db']->prepare($update);
                    $stmt->bindParam(':amplificado_senal_id', $amplificado_senal_id);
                    $stmt->bindParam(':tipo_amplificado_senal', $tipo_amplificado_senal);
                    $stmt->bindParam(':numero_serie', $numero_serie);
                    $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
                    $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
                    $stmt->bindParam(':marca', $marca);
                    $stmt->bindParam(':modelo', $modelo);

                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($amplificado_senal_id=null){
            try {
                if ($amplificado_senal_id!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from amplificador_senal where amplificado_senal_id = :amplificado_senal_id");
                    $stmt->bindParam(':amplificado_senal_id', $amplificado_senal_id, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class CajaDistribucion {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM caja_distribucion");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              if(isset($request['method']) && $request['method'] === 'put'){
                  return $this->put($request);
              }else if(isset($request['method']) && $request['method'] === 'delete'){
                  return $this->delete($request['caja_distribucion_id']);
              }

              $conectores_totales = $request['conectores_totales'];
              $conectores_libres = $request['conectores_libres'];
              $poste_id = $request['poste_id'];
              $numero_serie = $request['numero_serie'];
              $fecha_instalacion = $request['fecha_instalacion'];
              $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
              $marca = $request['marca'];
              $modelo = $request['modelo'];

              $insert = "INSERT INTO caja_distribucion (conectores_totales, conectores_libres, poste_id, numero_serie, fecha_instalacion, fecha_proximo_mantenimiento, marca, modelo) VALUES (:conectores_totales, :conectores_libres, :poste_id, :numero_serie, :fecha_instalacion, :fecha_proximo_mantenimiento, :marca, :modelo)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':tipo_amplificado_senal', $tipo_amplificado_senal);
              $stmt->bindParam(':numero_serie', $numero_serie);
              $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
              $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
              $stmt->bindParam(':marca', $marca);
              $stmt->bindParam(':modelo', $modelo);
              $stmt->execute();

              $stmt = $GLOBALS['file_db']->prepare("SELECT last_insert_rowid() as row");
              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function put($request){
            try {
                if ($request!=null) {
                    $caja_distribucion_id = $request['caja_distribucion_id'];
                    $conectores_totales = $request['conectores_totales'];
                    $conectores_libres = $request['conectores_libres'];
                    $poste_id = $request['poste_id'];
                    $numero_serie = $request['numero_serie'];
                    $fecha_instalacion = $request['fecha_instalacion'];
                    $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
                    $marca = $request['marca'];
                    $modelo = $request['modelo'];

                    $update = "UPDATE caja_distribucion SET conectores_totales = :conectores_totales, conectores_libres = :conectores_libres, poste_id = :poste_id, numero_serie = :numero_serie, fecha_instalacion = :fecha_instalacion, fecha_proximo_mantenimiento = :fecha_proximo_mantenimiento , marca = :marca , modelo = :modelo where caja_distribucion_id = :caja_distribucion_id";
                    
                    $stmt = $GLOBALS['file_db']->prepare($update);
                    $stmt->bindParam(':caja_distribucion_id', $caja_distribucion_id);
                    $stmt->bindParam(':conectores_totales', $conectores_totales);
                    $stmt->bindParam(':conectores_libres', $conectores_libres);
                    $stmt->bindParam(':poste_id', $poste_id);
                    $stmt->bindParam(':numero_serie', $numero_serie);
                    $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
                    $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
                    $stmt->bindParam(':marca', $marca);
                    $stmt->bindParam(':modelo', $modelo);

                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($caja_distribucion_id=null){
            try {
                if ($caja_distribucion_id!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from caja_distribucion where caja_distribucion_id = :caja_distribucion_id");
                    $stmt->bindParam(':caja_distribucion_id', $caja_distribucion_id, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class Cliente {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM cliente");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              if(isset($request['method']) && $request['method'] === 'put'){
                  return $this->put($request);
              }else if(isset($request['method']) && $request['method'] === 'delete'){
                  return $this->delete($request['cliente_id']);
              }

              $nombre = $request['nombre'];
              $telefono = $request['telefono'];
              $direccion = $request['direccion'];
              $cedula = $request['cedula'];
              $pendiente_cobro = $request['pendiente_cobro'];
              $tipo_servicio = $request['tipo_servicio'];

              $insert = "INSERT INTO cliente (nombre, telefono, direccion, cedula, pendiente_cobro, tipo_servicio) VALUES (:nombre, :telefono, :direccion, :cedula, :pendiente_cobro, :tipo_servicio)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':nombre', $nombre);
              $stmt->bindParam(':telefono', $telefono);
              $stmt->bindParam(':direccion', $direccion);
              $stmt->bindParam(':cedula', $cedula);
              $stmt->bindParam(':pendiente_cobro', $pendiente_cobro);
              $stmt->bindParam(':tipo_servicio', $tipo_servicio);
              $stmt->execute();

              $stmt = $GLOBALS['file_db']->prepare("SELECT last_insert_rowid() as row");
              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function put($request){
            try {
                if ($request!=null) {
                    $cliente_id = $request['cliente_id'];
                    $nombre = $request['nombre'];
                    $telefono = $request['telefono'];
                    $direccion = $request['direccion'];
                    $cedula = $request['cedula'];
                    $pendiente_cobro = $request['pendiente_cobro'];
                    $tipo_servicio = $request['tipo_servicio'];


                    $update = "UPDATE cliente SET nombre = :nombre, telefono = :telefono, direccion = :direccion, cedula = :cedula, pendiente_cobro = :pendiente_cobro, tipo_servicio = :tipo_servicio where cliente_id = :cliente_id";
                    
                    $stmt = $GLOBALS['file_db']->prepare($update);
                    $stmt->bindParam(':cliente_id', $cliente_id);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':telefono', $telefono);
                    $stmt->bindParam(':direccion', $direccion);
                    $stmt->bindParam(':cedula', $cedula);
                    $stmt->bindParam(':pendiente_cobro', $pendiente_cobro);
                    $stmt->bindParam(':tipo_servicio', $tipo_servicio);

                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($cliente_id=null){
            try {
                if ($cliente_id!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from cliente where cliente_id = :cliente_id");
                    $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class GeneradorSenal {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM generador_senal");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              if(isset($request['method']) && $request['method'] === 'put'){
                  return $this->put($request);
              }else if(isset($request['method']) && $request['method'] === 'delete'){
                  return $this->delete($request['generador_senal_id']);
              }

              $capacidad_salida = $request['capacidad_salida'];
              $numero_serie = $request['numero_serie'];
              $fecha_instalacion = $request['fecha_instalacion'];
              $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
              $marca = $request['marca'];
              $modelo = $request['modelo'];
              $zona_id = $request['zona_id'];

              $insert = "INSERT INTO generador_senal (capacidad_salida, numero_serie, fecha_instalacion, fecha_proximo_mantenimiento, marca, modelo, zona_id) VALUES (:capacidad_salida, :numero_serie, :fecha_instalacion, :fecha_proximo_mantenimiento, :marca, :modelo, :zona_id)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':capacidad_salida', $capacidad_salida);
              $stmt->bindParam(':numero_serie', $numero_serie);
              $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
              $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
              $stmt->bindParam(':marca', $marca);
              $stmt->bindParam(':modelo', $modelo);
              $stmt->bindParam(':zona_id', $zona_id);
              $stmt->execute();

              $stmt = $GLOBALS['file_db']->prepare("SELECT last_insert_rowid() as row");
              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function put($request){
            try {
                if ($request!=null) {
                    $generador_senal_id = $request['generador_senal_id'];
                    $capacidad_salida = $request['capacidad_salida'];
                    $numero_serie = $request['numero_serie'];
                    $fecha_instalacion = $request['fecha_instalacion'];
                    $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
                    $marca = $request['marca'];
                    $modelo = $request['modelo'];
                    $zona_id = $request['zona_id'];

                    $update = "UPDATE generador_senal SET capacidad_salida = :capacidad_salida, numero_serie = :numero_serie, fecha_instalacion = :fecha_instalacion, fecha_proximo_mantenimiento = :fecha_proximo_mantenimiento, marca = :marca, modelo = :modelo, zona_id = :zona_id where generador_senal_id = :generador_senal_id";
                    
                    $stmt = $GLOBALS['file_db']->prepare($update);
                    $stmt->bindParam(':generador_senal_id', $generador_senal_id);
                    $stmt->bindParam(':capacidad_salida', $capacidad_salida);
                    $stmt->bindParam(':numero_serie', $numero_serie);
                    $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
                    $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
                    $stmt->bindParam(':marca', $marca);
                    $stmt->bindParam(':modelo', $modelo);
                    $stmt->bindParam(':zona_id', $zona_id);

                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($generador_senal_id=null){
            try {
                if ($generador_senal_id!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from generador_senal where generador_senal_id = :generador_senal_id");
                    $stmt->bindParam(':generador_senal_id', $generador_senal_id, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class LineaConexion {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM linea_conexion");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              if(isset($request['method']) && $request['method'] === 'put'){
                  return $this->put($request);
              }else if(isset($request['method']) && $request['method'] === 'delete'){
                  return $this->delete($request['linea_conexion_id']);
              }

              $numero_serie = $request['numero_serie'];
              $fecha_instalacion = $request['fecha_instalacion'];
              $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
              $marca = $request['marca'];
              $modelo = $request['modelo'];
              $tipo_linea_conexion = $request['tipo_linea_conexion'];
              $conexion_a = $request['conexion_a'];
              $conexion_b = $request['conexion_b'];

              $insert = "INSERT INTO linea_conexion (numero_serie, fecha_instalacion, fecha_proximo_mantenimiento, marca, modelo, tipo_linea_conexion, conexion_a, conexion_b) VALUES (:numero_serie, :fecha_instalacion, :fecha_proximo_mantenimiento, :marca, :modelo, :tipo_linea_conexion, :conexion_a, :conexion_b)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':numero_serie', $numero_serie);
              $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
              $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
              $stmt->bindParam(':marca', $marca);
              $stmt->bindParam(':modelo', $modelo);
              $stmt->bindParam(':tipo_linea_conexion', $tipo_linea_conexion);
              $stmt->bindParam(':conexion_a', $conexion_a);
              $stmt->bindParam(':conexion_b', $conexion_b);
              $stmt->execute();

              $stmt = $GLOBALS['file_db']->prepare("SELECT last_insert_rowid() as row");
              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function put($request){
            try {
                if ($request!=null) {
                    $linea_conexion_id = $request['linea_conexion_id'];
                    $numero_serie = $request['numero_serie'];
                    $fecha_instalacion = $request['fecha_instalacion'];
                    $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
                    $marca = $request['marca'];
                    $modelo = $request['modelo'];
                    $tipo_linea_conexion = $request['tipo_linea_conexion'];
                    $conexion_a = $request['conexion_a'];
                    $conexion_b = $request['conexion_b'];

                    $update = "UPDATE linea_conexion SET numero_serie = :numero_serie, fecha_instalacion = :fecha_instalacion, fecha_proximo_mantenimiento = :fecha_proximo_mantenimiento, marca = :marca, modelo = :modelo, tipo_linea_conexion = :tipo_linea_conexion, conexion_a = :conexion_a, conexion_b = :conexion_b where linea_conexion_id = :linea_conexion_id";
                    
                    $stmt = $GLOBALS['file_db']->prepare($update);
                    $stmt->bindParam(':linea_conexion_id', $linea_conexion_id);
                    $stmt->bindParam(':numero_serie', $numero_serie);
                    $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
                    $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
                    $stmt->bindParam(':marca', $marca);
                    $stmt->bindParam(':modelo', $modelo);
                    $stmt->bindParam(':tipo_linea_conexion', $tipo_linea_conexion);
                    $stmt->bindParam(':conexion_a', $conexion_a);
                    $stmt->bindParam(':conexion_b', $conexion_b);

                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($linea_conexion_id=null){
            try {
                if ($linea_conexion_id!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from linea_conexion where linea_conexion_id = :linea_conexion_id");
                    $stmt->bindParam(':linea_conexion_id', $linea_conexion_id, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class Poste {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM poste");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              if(isset($request['method']) && $request['method'] === 'put'){
                  return $this->put($request);
              }else if(isset($request['method']) && $request['method'] === 'delete'){
                  return $this->delete($request['poste_id']);
              }

              $numero_serie = $request['numero_serie'];
              $fecha_instalacion = $request['fecha_instalacion'];
              $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
              $marca = $request['marca'];
              $modelo = $request['modelo'];

              $insert = "INSERT INTO poste (numero_serie, fecha_instalacion, fecha_proximo_mantenimiento, marca, modelo) VALUES (:numero_serie, :fecha_instalacion, :fecha_proximo_mantenimiento, :marca, :modelo)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':numero_serie', $numero_serie);
              $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
              $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
              $stmt->bindParam(':marca', $marca);
              $stmt->bindParam(':modelo', $modelo);
              $stmt->execute();

              $stmt = $GLOBALS['file_db']->prepare("SELECT last_insert_rowid() as row");
              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function put($request){
            try {
                if ($request!=null) {
                    $amplificado_senal_id = $request['poste_id'];
                    $numero_serie = $request['numero_serie'];
                    $fecha_instalacion = $request['fecha_instalacion'];
                    $fecha_proximo_mantenimiento = $request['fecha_proximo_mantenimiento'];
                    $marca = $request['marca'];
                    $modelo = $request['modelo'];

                    $update = "UPDATE poste SET numero_serie = :numero_serie, fecha_instalacion = :fecha_instalacion, fecha_proximo_mantenimiento = :fecha_proximo_mantenimiento, marca = :marca, modelo = :modelo where poste_id = :poste_id";
                    
                    $stmt = $GLOBALS['file_db']->prepare($update);
                    $stmt->bindParam(':poste_id', $amplificado_senal_id);
                    $stmt->bindParam(':numero_serie', $numero_serie);
                    $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
                    $stmt->bindParam(':fecha_proximo_mantenimiento', $fecha_proximo_mantenimiento);
                    $stmt->bindParam(':marca', $marca);
                    $stmt->bindParam(':modelo', $modelo);

                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($poste_id=null){
            try {
                if ($poste_id!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from poste where poste_id = :poste_id");
                    $stmt->bindParam(':poste_id', $poste_id, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class Zona {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM zona");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              if(isset($request['method']) && $request['method'] === 'put'){
                  return $this->put($request);
              }else if(isset($request['method']) && $request['method'] === 'delete'){
                  return $this->delete($request['zona_id']);
              }

              $tipo_zona = $request['tipo_zona'];

              $insert = "INSERT INTO zona (tipo_zona) VALUES (:tipo_zona)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':tipo_zona', $tipo_zona);
              $stmt->execute();

              $stmt = $GLOBALS['file_db']->prepare("SELECT last_insert_rowid() as row");
              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function put($request){
            try {
                if ($request!=null) {
                    $zona_id = $request['zona_id'];
                    $tipo_zona = $request['tipo_zona'];

                    $update = "UPDATE zona SET tipo_zona = :tipo_zona where zona_id = :zona_id";
                    
                    $stmt = $GLOBALS['file_db']->prepare($update);
                    $stmt->bindParam(':zona_id', $zona_id);
                    $stmt->bindParam(':tipo_zona', $tipo_zona);

                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($zona_id=null){
            try {
                if ($zona_id!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from zona where zona_id = :zona_id");
                    $stmt->bindParam(':zona_id', $zona_id, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class Usuario {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM usuario");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              if(isset($request['method']) && $request['method'] === 'put'){
                  return $this->put($request);
              }else if(isset($request['method']) && $request['method'] === 'delete'){
                  return $this->delete($request['usuario_id']);
              }

              $nombre = $request['nombre'];
              $contrasena = $request['contrasena'];

              $insert = "INSERT INTO usuario (nombre, contrasena) VALUES (:nombre, :contrasena)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':nombre', $nombre);
              $stmt->bindParam(':contrasena', $contrasena);
              $stmt->execute();

              $stmt = $GLOBALS['file_db']->prepare("SELECT last_insert_rowid() as row");
              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function put($request){
            try {
                if ($request!=null) {
                    $usuario_id = $request['usuario_id'];
                    $nombre = $request['nombre'];
                    $contrasena = $request['contrasena'];

                    $update = "UPDATE usuario SET nombre = :nombre, contrasena = :contrasena where usuario_id = :usuario_id";
                    
                    $stmt = $GLOBALS['file_db']->prepare($update);
                    $stmt->bindParam(':usuario_id', $usuario_id);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':contrasena', $contrasena);

                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($usuario_id=null){
            try {
                if ($usuario_id!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from usuario where usuario_id = :usuario_id");
                    $stmt->bindParam(':usuario_id', $zona_id, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode([]);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class UsuarioValidation {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM usuario");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }

        function post() {
            try {
              $request = json_decode(file_get_contents('php://input'), True); 

              $nombre = $request['nombre'];
              $contrasena = $request['contrasena'];

              $select = "SELECT * FROM usuario WHERE nombre = :nombre AND contrasena = :contrasena";
              $stmt = $GLOBALS['file_db']->prepare($select);
              $stmt->bindParam(':nombre', $nombre);
              $stmt->bindParam(':contrasena', $contrasena);
              $stmt->execute();

              $stmt->execute();
              $data = Array();
              while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $result;
              }
              echo json_encode($data);

            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class Mantenimiento {

        function get() {
            try {
                $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM generador_senal WHERE fecha_proximo_mantenimiento >= date('now','start of month') AND fecha_proximo_mantenimiento <= date('now','start of month','+1 month')");
                $stmt->execute();

                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
            }
        }
    }

    Toro::serve(array(
        "/amplificadorsenal" => "AmplificadorSenal",
        "/amplificadorsenal/:alpha" => "AmplificadorSenal",
        "/cajadistribucion" => "CajaDistribucion",
        "/cajadistribucion/:alpha" => "CajaDistribucion",
        "/cliente" => "Cliente",
        "/cliente/:alpha" => "Cliente",
        "/generadorsenal" => "GeneradorSenal",
        "/generadorsenal/:alpha" => "GeneradorSenal",
        "/lineaconexion" => "LineaConexion",
        "/lineaconexion/:alpha" => "LineaConexion",
        "/poste" => "Poste",
        "/poste/:alpha" => "Poste",
        "/zona" => "Zona",
        "/zona/:alpha" => "Zona",
        "/usuario" => "Usuario",
        "/usuario/:alpha" => "Usuario",
        "/usuariovalidation" => "UsuarioValidation",
        "/usuariovalidation/:alpha" => "UsuarioValidation",
        "/data/mantenimiento/mes" => "Mantenimiento",
    ));
?>