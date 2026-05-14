<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$id_usuario = $_SESSION['id'];
$id_libro = intval($_POST['id_libro']);
$comentario = $_POST['comentario'];

$stmt = $conexion->prepare("INSERT INTO opiniones (id_usuario, id_libro, comentario) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $id_usuario, $id_libro, $comentario);

if ($stmt->execute()) {
    header("Location: libro.php?id=$id_libro");
    exit;
} else {
    echo "Error al comentar: " . $stmt->error;
}
