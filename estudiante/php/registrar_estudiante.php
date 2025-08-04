<?php
require './conexion.php';

$cod_estudiante = $_POST['cod_estudiante'] ?? '';
$nom_estudiante = $_POST['nom_estudiante'] ?? '';
$tel_estudiante = $_POST['tel_estudiante'] ?? 0;
$email_estudiante = $_POST['email_estudiante'] ?? '';
$foto_url = '';

// Validación básica del lado del servidor
if (empty($cod_estudiante) || empty($nom_estudiante) || empty($email_estudiante)) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
    exit;
}

// Manejo de la subida de la foto
if (isset($_FILES['foto_estudiante']) && $_FILES['foto_estudiante']['error'] == 0) {
    $target_dir = "../../img/fotos/";
    // Crear un nombre de archivo único para evitar sobreescrituras
    $file_extension = pathinfo($_FILES["foto_estudiante"]["name"], PATHINFO_EXTENSION);
    $target_file = $target_dir . uniqid('foto_', true) . '.' . $file_extension;
    
    // Mover el archivo subido a la carpeta de destino
    if (move_uploaded_file($_FILES["foto_estudiante"]["tmp_name"], $target_file)) {
        // Guardamos la ruta relativa accesible desde el HTML
        $foto_url = '../../img/fotos/' . basename($target_file);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir la foto.']);
        exit;
    }
}

try {
    $sql = "INSERT INTO estudiante (cod_estudiante, nom_estudiante, tel_estudiante, email_estudiante, foto_estudiante) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    // Usamos sentencias preparadas para evitar inyección SQL
    $stmt->execute([$cod_estudiante, $nom_estudiante, $tel_estudiante, $email_estudiante, $foto_url]);
    
    echo json_encode(['success' => true, 'message' => '✅ Registro completado exitosamente.']);

} catch (PDOException $e) {
    // Manejo de errores (p. ej. código o email duplicado)
    if ($e->errorInfo[1] == 1062) {
        echo json_encode(['success' => false, 'message' => 'Error: El código de estudiante o el email ya existen.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el estudiante: ' . $e->getMessage()]);
    }
}
?>