<?php
require_once 'config.php';

echo "<h1>Prueba de la tabla hombre</h1>";

try {
    $mysqli = conectarDB();
    
    // Verificar si la tabla existe
    $result = $mysqli->query("SHOW TABLES LIKE 'hombre'");
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✓ La tabla 'hombre' existe</p>";
        
        // Mostrar estructura de la tabla
        echo "<h2>Estructura de la tabla:</h2>";
        $result = $mysqli->query("DESCRIBE hombre");
        echo "<table border='1'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Llave</th><th>Default</th><th>Extra</th></tr>";
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
        
        // Mostrar datos existentes
        echo "<h2>Datos existentes:</h2>";
        $result = $mysqli->query("SELECT * FROM hombre ORDER BY id_hombre DESC");
        if ($result->num_rows > 0) {
            echo "<table border='1'>";
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
            echo "<p>No hay registros en la tabla</p>";
        }
        
    } else {
        echo "<p style='color: red;'>✗ La tabla 'hombre' NO existe</p>";
        echo "<p>Ejecuta el archivo SQL: BD/crear_tabla_hombre.sql</p>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<h2>Prueba de inserción:</h2>
<form method="post" action="test_insert.php">
    <p>
        <label>Código: <input type="number" name="cod_hombre" value="1004" required></label>
    </p>
    <p>
        <label>Nombre: <input type="text" name="nom_produc_hombre" value="Polo Casual" required></label>
    </p>
    <p>
        <label>Descripción: <input type="text" name="descripcion_hombre" value="Polo de manga corta para hombre" required></label>
    </p>
    <p>
        <label>Precio: <input type="text" name="precio_hombre" value="$55.000" required></label>
    </p>
    <p>
        <input type="submit" value="Insertar registro de prueba">
    </p>
</form>

<p><a href="registro_hombre.php">Volver al registro principal</a></p>
