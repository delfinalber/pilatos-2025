<?php

//Conexion por procedimientos
        $mysqli = mysqli_connect("localhost","root","","pilatos");

        if ($mysqli->connect_errno) {
                printf ("Falló la conexión: %s\n", $mysqli->connect_error);
                exit();
            }
?>