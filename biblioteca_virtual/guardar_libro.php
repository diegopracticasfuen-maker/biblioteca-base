<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $genero = trim($_POST['genero']);
    $descripcion = trim($_POST['descripcion']);

    $stmt = $conexion->prepare("INSERT INTO libros (titulo, autor, genero, descripcion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $autor, $genero, $descripcion);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "📚 Libro añadido correctamente.";
        $_SESSION['tipo'] = "success";
    } else {
        $_SESSION['mensaje'] = "❌ Error al añadir el libro.";
        $_SESSION['tipo'] = "danger";
    }

    $stmt->close();
    header("Location: admin_libros.php");
    exit;
}
?>
