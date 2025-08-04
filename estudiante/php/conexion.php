<?php
// Configuración de la base de datos
$db_host = 'localhost'; // O la IP de tu servidor de BD
$db_name = 'pilatos';
$db_user = 'root'; // Usuario por defecto en XAMPP
$db_pass = '';     // Contraseña por defecto en XAMPP

// Encabezados para evitar el almacenamiento en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json'); // La mayoría de scripts devolverán JSON

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En un entorno de producción, no deberías mostrar errores detallados.
    // Registra el error en un archivo de log.
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']));
}
?>