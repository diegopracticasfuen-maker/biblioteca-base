<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Consultas para los datos del panel
$usuarios = $conexion->query("SELECT id, nombre, email, estado FROM usuarios WHERE rol != 'admin'");
$libros = $conexion->query("SELECT id, titulo, autor, disponible FROM libros");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Biblioteca</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/admin_usuarios.css?v=<?= time() ?>">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="admin-container">
    <h1>Panel de Administración</h1>
    <p style="margin-bottom: 30px; color: #666;">Bienvenido, Administrador. Aquí tienes el resumen general del sistema.</p>

    <h2 style="color: #0056b3; margin-top: 30px;">Usuarios registrados</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($u['nombre']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <span class="badge-rol" style="background: <?= $u['estado']=='activo'?'#d4edda':'#f8d7da' ?>; color: #333;">
                        <?= ucfirst($u['estado']) ?>
                    </span>
                </td>
                <td>
                    <a href="admin_usuarios.php" class="btn btn-info btn-sm">Gestionar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2 style="color: #0056b3; margin-top: 50px;">Libros disponibles</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Disponible</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($l = $libros->fetch_assoc()): ?>
            <tr>
                <td><strong><?= htmlspecialchars($l['titulo']) ?></strong></td>
                <td><?= htmlspecialchars($l['autor']) ?></td>
                <td><?= $l['disponible'] ? '✅ Sí' : '❌ No' ?></td>
                <td>
                    <a href="admin_libros.php" class="btn btn-info btn-sm">Gestionar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>

