<?php
$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$nombre_db = "pilatos";

// Crear la conexión y asignarla a la variable $conexion
$conexion = new mysqli($servidor, $usuario_db, $password_db, $nombre_db);

// Verificar si hubo un error en la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>