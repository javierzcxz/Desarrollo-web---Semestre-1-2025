<?php
// api/v1/auth/register/index.php

include_once __DIR__ . '/../../version1.php';

if ($_method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

include_once __DIR__ . '/../../conexion.php';

function hashPassword($plain) {
    // DEMO: sin hash, misma clave
    return $plain;
}

$body = json_decode(file_get_contents("php://input", true), true);

$username   = trim($body['username'] ?? '');
$password   = (string)($body['password'] ?? '');
$persona_id = isset($body['persona_id']) ? (int)$body['persona_id'] : 0; // opcional

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan campos: username, password']);
    exit;
}

$cx = new Conexion();
$db = $cx->getConnection();

// ¿Username ya existe?
$sql = "SELECT id FROM usuario WHERE username = ? LIMIT 1";
$st  = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($st, "s", $username);
mysqli_stmt_execute($st);
$rs = mysqli_stmt_get_result($st);
if (mysqli_fetch_assoc($rs)) {
    http_response_code(409);
    echo json_encode(['error' => 'Usuario ya existe']);
    exit;
}
mysqli_free_result($rs);
mysqli_stmt_close($st);

// Transacción: solo insertamos usuario.
// Los triggers crean persona (si corresponde) y billetera.
mysqli_begin_transaction($db);

try {
    $sql = "INSERT INTO usuario (username, password, persona_id, activo)
            VALUES (?, ?, ?, 1)";
    $st = mysqli_prepare($db, $sql);

    // Si persona_id viene <= 0, dejamos 0 para que el trigger cree la persona.
    $pwd = hashPassword($password);
    mysqli_stmt_bind_param($st, "ssi", $username, $pwd, $persona_id);
    if (!mysqli_stmt_execute($st)) {
        throw new Exception(mysqli_error($db));
    }

    $usuario_id = (int)mysqli_insert_id($db);
    mysqli_stmt_close($st);

    // Recuperamos el usuario con el persona_id que haya puesto el trigger
    $sql = "SELECT id, username, persona_id, activo
            FROM usuario
            WHERE id = ?
            LIMIT 1";
    $st = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($st, "i", $usuario_id);
    mysqli_stmt_execute($st);
    $rs  = mysqli_stmt_get_result($st);
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    if ($rs) mysqli_free_result($rs);
    mysqli_stmt_close($st);

    if (!$row) {
        throw new Exception("No se pudo leer el usuario recién creado");
    }

    mysqli_commit($db);

    http_response_code(201);
    echo json_encode([
        'success' => 'Usuario creado',
        'user' => [
            'id'         => (int)$row['id'],
            'username'   => $row['username'],
            'persona_id' => (int)$row['persona_id'],
            'activo'     => (bool)$row['activo']
        ]
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    mysqli_rollback($db);
    http_response_code(500);
    echo json_encode([
        'error' => 'No se pudo crear usuario',
        'mysql' => $e->getMessage()
    ]);
}
