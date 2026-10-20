<?php

require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/modelo.php';


$_method = $_SERVER['REQUEST_METHOD'];
$_uri = $_SERVER['REQUEST_URI'];
$_partes = explode('/', trim($_uri, '/'));


$tabla = end($_partes);
if (strpos($tabla, '?') !== false) {
    $tabla = explode('?', $tabla)[0];
}

// 3. Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

$modelo = new Modelo();

switch ($tabla) {
    case 'usuario':
        if ($_method == 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (isset($input['correo']) && isset($input['password'])) {
                try {
                    $db = (new Conexion())->getConexion();
                    
                    // Validar si ya existe
                    $stmt = $db->prepare("SELECT id FROM usuario WHERE correo = ?");
                    $stmt->execute([$input['correo']]);
                    if($stmt->fetch()){
                        http_response_code(400);
                        cho json_encode(["error" => "El correo ya existe"]);
                        exit;
                    }


                    $sql = "INSERT INTO usuario (nombre, correo, password, alias, id_tipo_usuario) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $db->prepare($sql);
                    
                    $alias = isset($input['alias']) ? $input['alias'] : 'Usuario';
                    $nombre = isset($input['nombre']) ? $input['nombre'] : 'Sin nombre';
                    $tipoUsuario = 2; 
                    
                    if($stmt->execute([$nombre, $input['correo'], $input['password'], $alias, $tipoUsuario])) {
                        http_response_code(201);
                        echo json_encode(["mensaje" => "Usuario creado"]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["error" => "Error al insertar en BD"]);
                    }
                    
                } catch (Exception $e) {
                    http_response_code(500);

                    if(strpos($e->getMessage(), 'foreign key') !== false){
                        echo json_encode(["error" => "El tipo de usuario 2 no existe en la BD. Prueba cambiarlo a 1 en el código."]);
                    } else {
                        echo json_encode(["error" => $e->getMessage()]);
                    }
                }
            } else {
                echo json_encode(["error" => "Faltan datos"]);
            }
        }
        else if ($_method == 'GET') {

            try {
                $db = (new Conexion())->getConexion();
                $stmt = $db->prepare("SELECT * FROM usuario");
                $stmt->execute();
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            } catch (Exception $e) {
                echo json_encode(["error" => $e->getMessage()]);
            }
        }
        break;

    default:
        echo json_encode(["mensaje" => "Endpoint activo: " . $tabla]);
        break;
}
?>