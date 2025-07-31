<?php
// 1. Iniciar la sesión
// Siempre debe ser lo primero en el script.
session_start();

// 2. Incluir el archivo de conexión
require 'conexion.php';

// 3. Verificar que los datos lleguen por método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 4. Obtener y limpiar los datos del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // 5. Preparar la consulta para evitar inyección SQL
    // Consultamos solo por el usuario. Nunca incluyas el password directamente en la consulta.
    $stmt = $conexion->prepare("SELECT id_sesion, usuario, password FROM sesion WHERE usuario = ?");
    $stmt->bind_param("s", $usuario); // "s" indica que el parámetro es un string

    // 6. Ejecutar la consulta
    $stmt->execute();
    $resultado = $stmt->get_result();

    // 7. Verificar si se encontró un usuario
    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();

        // 8. Verificar la contraseña
        // Usamos password_verify() para comparar la contraseña enviada con el hash guardado.
        // ¡NUNCA guardes contraseñas en texto plano!
        if (password_verify($password, $fila['password'])) {
            
            // ¡Credenciales correctas!
            
            // 9. Guardar datos en la sesión
            $_SESSION['id_usuario'] = $fila['id_sesion'];
            $_SESSION['usuario'] = $fila['usuario'];

            // 10. Limpiar la caché del navegador
            // Estas cabeceras le dicen al navegador que no guarde esta página en caché.
            header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
            header("Pragma: no-cache"); // HTTP 1.0.
            header("Expires: 0"); // Proxies.

            // 11. Redirigir a la página de registro
            $stmt->close();
            $conexion->close();
            header("Location: ./registro.php"); // Redirigir a la página de registro
            exit(); // Es importante terminar el script después de una redirección.
            exit(); // Es importante terminar el script después de una redirección.

        } else {
            // Contraseña incorrecta
            $stmt->close();
            $conexion->close();
            header("Location: alert.php?mensaje=Registro exitoso!"); // Redirigir con un mensaje de error
            exit();
        }

    } else {
        // Usuario no encontrado
        $stmt->close();
        $conexion->close();
        header("alert('Usuario no encontrado');"); // Mismo error para no dar pistas a atacantes
        exit();
    }

} else {
    // Si alguien intenta acceder directamente a login.php, lo redirigimos
    header("Location: index.html");
    exit();
}
?>