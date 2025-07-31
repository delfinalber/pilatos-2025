<?php
// Configuración de la base de datos
$db_host = 'localhost'; // O la IP del servidor de tu base de datos
$db_user = 'root';      // Tu usuario de la base de datos
$db_pass = '';          // Tu contraseña
$db_name = 'pilatos';   // El nombre de la base de datos

// Crear la conexión usando MySQLi
$conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar si la conexión falló
if ($conexion->connect_error) {
    // Es una mala práctica mostrar el error exacto en producción, pero útil para depurar.
    // die() detiene la ejecución del script.
    die("Error de conexión: " . $conexion->connect_error);
}

// Opcional: Establecer el juego de caracteres a UTF-8
$conexion->set_charset("utf8");
?>