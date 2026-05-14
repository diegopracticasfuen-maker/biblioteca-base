<?php
session_start();
include 'db.php';

$id = $_SESSION['id'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];

$stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
$stmt->bind_param("ssi", $nombre, $email, $id);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = "✅ Cambios realizados correctamente.";
} else {
    $_SESSION['mensaje'] = "❌ Error al guardar los cambios.";
}

$stmt->close();
header("Location: perfil.php");
exit;
?>
