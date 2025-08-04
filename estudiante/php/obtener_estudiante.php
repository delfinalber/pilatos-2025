<?php // php/obtener_estudiante.php
require './conexion.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM estudiante WHERE id_estudiante = ?");
$stmt->execute([$id]);
$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);
if ($estudiante) {
    echo json_encode(['success' => true, 'estudiante' => $estudiante]);
} else {
    echo json_encode(['success' => false, 'message' => 'Estudiante no encontrado.']);
}
?>