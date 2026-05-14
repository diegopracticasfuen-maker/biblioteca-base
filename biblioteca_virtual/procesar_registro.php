<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Verificar si el correo ya existe
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['mensaje'] = "El correo ya está registrado.";
        $_SESSION['tipo'] = "danger";
        header("Location: registro.php");
        exit;
    }
    $stmt->close();

    // Insertar el nuevo usuario
    $rol = "usuario";
    $estado = "activo";

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, contrasena, rol, estado) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $email, $contrasena, $rol, $estado);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "✅ Registro exitoso. Ya puedes iniciar sesión.";
        $_SESSION['tipo'] = "success";
        header("Location: login.php");
    } else {
        $_SESSION['mensaje'] = "❌ Error al registrar. Intenta nuevamente.";
        $_SESSION['tipo'] = "danger";
        header("Location: registro.php");
    }

    $stmt->close();
}
?>
