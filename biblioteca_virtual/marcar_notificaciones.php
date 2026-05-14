<?php
session_start();
include 'db.php';

if ($_SESSION['rol'] === 'usuario') {
    $id = $_SESSION['id'];
    $stmt = $conexion->prepare("UPDATE notificaciones SET leida = 1 WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
