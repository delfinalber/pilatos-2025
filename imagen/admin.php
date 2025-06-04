<?php
require_once 'config.php';

$mensaje = '';
$tipo_mensaje = '';

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        try {
            $pdo = getConnection();
            
            // Obtener información de la imagen antes de eliminar
            $sql = "SELECT ruta_archivo FROM imagenes WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $imagen = $stmt->fetch();
            
            if ($imagen) {
                // Marcar como inactiva en lugar de eliminar
                $sql = "UPDATE imagenes SET activo = 0 WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                
                // Opcional: eliminar archivo físico
                if (file_exists($imagen['ruta_archivo'])) {
                    unlink($imagen['ruta_archivo']);
                }
                
                $mensaje = 'Imagen eliminada exitosamente';
                $tipo_mensaje = 'success';
            }
        } catch(PDOException $e) {
            $mensaje = 'Error al eliminar imagen: ' . $e->getMessage();
            $tipo_mensaje = 'error';
        }
    }
    
    if (isset($_POST['restaurar']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        try {
            $pdo = getConnection();
                        $sql = "UPDATE imagenes SET activo = 1 WHERE id = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$id]);
                        
                        $mensaje = 'Imagen restaurada exitosamente';
                        $tipo_mensaje = 'success';
                    } catch(PDOException $e) {
                        $mensaje = 'Error al restaurar imagen: ' . $e->getMessage();
                        $tipo_mensaje = 'error';
                    }
                }
            }