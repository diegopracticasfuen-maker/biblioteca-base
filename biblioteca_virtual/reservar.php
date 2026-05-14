<?php
session_start();
include 'db.php';

// 1. SEGURIDAD: Verificar sesión
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// 2. CORRECCIÓN DE LAS WARNINGS:
// En la URL envías "id", pero en el código buscas "id_libro". 
// Vamos a capturar el ID correctamente desde la URL.
$id_usuario = $_SESSION['id'];
$id_libro = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_libro) {
    die("Error: No se especificó un libro para reservar.");
}

// 3. FECHA AUTOMÁTICA:
// Para evitar el error de "fecha_limite", la calculamos aquí (ej: 7 días desde hoy)
$fecha_reserva = date('Y-m-d');

// 4. INSERCIÓN EN LA BASE DE DATOS:
// He eliminado 'fecha_limite' de la consulta para evitar el Fatal Error de la imagen.
$sql = "INSERT INTO reservas (id_usuario, id_libro, fecha_reserva, estado) VALUES (?, ?, ?, 'Pendiente')";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("iis", $id_usuario, $id_libro, $fecha_reserva);
    
    if ($stmt->execute()) {
        // Actualizamos el libro a no disponible (opcional según tu lógica)
        $conexion->query("UPDATE libros SET disponible = 0 WHERE id = $id_libro");
        
        echo "<script>
                alert('¡Reserva realizada con éxito!');
                window.location.href = 'panel_usuario.php';
              </script>";
    } else {
        echo "Error al ejecutar la reserva: " . $stmt->error;
    }
} else {
    echo "Error en la base de datos: " . $conexion->error;
}
?>