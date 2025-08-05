<?php
session_start();
require 'config.php';

// Validar y limpiar datos contra inyección SQL
$cod_est = htmlspecialchars(trim($_POST['cod_estudiante']));
$nombre = htmlspecialchars(trim($_POST['nom_estudiante']));
$telefono = htmlspecialchars(trim($_POST['tel_estudiante']));
$email = filter_var(trim($_POST['email_estudiante']), FILTER_SANITIZE_EMAIL);

// Subir Foto
$carpeta = 'img/fotos/';
if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true); }
$foto = $_FILES['foto_estudiante'];
$nombreFoto = uniqid() . '_' . basename($foto['name']);
$rutaFoto = $carpeta . $nombreFoto;

// Seguridad: Validar imagen
$permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$ext = strtolower(pathinfo($nombreFoto, PATHINFO_EXTENSION));
if (in_array($ext, $permitidos) && getimagesize($foto['tmp_name'])) {
    move_uploaded_file($foto['tmp_name'], $rutaFoto);
} else {
    $_SESSION['message'] = "Error: El archivo no es una imagen válida.";
    header('Location: registro_estudiante.php');
    exit();
}

// Insertar registro en la tabla usando SQL preparado
$stmt = $pdo->prepare("INSERT INTO estudiante 
    (cod_estudiante, nom_estudiante, tel_estudiante, email_estudiante, foto_estudiante, fecha) 
    VALUES (?, ?, ?, ?, ?, NOW())");

try {
    $stmt->execute([$cod_est, $nombre, $telefono, $email, $rutaFoto]);
    session_regenerate_id(true); // Seguridad: limpiar sesión
    $_SESSION['message'] = "¡Registro completado exitosamente!";
} catch(Exception $e) {
    $_SESSION['message'] = "Error al guardar: " . $e->getMessage();
}
header('Location: registro_estudiante.php');
exit();
?>
