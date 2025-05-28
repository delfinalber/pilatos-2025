<?php
include('conexion.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = $_POST['edad'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];



if ($nombre && $apellido && $edad && $telefono && $email && $usuario && $password ){
    $sql= "INSERT INTO registro_sale(id_sale, nombre_sale, apellido_sale, edad_sale, telefono_sale, email_sale, usuario_sale, password_sale, date_sale) VALUES (NULL, '$nombre', '$apellido', '$edad', '$telefono', '$email', '$usuario', '$password', NULL)"; 
      
    mysqli_query($mysqli, $sql);
       
        echo '<script type="text/javascript">alert("Tarea Guardada"); window.location.href = "../sale/sale.html";</script>';
    }
    else
    {
        echo '<script type="text/javascript">alert("Debes de llenar todos los campos"); window.location.href = "../sale/sale.html";</script>';;
    }
?>
