<?php
require_once 'config.php';

// Obtener ID de imagen
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $pdo = getConnection();
    $sql = "SELECT * FROM imagenes WHERE id = ? AND activo = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $imagen = $stmt->fetch();
    
    if (!$imagen) {
        header('Location: index.php');
        exit;
    }
} catch(PDOException $e) {
    die('Error al cargar la imagen: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar - <?php echo htmlspecialchars($imagen['nombre_original']); ?></title>
    <link rel="stylesheet" href="style-viewer.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.php">
            ← Volver a la galería
        </a>
    </nav>
    
    <div class="container">
        <div class="image-viewer">
            <div class="image-container">
                <div class="zoom-controls">
                    <button class="zoom-btn" onclick="zoomIn()" title="Ampliar">+</button>
                    <button class="zoom-btn" onclick="zoomOut()" title="Reducir">−</button>
                    <button class="zoom-btn" onclick="resetZoom()" title="Tamaño original">⌂</button>
                </div>
                <img id="mainImage" 
                     src="<?php echo htmlspecialchars($imagen['ruta_archivo']); ?>" 
                     alt="<?php echo htmlspecialchars($imagen['nombre_original']); ?>"
                     class="main-image">
            </div>
            
            <div class="image-info">
                <h1 class="image-title"><?php echo htmlspecialchars($imagen['nombre_original']); ?></h1>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">📁 Tamaño del archivo</div>
                        <div class="info-value"><?php echo formatFileSize($imagen['tamaño']); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">🗓️ Fecha de subida</div>
                        <div class="info-value"><?php echo date('d/m/Y H:i:s', strtotime($imagen['fecha_subida'])); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">🏷️ Tipo de archivo</div>
                        <div class="info-value"><?php echo htmlspecialchars($imagen['tipo_mime']); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">📂 Nombre del archivo</div>
                        <div class="info-value"><?php echo htmlspecialchars($imagen['nombre_archivo']); ?></div>
                    </div>
                </div>
                
                <?php if ($imagen['descripcion']): ?>
                    <div class="description">
                        <div class="info-label">📝 Descripción</div>
                        <div class="info-value"><?php echo nl2br(htmlspecialchars($imagen['descripcion'])); ?></div>
                    </div>
                <?php endif; ?>
                
                <div class="actions">
                    <a href="<?php echo htmlspecialchars($imagen['ruta_archivo']); ?>" 
                       download="<?php echo htmlspecialchars($imagen['nombre_original']); ?>" 
                       class="btn btn-success">
                        ⬇️ Descargar imagen
                    </a>
                    
                    <a href="<?php echo htmlspecialchars($imagen['ruta_archivo']); ?>" 
                       target="_blank" 
                       class="btn btn-primary">
                        🔍 Ver en tamaño completo
                    </a>
                    
                    <a href="index.php" class="btn btn-secondary">
                        📋 Volver a la galería
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let currentZoom = 1;
        const img = document.getElementById('mainImage');
        
        function zoomIn() {
            currentZoom *= 1.2;
            updateZoom();
        }
        
        function zoomOut() {
            currentZoom /= 1.2;
            updateZoom();
        }
        
        function resetZoom() {
            currentZoom = 1;
            updateZoom();
        }
        
        function updateZoom() {
            img.style.transform = `scale(${currentZoom})`;
            img.style.cursor = currentZoom > 1 ? 'grab' : 'default';
        }
        
        // Drag functionality when zoomed
        let isDragging = false;
        let startX, startY, initialX = 0, initialY = 0;
        
        img.addEventListener('mousedown', (e) => {
            if (currentZoom > 1) {
                isDragging = true;
                startX = e.clientX - initialX;
                startY = e.clientY - initialY;
                img.style.cursor = 'grabbing';
            }
        });
        
        document.addEventListener('mousemove', (e) => {
            if (isDragging && currentZoom > 1) {
                initialX = e.clientX - startX;
                initialY = e.clientY - startY;
                img.style.transform = `scale(${currentZoom}) translate(${initialX/currentZoom}px, ${initialY/currentZoom}px)`;
            }
        });
        
        document.addEventListener('mouseup', () => {
            isDragging = false;
            if (currentZoom > 1) {
                img.style.cursor = 'grab';
            }
        });
        
        // Wheel zoom
        img.addEventListener('wheel', (e) => {
            e.preventDefault();
            if (e.deltaY < 0) {
                zoomIn();
            } else {
                zoomOut();
            }
        });
    </script>
</body>
</html>