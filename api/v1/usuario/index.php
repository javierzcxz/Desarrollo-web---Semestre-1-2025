<?php 
header("Content-Type: application/json; charset=utf-8");

session_set_cookie_params(0, '/');
session_name('BetrayalSession');
session_start();

include_once '../conexion.php';
$cn = new Conexion();
$db = $cn->getConnection();

$_method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) $data = $_POST;

switch ($_method) {
    case 'POST':
        $accion = $data['accion'] ?? '';

        if ($accion === 'depositar') {
            if (!isset($_SESSION['usuario'])) {
                echo json_encode(['error' => 'No has iniciado sesión']);
                exit;
            }

            $monto = intval($data['monto'] ?? 0);
            $usuario_id = $_SESSION['usuario']['id'];

            if ($monto <= 0) {
                echo json_encode(['error' => 'Monto inválido']);
                exit;
            }

            $stmt = $db->prepare("UPDATE billetera SET saldo = saldo + ? WHERE usuario_id = ?");
            $stmt->bind_param("ii", $monto, $usuario_id);
            
            if ($stmt->execute()) {
                $_SESSION['usuario']['saldo'] += $monto;
                $nuevoSaldo = $_SESSION['usuario']['saldo'];

                echo json_encode([
                    'mensaje' => 'Carga exitosa',
                    'nuevo_saldo' => $nuevoSaldo
                ]);
            } else {
                echo json_encode(['error' => 'Error al actualizar saldo']);
            }
            $stmt->close();
            break;
        }

        if ($accion === 'register') {
            $correo = trim($data['correo'] ?? '');
            $nombre = trim($data['nombre'] ?? '');
            $alias = trim($data['alias'] ?? '');
            $clave = $data['clave'] ?? '';

            if (!$correo || !$clave) {
                echo json_encode(['error' => 'Faltan datos']);
                exit;
            }

            $username = $correo;
            $passwordHash = md5($clave); 

            $stmt = $db->prepare("SELECT id FROM usuario WHERE username = ? AND activo = 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo json_encode(['error' => 'El usuario ya existe']);
                exit;
            }
            $stmt->close();

            $db->begin_transaction();
            try {
                $fecha = "2000-01-01";
                $stmt = $db->prepare("INSERT INTO persona (fecha_nacimiento, activo) VALUES (?, 1)");
                $stmt->bind_param("s", $fecha);
                $stmt->execute();
                $persona_id = $stmt->insert_id;
                $stmt->close();

                $stmt = $db->prepare("INSERT INTO usuario (username, password, persona_id, activo) VALUES (?, ?, ?, 1)");
                $stmt->bind_param("ssi", $username, $passwordHash, $persona_id);
                $stmt->execute();
                $usuario_id = $stmt->insert_id;
                $stmt->close();

                $saldo_inicial = 10000;
                $stmt = $db->prepare("INSERT INTO billetera (usuario_id, saldo, activo) VALUES (?, ?, 1)");
                $stmt->bind_param("ii", $usuario_id, $saldo_inicial);
                $stmt->execute();
                $stmt->close();

                $db->commit();
                echo json_encode(['mensaje' => 'Registrado correctamente']);
            } catch (Exception $e) {
                $db->rollback();
                echo json_encode(['error' => 'Error interno']);
            }
            break;
        }

        if ($accion === 'login') {
            $correo = trim($data['correo'] ?? '');
            $clave = $data['clave'] ?? '';
            $hash = md5($clave);

            $stmt = $db->prepare("
                SELECT u.id, u.username, u.persona_id, b.saldo 
                FROM usuario u 
                JOIN billetera b ON b.usuario_id = u.id 
                WHERE u.username = ? AND u.password = ? AND u.activo = 1
            ");
            $stmt->bind_param("ss", $correo, $hash);
            $stmt->execute();
            $res = $stmt->get_result();
            $user = $res->fetch_assoc();

            if (!$user) {
                echo json_encode(['error' => 'Credenciales inválidas']);
                exit;
            }

            $_SESSION['usuario'] = $user;
            echo json_encode(['mensaje' => 'Login correcto', 'usuario' => $user]);
            break;
        }

        if ($accion === 'logout') {
            session_unset();
            session_destroy();
            echo json_encode(['mensaje' => 'Logout correcto']);
            break;
        }

        echo json_encode(['error' => 'Acción no válida']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>