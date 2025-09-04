<?php
// Archivo de prueba para verificar la inserción de datos
require_once 'config.php';

echo "<h2>Prueba de inserción de datos en la tabla hombre</h2>";

try {
    $mysqli = conectarDB();
    
    // Verificar conexión
    echo "<p style='color: green;'>✓ Conexión a la base de datos exitosa</p>";
    
    // Verificar estructura de la tabla
    $result = $mysqli->query("DESCRIBE hombre");
    if ($result) {
        echo "<h3>Estructura de la tabla hombre:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Verificar registros existentes
    $result = $mysqli->query("SELECT COUNT(*) as total FROM hombre");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Total de registros en la tabla hombre: <strong>" . $row['total'] . "</strong></p>";
    }
    
    // Mostrar registros existentes
    $result = $mysqli->query("SELECT * FROM hombre ORDER BY id_hombre DESC LIMIT 5");
    if ($result && $result->num_rows > 0) {
        echo "<h3>Últimos 5 registros:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Código</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Fecha</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_hombre'] . "</td>";
            echo "<td>" . $row['cod_hombre'] . "</td>";
            echo "<td>" . $row['nom_produc_hombre'] . "</td>";
            echo "<td>" . $row['descripcion_hombre'] . "</td>";
            echo "<td>" . $row['precio_hombre'] . "</td>";
            echo "<td>" . $row['fecha_creacion'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>No hay registros en la tabla hombre</p>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<br><a href='registro_hombre.php'>← Volver al formulario</a>";
?>
