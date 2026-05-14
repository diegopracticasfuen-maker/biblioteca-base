<?php
session_start();
include 'db.php';

// Seguridad: Solo el administrador puede devolver libros
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_reserva']) && isset($_GET['id_libro'])) {
    $id_reserva = $_GET['id_reserva'];
    $id_libro = $_GET['id_libro'];

    // 1. Marcamos la reserva como 'Completada' o 'Finalizada'
    $sql_reserva = "UPDATE reservas SET estado = 'Completado' WHERE id = ?";
    $stmt1 = $conexion->prepare($sql_reserva);
    $stmt1->bind_param("i", $id_reserva);
    
    // 2. Volvemos a poner el libro como disponible (disponible = 1)
    $sql_libro = "UPDATE libros SET disponible = 1 WHERE id = ?";
    $stmt2 = $conexion->prepare($sql_libro);
    $stmt2->bind_param("i", $id_libro);

    if ($stmt1->execute() && $stmt2->execute()) {
        echo "<script>
                alert('Libro devuelto y disponible nuevamente.');
                window.location.href = 'admin_reservas.php';
              </script>";
    } else {
        echo "Error al procesar la devolución: " . $conexion->error;
    }
}
?>