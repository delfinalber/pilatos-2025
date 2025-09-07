<?php
require_once 'config.php';

function generarTarjetasProductos() {
    try {
        $mysqli = conectarDB();
        
        // Obtener todos los productos de la tabla hombre
        $result = $mysqli->query("SELECT * FROM hombre ORDER BY id_hombre DESC");
        
        if (!$result) {
            throw new Exception('Error al consultar la base de datos: ' . $mysqli->error);
        }
        
        $tarjetas = '';
        $carouselCounter = 1;
        $colCount = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($colCount % 4 == 0) {
                    $tarjetas .= "<div class='row'>";
                }
                $id = $row['id_hombre'];
                $codigo = $row['cod_hombre'];
                $nombre = esc($row['nom_produc_hombre']);
                $descripcion = esc($row['descripcion_hombre']);
                $precio = esc($row['precio_hombre']);
                // Generar carousel de imágenes
                $carouselItems = '';
                $imagenes = [
                    $row['img_hombre_1'],
                    $row['img_hombre_2'],
                    $row['img_hombre_3'],
                    $row['img_hombre_4']
                ];
                foreach ($imagenes as $index => $imagen) {
                    if (!empty($imagen)) {
                        $carouselItems .= '<a class="carousel-item"><img src="' . $imagen . '" alt="' . $nombre . ' Imagen ' . ($index + 1) . '"></a>';
                    }
                }
                // Si no hay imágenes, usar una imagen por defecto
                if (empty($carouselItems)) {
                    $carouselItems = '<a class="carousel-item"><img src="../img/carru-hom/default.webp" alt="' . $nombre . ' Imagen por defecto"></a>';
                }
                // Generar la tarjeta
                $tarjeta = '
                <!-- Tarjeta ' . $codigo . ' -->
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="carousel carousel-slider" id="carousel' . $carouselCounter . '">
                            ' . $carouselItems . '
                        </div>
                        <div class="card-content">
                            <div class="carousel-controls">
                                <button class="btn-small" onclick="moveCarousel(\'carousel' . $carouselCounter . '\', -1)">Anterior</button>
                                <button class="btn-small" onclick="moveCarousel(\'carousel' . $carouselCounter . '\', 1)">Siguiente</button>
                            </div>
                            <h5>' . $nombre . '</h5>
                            <p>' . $descripcion . '</p>
                            <p class="price">' . $precio . '</p>
                        </div>
                    </div>
                </div>';
                $tarjetas .= $tarjeta;
                $carouselCounter++;
                $colCount++;
                if ($colCount % 4 == 0) {
                    $tarjetas .= "</div>\n<br>\n<img src='../img/Jean.webp' alt='' style='width: 100%;'>\n<br>\n";
                }
            }
            // Cerrar la última fila si no está cerrada
            if ($colCount % 4 != 0) {
                $tarjetas .= "</div>\n<br>\n<img src='../img/Jean.webp' alt='' style='width: 100%;'>\n<br>\n";
            }
        } else {
            $tarjetas = '<div class="col s12"><p class="center-align">No hay productos disponibles</p></div>';
        }
        $mysqli->close();
        return $tarjetas;
        
    } catch (Exception $e) {
        return '<div class="col s12"><p class="center-align red-text">Error: ' . $e->getMessage() . '</p></div>';
    }
}
?>
