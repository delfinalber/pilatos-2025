<?php
require_once('conexion.php');

// 1. Verificar que todos los datos necesarios fueron enviados
if (isset($_POST['nombre'], $_POST['apellido'], $_POST['edad'], $_POST['telefono'], $_POST['email'], $_POST['usuario'], $_POST['password'], $_POST['mensaje'])) {
    
    // 2. Asignar variables
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $edad = $_POST['edad'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password']; // Considera usar password_hash() para más seguridad
    $mensaje_form = $_POST['mensaje'];

    // 3. Preparar la consulta para evitar inyección SQL
    $sql = "INSERT INTO registro_sale(nombre_sale, apellido_sale, edad_sale, telefono_sale, email_sale, usuario_sale, password_sale, mesaje_sale, date_sale) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conexion->prepare($sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    // "s" indica que el tipo de dato es string, "i" para integer. Ajusta según tu tabla.
    $stmt->bind_param("ssisssss", $nombre, $apellido, $edad, $telefono, $email, $usuario, $password, $mensaje_form);

    // 4. Ejecutar la consulta y verificar el resultado
    if ($stmt->execute()) {
        // 5. Enviar correo si el registro fue exitoso
        $destinatario = "delfin.alber@gmail.com.com"; // <-- CAMBIA ESTO
        $asunto = "Nuevo Registro desde Formulario SALE";
        $cuerpoMensaje = "Se ha recibido un nuevo registro:\n\n";
        $cuerpoMensaje .= "Nombre: $nombre $apellido\n";
        $cuerpoMensaje .= "Edad: $edad\n";
        $cuerpoMensaje .= "Teléfono: $telefono\n";
        $cuerpoMensaje .= "Email: $email\n";
        $cuerpoMensaje .= "Usuario: $usuario\n";
        $cuerpoMensaje .= "Mensaje: $mensaje_form\n";
        $cabeceras = "From: hostingdelfin@gmail.com";   // Puedes usar un correo de tu dominio

        mail($destinatario, $asunto, $cuerpoMensaje, $cabeceras);

        echo '<script type="text/javascript">alert("Registro guardado exitosamente."); window.location.href = "sale.html";</script>';
    } else {
        // Muestra un error si la inserción falla
        echo '<script type="text/javascript">alert("Error al guardar el registro: ' . $stmt->error . '"); window.location.href = "sale.html";</script>';
    }

    $stmt->close();

} else {
    // Si faltan campos
    echo '<script type="text/javascript">alert("Debes de llenar todos los campos."); window.location.href = "sale.html";</script>';
}

$conexion->close();
?>
