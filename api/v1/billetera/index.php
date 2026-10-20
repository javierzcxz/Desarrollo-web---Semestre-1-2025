<?php
// 1. Incluimos la configuración general (donde se define $_token_get y $_authorization)
include_once '../version1.php';

// 2. Incluimos conexión y modelo
include_once '../conexion.php';
include_once 'modelo.php';

$modelo = new Billetera();

switch ($_method) {
    // =================================================
    // MÉTODO GET (Ver saldo)
    // =================================================
    case 'GET':
        if ($_authorization === $_token_get) {
            if ($_parametroID) {
                $unico = $modelo->getById($_parametroID);
                if($unico){
                    http_response_code(200);
                    echo json_encode($unico);
                }else{
                    http_response_code(404);
                    echo json_encode(['error' => 'No Encontrado']);
                }
            } else { 
                $lista = $modelo->getAll();
                http_response_code(200);
                echo json_encode($lista);
            }
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'Prohibido: Token inválido o ausente']);
        }
        break;

    // =================================================
    // MÉTODO POST (Cargar / Retirar)//revisar
    // =================================================
    case 'POST':
        // 1. VERIFICACIÓN DE SEGURIDAD (Igual que el código de tu profe)
        if ($_authorization === $_token_get) {
            
            // Leemos el JSON que envía el JS
            $body = json_decode(file_get_contents("php://input"), true);

            // Obtenemos los datos (usando arrays asociativos)
            $accion = $body['accion'] ?? ''; 
            $monto = $body['monto'] ?? 0;
            // Usamos el usuario que viene del JS (o el id 1 por defecto para pruebas)
            $usuario_id = $body['usuario_id'] ?? 1; 

            // Validación básica
            if ($monto <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'El monto debe ser mayor a 0']);
                die(); // Usamos die() como tu profe para cortar ejecución
            }

            try {
                // Lógica de negocio
                if ($accion === 'cargar') {
                    // true indica que es CARGA
                    $resultado = $modelo->modificarSaldo($usuario_id, $monto, true); 
                    
                    http_response_code(200); // O 201 si lo consideras creación
                    echo json_encode([
                        'mensaje' => 'Carga realizada con éxito', 
                        'saldo' => $resultado['nuevo_saldo']
                    ]);
                    die();
                } 
                elseif ($accion === 'retirar') {
                    // false indica que es RETIRO
                    $resultado = $modelo->modificarSaldo($usuario_id, $monto, false); 
                    
                    http_response_code(200);
                    echo json_encode([
                        'mensaje' => 'Retiro realizado con éxito', 
                        'saldo' => $resultado['nuevo_saldo']
                    ]);
                    die();
                } 
                else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Accion no válida. Use "cargar" o "retirar"']);
                    die();
                }
            } catch (Exception $e) {
                // Error del servidor (ej. base de datos o saldo insuficiente)
                http_response_code(500); // O 409 Conflict
                echo json_encode(['error' => $e->getMessage()]);
                die();
            }

        } else {
            // SI EL TOKEN NO COINCIDE (El error que sospechabas)
            http_response_code(403);
            echo json_encode(['error' => 'No autorizado: Token inválido.']);
            die();
        }
        break;

    // =================================================
    // DEFAULT (Métodos no soportados)
    // =================================================
    default:
        http_response_code(501);
        echo json_encode(['error' => 'Método [' . $_method . '] no implementado']);
        break;
}
?>