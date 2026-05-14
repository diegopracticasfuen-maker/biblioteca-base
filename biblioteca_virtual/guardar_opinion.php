<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificamos que el usuario esté logueado
    if (!isset($_SESSION['id'])) {
        die("Debes iniciar sesión para dejar una opinión.");
    }

    $id_libro = $_POST['id_libro'];
    $id_usuario = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];
    $comentario = $_POST['comentario'];
    $puntuacion = $_POST['puntuacion'];

    // Validar que el comentario no esté vacío
    if (empty($comentario)) {
        header("Location: libro.php?id=$id_libro&error=vacio");
        exit();
    }

    $sql = "INSERT INTO opiniones (id_libro, id_usuario, nombre_usuario, comentario, puntuacion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("iissi", $id_libro, $id_usuario, $nombre, $comentario, $puntuacion);
        
        if ($stmt->execute()) {
            header("Location: libro.php?id=$id_libro&status=ok");
        } else {
            echo "Error al guardar la opinión: " . $stmt->error;
        }
    } else {
        echo "Error en la consulta: " . $conexion->error;
    }
}
?>