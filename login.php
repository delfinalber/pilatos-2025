<?php
session_start();
header('Content-Type: application/json');

// Cambia estos valores por los de tu entorno real:
$DB_HOST = 'localhost';
$DB_NAME = 'pilatos';
$DB_USER = 'root';
$DB_PASS = '';

// Recoger datos del POST
$usuario = filter_input(INPUT_POST, 'usuario', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

if (!$usuario || !$password) {
    echo json_encode(['ok'=>false, 'error'=>'Datos inválidos']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $stmt = $pdo->prepare("SELECT id_sesion FROM sesion WHERE usuario = ? AND password = ?");
    // Como no se especifica hash, se hace comparación directa
    $stmt->execute([$usuario, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $usuario;
        echo json_encode(['ok'=>true]);
    } else {
        echo json_encode(['ok'=>false, 'error'=>'Usuario o contraseña incorrecta']);
    }
} catch (Exception $e) {
    echo json_encode(['ok'=>false, 'error'=>'Error de conexión']);
    exit;
}
