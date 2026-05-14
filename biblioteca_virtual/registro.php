<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
<form action="procesar_registro.php" method="POST">
    <h2>Crear cuenta</h2>
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="email" name="email" placeholder="Correo electrónico" required><br>
    <input type="password" name="contrasena" placeholder="Contraseña" required><br>
    <button type="submit">Registrarse</button>
    <p style="margin-top: 15px;">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</form>
</body>
</html>
