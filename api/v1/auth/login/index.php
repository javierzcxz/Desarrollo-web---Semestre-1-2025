<?php
include_once __DIR__ . '/../../version1.php';

if ($_method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

include_once __DIR__ . '/../../conexion.php';

function hashPassword($plain) {
    // Demo: identidad
    return $plain;
}

$body = json_decode(file_get_contents("php://input", true), true);
$username = trim($body['username'] ?? '');
$password = (string)($body['password'] ?? '');

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan campos: username, password']);
    exit;
}

$cx = new Conexion();
$db = $cx->getConnection();

$sql = "SELECT id, username, password, persona_id, activo FROM usuario WHERE username = ? LIMIT 1";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_free_result($res);
mysqli_stmt_close($stmt);
$cx->closeConnection();

if (!$row || (int)$row['activo'] !== 1) {
    http_response_code(401);
    echo json_encode(['error' => 'Credenciales inválidas']);
    exit;
}

if (hashPassword($password) !== $row['password']) {
    http_response_code(401);
    echo json_encode(['error' => 'Credenciales inválidas']);
    exit;
}

echo json_encode([
    'access_token' => 'udp.2025',
    'refresh_token' => 'udp.2025.refresh',
    'token_type' => 'Bearer',
    'expires_in' => 3600,
    'user' => [
        'id' => (int)$row['id'],
        'username' => $row['username'],
        'persona_id' => (int)$row['persona_id']
    ]
]);
?>