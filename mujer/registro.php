<?php
// Iniciar la sesión para poder acceder a las variables de sesión
session_start();

// Verificar si el usuario ha iniciado sesión.
// Si la variable de sesión 'id_usuario' no existe, lo redirigimos al inicio.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-success text-center" role="alert">
            <h1 class="alert-heading">¡Bienvenido!</h1>
            <p>Has iniciado sesión correctamente como: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>.</p>
            <hr>
            <p class="mb-0">Ahora te encuentras en el área de registro.</p>
        </div>
    </div>
</body>
</html>