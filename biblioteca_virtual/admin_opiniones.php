<?php
session_start();
include 'db.php';

// Seguridad: Solo admin puede entrar
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Consulta para traer las opiniones con los nombres de usuario y libros
$query = "SELECT o.id, u.nombre as usuario, l.titulo as libro, o.comentario, o.fecha 
          FROM opiniones o 
          JOIN usuarios u ON o.id_usuario = u.id 
          JOIN libros l ON o.id_libro = l.id
          ORDER BY o.fecha DESC";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Moderación de Opiniones - Panel Admin</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { background-color: #f8f9fc; }
        .admin-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background: white;
            padding: 25px;
            margin-top: 30px;
        }
        .table thead th {
            background-color: #1a365d;
            color: white;
            border: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        .table tbody tr:hover {
            background-color: #f1f4f8;
        }
        .badge-user { background-color: #e2e8f0; color: #4a5568; padding: 5px 10px; border-radius: 5px; font-weight: 600; }
        .btn-delete { color: #e53e3e; transition: 0.2s; }
        .btn-delete:hover { color: #c53030; transform: scale(1.1); }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container mb-5">
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="color: #1a365d; font-weight: 700; margin: 0;">
                <i class="fas fa-comments mr-2"></i> Moderación de Opiniones
            </h2>
            <span class="badge badge-primary p-2"><?= $result->num_rows ?> Opiniones totales</span>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Libro</th>
                        <th>Comentario</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows === 0): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No hay opiniones registradas para moderar.</td>
                        </tr>
                    <?php else: ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="align-middle">
                                <span class="badge-user"><i class="fas fa-user mr-1"></i> <?= htmlspecialchars($row['usuario']) ?></span>
                            </td>
                            <td class="align-middle font-weight-bold" style="color: #2d3748;">
                                <?= htmlspecialchars($row['libro']) ?>
                            </td>
                            <td class="align-middle text-muted" style="max-width: 400px;">
                                "<?= htmlspecialchars($row['comentario']) ?>"
                            </td>
                            <td class="align-middle text-center">
                                <a href="eliminar_opinion.php?id=<?= $row['id'] ?>" 
                                   class="btn-delete" 
                                   onclick="return confirm('¿Estás seguro de que quieres eliminar este comentario?')"
                                   title="Eliminar Opinión">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="admin_panel.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver al Panel
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>