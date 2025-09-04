<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pilatos');

// Variable global para mantener la conexión
$GLOBALS['db_connection'] = null;

// Función de conexión a la base de datos con reconexión automática
function conectarDB() {
    global $db_connection;
    
    // Verificar si ya existe una conexión válida
    if ($db_connection && $db_connection->ping()) {
        return $db_connection;
    }
    
    // Crear nueva conexión
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($mysqli->connect_errno) {
        error_log("Error de conexión a la base de datos: " . $mysqli->connect_error);
        die('Error de conexión a la base de datos. Por favor, intente nuevamente.');
    }
    
    // Configurar la conexión
    $mysqli->set_charset('utf8mb4');
    
    // Configurar timeouts más largos
    $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 60);
    $mysqli->options(MYSQLI_OPT_READ_TIMEOUT, 60);
    
    // Guardar la conexión globalmente
    $db_connection = $mysqli;
    
    return $mysqli;
}

// Función para verificar y reconectar si es necesario
function verificarConexion() {
    global $db_connection;
    
    if (!$db_connection || !$db_connection->ping()) {
        $db_connection = null;
        return conectarDB();
    }
    
    return $db_connection;
}

// Función para escapar datos
function esc($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

