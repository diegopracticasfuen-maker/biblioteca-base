<?php
include 'db.php'; // Asegúrate de que este archivo conecta a tu BD

$password_plana = '123456';
// Generamos el hash real usando el algoritmo de tu propio servidor
$hash_nuevo = password_hash($password_plana, PASSWORD_DEFAULT);

$sql = "UPDATE usuarios SET contrasena = '$hash_nuevo', rol = 'admin' WHERE email = 'admin@biblioteca.com'";

if ($conexion->query($sql)) {
    echo "<h1>¡Éxito!</h1>";
    echo "<p>El hash ha sido actualizado en la base de datos.</p>";
    echo "<p>Nuevo hash generado: <code>$hash_nuevo</code></p>";
    echo "<p>Intenta entrar ahora en <a href='login.php'>login.php</a> con la clave 123456</p>";
} else {
    echo "Error al actualizar: " . $conexion->error;
}
?>