<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$id_reserva = intval($_POST['id_reserva'] ?? 0);

// Obtener ID del libro antes de cancelar
$res = $conexion->query("SELECT id_libro FROM reservas WHERE id = $id_reserva AND id_usuario = {$_SESSION['id']}");

if ($res && $res->num_rows === 1) {
    $libro = $res->fetch_assoc()['id_libro'];

    // Cancelar reserva
    $conexion->query("UPDATE reservas SET estado = 'cancelado' WHERE id = $id_reserva");

    // Marcar libro como disponible nuevamente
    $conexion->query("UPDATE libros SET disponible = 1 WHERE id = $libro");
}

header("Location: panel_usuario.php");
exit;
