<?php
require_once 'config.php';

try {
    $mysqli = conectarDB();
    $result = $mysqli->query("SELECT id_hombre, cod_hombre, img_hombre_1, img_hombre_2, img_hombre_3, img_hombre_4, nom_produc_hombre FROM hombre LIMIT 3");
    
    if ($result && $result->num_rows > 0) {
        echo "Registros encontrados:\n";
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id_hombre'] . ", Código: " . $row['cod_hombre'] . ", Nombre: " . $row['nom_produc_hombre'] . "\n";
            echo "Img1: " . ($row['img_hombre_1'] ?: 'NULL') . "\n";
            echo "Img2: " . ($row['img_hombre_2'] ?: 'NULL') . "\n";
            echo "Img3: " . ($row['img_hombre_3'] ?: 'NULL') . "\n";
            echo "Img4: " . ($row['img_hombre_4'] ?: 'NULL') . "\n";
            echo "---\n";
        }
    } else {
        echo "No hay registros en la tabla hombre\n";
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
