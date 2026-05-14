<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "biblioteca_virtual";

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Esto es vital para que las tildes y la 'ñ' se vean bien
$conexion->set_charset("utf8mb4");
?>