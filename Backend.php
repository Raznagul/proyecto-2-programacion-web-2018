<?php
    require("./Toro.php");

    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:TVPorCable.db');
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

              if($request['method'] === 'put'){
                  return $this->put($request);
              }else if($request['method'] === 'delete'){
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

              if($request['method'] === 'put'){
                  return $this->put($request);
              }else if($request['method'] === 'delete'){
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

              if($request['method'] === 'put'){
                  return $this->put($request);
              }else if($request['method'] === 'delete'){
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

              if($request['method'] === 'put'){
                  return $this->put($request);
              }else if($request['method'] === 'delete'){
                  return $this->delete($request['facturaId']);
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

              if($request['method'] === 'put'){
                  return $this->put($request);
              }else if($request['method'] === 'delete'){
                  return $this->delete($request['facturaId']);
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

              if($request['method'] === 'put'){
                  return $this->put($request);
              }else if($request['method'] === 'delete'){
                  return $this->delete($request['facturaId']);
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

              if($request['method'] === 'put'){
                  return $this->put($request);
              }else if($request['method'] === 'delete'){
                  return $this->delete($request['facturaId']);
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

              if($request['method'] === 'put'){
                  return $this->put($request);
              }else if($request['method'] === 'delete'){
                  return $this->delete($request['facturaId']);
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

    class Producto{
        function get($facturaId=null){
            try {
                if ($facturaId!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("SELECT * FROM producto WHERE idFactura = :facturaId");
                    $stmt->bindParam(':facturaId', $facturaId, PDO::PARAM_STR);
                    $stmt->execute();

                    $data = Array();
                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $data[] = $result;
                    }
                    echo json_encode($data);
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function post(){
            try {
              $request = json_decode(file_get_contents('php://input'), True); 
              
              if($request['method'] == 'delete'){
                 return $this->delete($request['idProducto']);
              }

              $cantidad = (int)$request['cantidad'];
              $descripcion = $request['descripcion'];
              $valorUnitario = (int)$request['valorUnitario'];
              $idFactura = (int)$request['idFactura'];

              $insert = "INSERT INTO producto (cantidad, descripcion, valorUnitario, idFactura) VALUES (:cantidad, :descripcion, :valorUnitario, :idFactura)";
              $stmt = $GLOBALS['file_db']->prepare($insert);
              $stmt->bindParam(':cantidad', $cantidad);
              $stmt->bindParam(':descripcion', $descripcion);
              $stmt->bindParam(':valorUnitario', $valorUnitario);
              $stmt->bindParam(':idFactura', $idFactura);

              $GLOBALS['file_db']->beginTransaction();
              $stmt->execute();
              $GLOBALS['file_db']->commit();

              echo json_encode($request); 
              
            } catch (Exception $e) {
              $GLOBALS['file_db']->rollBack();
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($idProducto=null){
            try {
                if ($idProducto!=null) {
                    $stmt = $GLOBALS['file_db']->prepare("DELETE from producto where id = :idProducto");
                    $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode($idProducto); 
                } else {
                    echo "";
                }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    class RelacionProdFact{
        function post(){
            try {
                $request = json_decode(file_get_contents('php://input'), True); 

                if($request['method'] === 'delete'){
                    return $this->delete($request['facturaId']);
                }

                echo json_encode($request);
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }

        function delete($idFactura=null){
            try {
                
                if ($idFactura!=null) {
                        $stmt = $GLOBALS['file_db']->prepare("DELETE from producto where idFactura = :idFactura");
                        $stmt->bindParam(':idFactura', $idFactura, PDO::PARAM_STR);
                        $stmt->execute();
                        echo json_encode($idFactura); 
                    } else {
                        echo json_encode(""); 
                    }
                
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    Toro::serve(array(
        "/factura" => "Factura",
        "/factura/:alpha" => "Factura",
        "/producto" => "Producto",
        "/producto/:alpha" => "Producto",
        "/relacionProdFact" => "RelacionProdFact",
        "/relacionProdFact/:alpha" => "RelacionProdFact",
    ));
?>