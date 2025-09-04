<?php
// Archivo de prueba para verificar la conexión a la base de datos
require_once 'config.php';

echo "<h2>Prueba de Conexión a la Base de Datos</h2>";

try {
    // Probar la conexión inicial
    echo "<p>1. Probando conexión inicial...</p>";
    $db = conectarDB();
    echo "<p style='color: green;'>✓ Conexión inicial exitosa</p>";
    
    // Probar ping
    echo "<p>2. Probando ping de la conexión...</p>";
    if ($db->ping()) {
        echo "<p style='color: green;'>✓ Ping exitoso</p>";
    } else {
        echo "<p style='color: red;'>✗ Ping falló</p>";
    }
    
    // Probar verificación de conexión
    echo "<p>3. Probando verificación de conexión...</p>";
    $db2 = verificarConexion();
    if ($db2 && $db2->ping()) {
        echo "<p style='color: green;'>✓ Verificación de conexión exitosa</p>";
    } else {
        echo "<p style='color: red;'>✗ Verificación de conexión falló</p>";
    }
    
    // Probar una consulta simple
    echo "<p>4. Probando consulta simple...</p>";
    $result = $db->query("SELECT 1 as test");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p style='color: green;'>✓ Consulta exitosa: " . $row['test'] . "</p>";
        $result->close();
    } else {
        echo "<p style='color: red;'>✗ Consulta falló: " . $db->error . "</p>";
    }
    
    // Probar si la tabla hombre existe
    echo "<p>5. Verificando tabla 'hombre'...</p>";
    $result = $db->query("SHOW TABLES LIKE 'hombre'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Tabla 'hombre' existe</p>";
        
        // Mostrar estructura de la tabla
        $result2 = $db->query("DESCRIBE hombre");
        if ($result2) {
            echo "<p>Estructura de la tabla 'hombre':</p>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th><th>Extra</th></tr>";
            while ($row = $result2->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Default'] ?? 'NULL') . "</td>";
                echo "<td>" . htmlspecialchars($row['Extra']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            $result2->close();
        }
    } else {
        echo "<p style='color: red;'>✗ Tabla 'hombre' no existe</p>";
    }
    
    echo "<p style='color: green; font-weight: bold;'>¡Todas las pruebas completadas exitosamente!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Cerrar conexión
if (isset($db)) {
    $db->close();
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { margin: 10px 0; }
th, td { padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
</style>
