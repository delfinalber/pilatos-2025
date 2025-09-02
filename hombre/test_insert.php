<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $mysqli = conectarDB();
        
        $cod = intval($_POST['cod_hombre'] ?? 0);
        $nom = trim($_POST['nom_produc_hombre'] ?? '');
        $descripcion = trim($_POST['descripcion_hombre'] ?? '');
        $precio = trim($_POST['precio_hombre'] ?? '');
        
        if ($cod <= 0 || $nom === '' || $descripcion === '' || $precio === '') {
            throw new Exception('Datos inválidos');
        }
        
        // Insertar registro de prueba
        $stmt = $mysqli->prepare("INSERT INTO hombre (cod_hombre, nom_produc_hombre, descripcion_hombre, precio_hombre) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $cod, $nom, $descripcion, $precio);
        
        if ($stmt->execute()) {
            echo "<h1>✓ Registro insertado correctamente</h1>";
            echo "<p>ID: " . $stmt->insert_id . "</p>";
            echo "<p>Código: " . $cod . "</p>";
            echo "<p>Nombre: " . $nom . "</p>";
            echo "<p>Descripción: " . $descripcion . "</p>";
            echo "<p>Precio: " . $precio . "</p>";
        } else {
            throw new Exception('Error al insertar: ' . $stmt->error);
        }
        
        $stmt->close();
        $mysqli->close();
        
    } catch (Exception $e) {
        echo "<h1>✗ Error</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
} else {
    echo "<h1>Método no permitido</h1>";
    echo "<p>Este archivo solo acepta POST</p>";
}
?>

<p><a href="test_hombre.php">Volver a la prueba</a></p>
<p><a href="registro_hombre.php">Ir al registro principal</a></p>
