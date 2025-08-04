<?php // php/eliminar_estudiante.php
require './conexion.php';
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id_estudiante'] ?? 0;

if ($id > 0) {
    try {
        // Opcional: Primero, eliminar el archivo de la foto del servidor
        $stmt_select = $pdo->prepare("SELECT foto_estudiante FROM estudiante WHERE id_estudiante = ?");
        $stmt_select->execute([$id]);
        $foto = $stmt_select->fetchColumn();
        if ($foto && file_exists("../$foto")) {
            unlink("../$foto");
        }

        // Eliminar el registro de la BD
        $stmt_delete = $pdo->prepare("DELETE FROM estudiante WHERE id_estudiante = ?");
        $stmt_delete->execute([$id]);

        echo json_encode(['success' => true, 'message' => 'Estudiante eliminado exitosamente.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el estudiante.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de estudiante no válido.']);
}
?>