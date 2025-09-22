<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;      
use PHPMailer\PHPMailer\SMTP;   

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor para depuración
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Descomenta esta línea para ver los logs detallados del servidor

    // Configuración del servidor SMTP de Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hostingdelfin@gmail.com'; // Tu correo de Gmail
    $mail->Password   = 'Tutan854636'; // La contraseña de 16 caracteres que generates
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Remitente y Destinatario
    $mail->setFrom('hostingdelfin@gmail.com', 'Prueba Pilatos');
    $mail->addAddress('hostingdelfin.alber@gmail.com', 'Alberto Delfin'); // Correo de destino

    // Contenido del correo
    $mail->isHTML(false); // Enviar como texto plano
    $mail->Subject = 'Correo de Prueba - PHPMailer';
    $mail->Body    = 'Este es un correo de prueba para verificar que la configuración de PHPMailer funciona correctamente.';
    $mail->CharSet = 'UTF-8';

    $mail->send();
    echo '<h1>¡Éxito!</h1>';
    echo '<p>El mensaje de prueba ha sido enviado correctamente a hostingdelfin.alber@gmail.com.</p>';

} catch (Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p>El mensaje no pudo ser enviado. Error de PHPMailer: {$mail->ErrorInfo}</p>";
}
?>