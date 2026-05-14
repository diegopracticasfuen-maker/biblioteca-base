<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<h2>Subir nuevo libro</h2>
<form action="guardar_libro.php" method="POST" enctype="multipart/form-data">
    <label>Título: <input type="text" name="titulo" required></label><br>
    <label>Autor: <input type="text" name="autor" required></label><br>
    <label>Descripción:<br><textarea name="descripcion" rows="5" cols="50"></textarea></label><br>
    <label>Portada: <input type="file" name="portada" accept="image/*"></label><br>
    <button type="submit">Guardar libro</button>
</form>
