<?php
// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// CORRECCIÓN: Añadir 'src/' a las rutas
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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

    // 3. Preparar la consulta para evitar inyección SQL (CORRECCIÓN AQUÍ)
    $sql = "INSERT INTO registro_sale(nombre_sale, apellido_sale, edad_sale, telefono_sale, email_sale, usuario_sale, password_sale, mensaje_sale, date_sale) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
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
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP de Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'hostingdelfin@gmail.com'; // Tu correo de Gmail de donde sale la clave
            $mail->Password   = 'brqd lpsb qlrn wmko '; // <-- PEGA LA NUEVA CONTRASEÑA AQUÍ esta  contraseña se debe generar en google https://myaccount.google.com/apppasswords
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Remitente y destinatario
            $mail->setFrom('hostingdelfin@gmail.com', 'Tu Nombre o Empresa');
            $mail->addAddress('delfin.alber@gmail.com', 'Nombre del Destinatario'); // correo a donde van a llegar los email enviados desde el formulario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Nuevo Registro desde Formulario SALE';
            $mail->Body    = nl2br("Se ha recibido un nuevo registro:<br><br>
                                    Nombre: $nombre $apellido<br>
                                    Edad: $edad<br>
                                    Teléfono: $telefono<br>
                                    Email: $email<br>
                                    Usuario: $usuario<br>
                                    Mensaje: $mensaje_form<br>");
            $mail->AltBody = "Se ha recibido un nuevo registro:\n\n" .
                             "Nombre: $nombre $apellido\n" .
                             "Edad: $edad\n" .
                             "Teléfono: $telefono\n" .
                             "Email: $email\n" .
                             "Usuario: $usuario\n" .
                             "Mensaje: $mensaje_form\n";

            // Enviar el correo
            $mail->send();
            echo '<script type="text/javascript">alert("Registro guardado y correo enviado exitosamente."); window.location.href = "sale.html";</script>';
        } catch (Exception $e) {
            // Si el correo falla, el registro ya se guardó. Informar del error de correo.
            echo '<script type="text/javascript">alert("Registro guardado, pero hubo un error al enviar el correo: ' . $mail->ErrorInfo . '"); window.location.href = "sale.html";</script>';
        }
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
