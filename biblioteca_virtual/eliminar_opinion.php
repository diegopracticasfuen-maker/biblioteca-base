<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    exit("Acceso denegado");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conexion->prepare("DELETE FROM opiniones WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: admin_opiniones.php");
exit();
?>