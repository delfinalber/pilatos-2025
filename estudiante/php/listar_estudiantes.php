<?php // php/listar_estudiantes.php
require './conexion.php';
$stmt = $pdo->query("SELECT id_estudiante, cod_estudiante, nom_estudiante, tel_estudiante, email_estudiante, foto_estudiante FROM estudiante ORDER BY nom_estudiante ASC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>