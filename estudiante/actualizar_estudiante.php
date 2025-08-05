<?php
require 'config.php';

$id = (int)$_POST['id_estudiante'];
$cod = htmlspecialchars(trim($_POST['cod_estudiante']));
$nom = htmlspecialchars(trim($_POST['nom_estudiante']));
$tel = htmlspecialchars(trim($_POST['tel_estudiante']));
$email = filter_var(trim($_POST['email_estudiante']), FILTER_SANITIZE_EMAIL);

// Buscar foto previa
$stmt = $pdo->prepare("SELECT foto_estudiante FROM estudiante WHERE id_estudiante=?");
$stmt->execute([$id]);
$prevFoto = $stmt->fetchColumn();
$rutaFoto = $prevFoto;

// Si hay nueva foto
if (!empty($_FILES['foto_estudiante']['name'])) {
    $carpeta = 'img/fotos/';
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true); }
    $foto = $_FILES['foto_estudiante'];
    $nombreFoto = uniqid() . '_' . basename($foto['name']);
    $rutaFoto = $carpeta . $nombreFoto;
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($nombreFoto, PATHINFO_EXTENSION));
    if (in_array($ext, $permitidos) && getimagesize($foto['tmp_name'])) {
        move_uploaded_file($foto['tmp_name'], $rutaFoto);
    } else {
        header('Location: edi_estudiantes.php');
        exit();
    }
}

// Actualizar datos
$sql = "UPDATE estudiante SET cod_estudiante=?, nom_estudiante=?, tel_estudiante=?, email_estudiante=?, foto_estudiante=? WHERE id_estudiante=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$cod, $nom, $tel, $email, $rutaFoto, $id]);
session_start();
session_regenerate_id(true);
$_SESSION['message'] = "Datos actualizados correctamente.";
header('Location: edi_estudiantes.php');
exit();
?>
