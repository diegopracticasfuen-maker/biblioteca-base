<?php
session_start();
include 'db.php';

$id = $_SESSION['id'];
$actual = $_POST['actual'];
$nueva = $_POST['nueva'];
$confirmar = $_POST['confirmar'];

// Validación: las nuevas contraseñas deben coincidir
if (trim($nueva) === "" || trim($confirmar) === "") {
    $_SESSION['mensaje'] = "❌ La nueva contraseña no puede estar vacía.";
    header("Location: cambiar_contrasena.php");
    exit;
}

if ($nueva !== $confirmar) {
    $_SESSION['mensaje'] = "❌ Las nuevas contraseñas no coinciden. Verifícalas.";
    header("Location: cambiar_contrasena.php");
    exit;
}

// Obtener la contraseña actual desde la base de datos
$stmt = $conexion->prepare("SELECT contraseña FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($contrasena_hash);
$stmt->fetch();
$stmt->close();

// Verificar la contraseña actual
if (!password_verify($actual, $contrasena_hash)) {
    $_SESSION['mensaje'] = "❌ La contraseña actual que introdujiste no es correcta.";
    header("Location: cambiar_contrasena.php");
    exit;
}

// Actualizar la contraseña
$nueva_hash = password_hash($nueva, PASSWORD_DEFAULT);
$stmt = $conexion->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
$stmt->bind_param("si", $nueva_hash, $id);
if ($stmt->execute()) {
    $_SESSION['mensaje'] = "✅ Contraseña actualizada correctamente.";
} else {
    $_SESSION['mensaje'] = "❌ Error inesperado al actualizar la contraseña.";
}
$stmt->close();

header("Location: cambiar_contrasena.php");
exit;
?>
