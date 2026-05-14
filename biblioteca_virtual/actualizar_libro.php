<?php
session_start();
include 'db.php';

// Seguridad: Solo admin
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $descripcion = $_POST['descripcion'];

    // Lógica para la portada
    $portada = $_POST['portada_actual']; // Valor por defecto
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] == 0) {
        $nombre_archivo = time() . "_" . $_FILES['portada']['name'];
        $ruta_destino = "uploads/" . $nombre_archivo;
        
        if (move_uploaded_file($_FILES['portada']['tmp_name'], $ruta_destino)) {
            $portada = $nombre_archivo;
        }
    }

    // Consulta de actualización
    $sql = "UPDATE libros SET titulo=?, autor=?, genero=?, descripcion=?, portada=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssssi", $titulo, $autor, $genero, $descripcion, $portada, $id);
        
        if ($stmt->execute()) {
            // El error en image_47e8a2.png probablemente estaba en una línea como esta:
            $mensaje = "Libro actualizado correctamente"; 
            header("Location: admin_libros.php?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            echo "Error al actualizar: " . $stmt->error;
        }
    } else {
        echo "Error en la consulta: " . $conexion->error;
    }
}
?>