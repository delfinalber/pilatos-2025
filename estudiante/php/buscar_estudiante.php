<?php // php/buscar_estudiante.php
require './conexion.php';
$cod = $_GET['cod_estudiante'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM estudiante WHERE cod_estudiante LIKE ?");
$stmt->execute(["%$cod%"]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>