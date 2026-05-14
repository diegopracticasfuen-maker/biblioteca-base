<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin_libros.php");
    exit;
}

include 'db.php';
$id = intval($_GET['id']);

// Eliminar el libro de la base de datos
$stmt = $conexion->prepare("DELETE FROM libros WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = "✅ Libro eliminado correctamente.";
    $_SESSION['tipo'] = "success";
} else {
    $_SESSION['mensaje'] = "❌ Error al eliminar el libro.";
    $_SESSION['tipo'] = "danger";
}

$stmt->close();
header("Location: admin_libros.php");
exit;
?>
