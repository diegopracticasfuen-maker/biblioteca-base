<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario_sesion = $_SESSION['id'];
$rol = $_SESSION['rol'];

// --- CASO ADMIN: ACEPTAR O RECHAZAR ---
if (isset($_GET['id']) && isset($_GET['accion']) && $rol === 'admin') {
    $id_reserva = intval($_GET['id']);
    $accion = $_GET['accion'];
    
    // Mapeo: 'aceptar' -> 'Reservado', 'rechazar' -> 'Rechazado'
    $nuevo_estado = ($accion === 'aceptar') ? 'Reservado' : 'Rechazado';

    $stmt = $conexion->prepare("UPDATE reservas SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $nuevo_estado, $id_reserva);

    if ($stmt->execute()) {
        // Si se rechaza, devolvemos la disponibilidad al libro
        if ($accion === 'rechazar') {
            $conexion->query("UPDATE libros SET disponible = 1 WHERE id = (SELECT id_libro FROM reservas WHERE id = $id_reserva)");
        }
        
        // --- ENVIAR NOTIFICACIÓN AL USUARIO ---
        $res_info = $conexion->query("SELECT id_usuario, (SELECT titulo FROM libros WHERE id=r.id_libro) as titulo FROM reservas r WHERE id=$id_reserva")->fetch_assoc();
        
        if ($res_info) {
            $target_user = $res_info['id_usuario'];
            $libro_nome = $res_info['titulo'];
            $mensaje = "Tu solicitud del libro '$libro_nome' ha sido: " . strtoupper($nuevo_estado);
            
            // Inserción en la tabla de notificaciones
            $stmt_notif = $conexion->prepare("INSERT INTO notificaciones (id_usuario, mensaje) VALUES (?, ?)");
            $stmt_notif->bind_param("is", $target_user, $mensaje);
            $stmt_notif->execute();
        }

        header("Location: admin_reservas.php?update=success");
    } else {
        echo "Error en la actualización: " . $conexion->error;
    }
    exit();
}

// --- CASO USUARIO: NUEVA RESERVA ---
if (isset($_GET['id_libro']) && $rol === 'usuario') {
    $id_libro = intval($_GET['id_libro']);
    
    $stmt = $conexion->prepare("INSERT INTO reservas (id_usuario, id_libro, estado) VALUES (?, ?, 'Pendiente')");
    $stmt->bind_param("ii", $id_usuario_sesion, $id_libro);

    if ($stmt->execute()) {
        $conexion->query("UPDATE libros SET disponible = 0 WHERE id = $id_libro");
        header("Location: panel_usuario.php?reserva=exito");
    } else {
        echo "Error al procesar: " . $conexion->error;
    }
    exit();
}
?>