<?php
include('conexion.php');

$correo_pedido = $_POST['correo_pedido'];
$password_pedido = $_POST['password_pedido'];
$nombre_pedido = $_POST['nombre_pedido'];
$direccion_pedido = $_POST['direccion_pedido'];
$ciudad_pedido = $_POST['ciudad_pedido'];
$departamento_pedido = $_POST['departamento_pedido'];
$codigopostal_pedido = $_POST['codigopostal_pedido'];



if ($correo_pedido && $password_pedido && $nombre_pedido && $direccion_pedido && $ciudad_pedido && $departamento_pedido && $codigopostal_pedido){
    $sql= "INSERT INTO pedidos(id_pedido, correo_pedido, password_pedido, nombre_pedido, direccion_pedido, ciudad_pedido, departamento_pedido, codigopostal_pedido, fecha_pedido) VALUES (NULL, '$correo_pedido', '$password_pedido', '$nombre_pedido', '$direccion_pedido', '$ciudad_pedido', '$departamento_pedido', '$codigopostal_pedido', NULL)"; 
      
    mysqli_query($mysqli, $sql);
       
        echo '<script type="text/javascript">alert("Se guardo con exito el pedido"); window.location.href = "../nuevo/nuevo.html";</script>';
    }
    else
    {
        echo '<script type="text/javascript">alert("Debes de llenar todos los campos"); window.location.href = "../nuevo/nuevo.html";</script>';;
    }
?>
