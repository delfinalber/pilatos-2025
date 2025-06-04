<?php
require_once 'config.php';
createUploadDir();

$mensaje = '';
$tipo_mensaje = '';

// Procesar formulario de subida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subir'])) {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $archivo = $_FILES['imagen'];
        $descripcion = trim($_POST['descripcion'] ?? '');
        
        // Validaciones
        if ($archivo['size'] > MAX_FILE_SIZE) {
            $mensaje = 'El archivo es demasiado grande. Máximo permitido: ' . formatFileSize(MAX_FILE_SIZE);
            $tipo_mensaje = 'error';
        } elseif (!isValidImageType($archivo['type'])) {
            $mensaje = 'Tipo de archivo no permitido. Solo se permiten: JPEG, PNG, GIF, WebP';
            $tipo_mensaje = 'error';
        } else {
            // Generar nombre único
            $nombreArchivo = generateUniqueFileName($archivo['name']);
            $rutaCompleta = UPLOAD_DIR . $nombreArchivo;
            
            // Mover archivo
            if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
                try {
                    $pdo = getConnection();
                    $sql = "INSERT INTO imagenes (nombre_original, nombre_archivo, ruta_archivo, tipo_mime, tamaño, descripcion) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        $archivo['name'],
                        $nombreArchivo,
                        $rutaCompleta,
                        $archivo['type'],
                        $archivo['size'],
                        $descripcion
                    ]);
                    
                    $mensaje = 'Imagen subida exitosamente';
                    $tipo_mensaje = 'success';
                } catch(PDOException $e) {
                    unlink($rutaCompleta); // Eliminar archivo si falla la BD
                    $mensaje = 'Error al guardar en base de datos: ' . $e->getMessage();
                    $tipo_mensaje = 'error';
                }
            } else {
                $mensaje = 'Error al subir el archivo';
                $tipo_mensaje = 'error';
            }
        }
    } else {
        $mensaje = 'Por favor selecciona una imagen';
        $tipo_mensaje = 'error';
    }
}

// Obtener imágenes de la base de datos
try {
    $pdo = getConnection();
    $sql = "SELECT * FROM imagenes WHERE activo = 1 ORDER BY fecha_subida DESC";
    $stmt = $pdo->query($sql);
    $imagenes = $stmt->fetchAll();
} catch(PDOException $e) {
    $imagenes = [];
    if (empty($mensaje)) {
        $mensaje = 'Error al cargar imágenes: ' . $e->getMessage();
        $tipo_mensaje = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Imágenes - Pilatos</title>
    <link rel="stylesheet" href="style-imagen.css">
            <h1>🖼️ Gestor de Imágenes</h1>
            <p>Sistema de administración de imágenes - Base de datos Pilatos</p>
        </div>
        
        <div class="content">
            <?php if ($mensaje): ?>
                <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>
            
            <div class="upload-section">
                <h2>📤 Subir Nueva Imagen</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="imagen">Seleccionar Imagen:</label>
                        <input type="file" 
                               id="imagen" 
                               name="imagen" 
                               class="form-control" 
                               accept="image/*" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción (opcional):</label>
                        <textarea id="descripcion" 
                                  name="descripcion" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Describe brevemente la imagen..."></textarea>
                    </div>
                    
                    <button type="submit" name="subir" class="btn">
                        🚀 Subir Imagen
                    </button>
                </form>
            </div>
            
            <h2>🖼️ Galería de Imágenes</h2>
            
            <?php if (empty($imagenes)): ?>
                <div class="no-images">
                    <p>📷 No hay imágenes subidas aún</p>
                    <p>¡Sube tu primera imagen usando el formulario de arriba!</p>
                </div>
            <?php else: ?>
                <div class="gallery">
                    <?php foreach ($imagenes as $imagen): ?>
                        <div class="image-card">
                            <img src="<?php echo htmlspecialchars($imagen['ruta_archivo']); ?>" 
                                 alt="<?php echo htmlspecialchars($imagen['nombre_original']); ?>">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($imagen['nombre_original']); ?></h3>
                                
                                <?php if ($imagen['descripcion']): ?>
                                    <p class="card-text">
                                        <strong>Descripción:</strong><br>
                                        <?php echo nl2br(htmlspecialchars($imagen['descripcion'])); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="file-info">
                                    <strong>Información del archivo:</strong><br>
                                    <small>
                                        📁 Tamaño: <?php echo formatFileSize($imagen['tamaño']); ?><br>
                                        🗓️ Subida: <?php echo date('d/m/Y H:i', strtotime($imagen['fecha_subida'])); ?><br>
                                        🏷️ Tipo: <?php echo htmlspecialchars($imagen['tipo_mime']); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>