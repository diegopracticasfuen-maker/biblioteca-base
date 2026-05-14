<?php
include 'db.php';
$id = $_GET['id'];
$conexion->query("UPDATE usuarios SET estado = 'bloqueado' WHERE id = $id");
header("Location: admin_usuarios.php");
?>