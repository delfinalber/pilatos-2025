<?php
require 'config.php';

$id = (int)$_POST['id_estudiante'];

// Borrar foto del servidor
$stmt = $pdo->prepare("SELECT foto_estudiante FROM estudiante WHERE id_estudiante=?");
$stmt->execute([$id]);
$foto = $stmt->fetchColumn();
if ($foto && file_exists($foto)) unlink($foto);

// Eliminar de tabla
$stmt = $pdo->prepare("DELETE FROM estudiante WHERE id_estudiante=?");
$stmt->execute([$id]);

session_start();
session_regenerate_id(true);
$_SESSION['message'] = "Estudiante eliminado correctamente.";
header('Location: edi_estudiantes.php');
exit();
?>
