<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}
// Opcional: destruir la sesión aquí si solo necesitas validar una vez
// session_unset(); session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Técnico Superior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="alert alert-success mt-5">
            <h3>¡Bienvenido <b><?php echo htmlspecialchars($_SESSION['user']); ?></b>!</h3>
            <p>Has iniciado sesión correctamente.</p>
        </div>
    </div>
</body>
</html>
