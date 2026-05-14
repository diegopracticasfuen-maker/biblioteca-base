<?php
session_start();
include 'db.php';

// 1. SEGURIDAD: Solo el admin entra aquí
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// 2. CONSULTA DE USUARIOS
$query = "SELECT id, nombre, email, rol, estado FROM usuarios";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Biblioteca</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* ESTILO UNIFICADO (Adaptado a tus capturas) */
        body {
            background-color: #f0f4f8 !important; /* Fondo gris claro de tus fotos */
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .main-wrapper {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .glass-card {
            background: #ffffff;
            border-radius: 20px; /* Bordes redondeados como en Solicitar Reserva */
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); /* Sombra suave */
            padding: 40px;
            border: none;
        }

        .section-title {
            color: #1a365d; /* Tu azul oscuro corporativo */
            font-weight: 800;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Estilo de la Tabla Moderna */
        .custom-table {
            border-collapse: separate;
            border-spacing: 0 12px; /* Crea el efecto de filas flotantes */
        }

        .custom-table thead th {
            border: none;
            color: #718096;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1.2px;
            padding-bottom: 15px;
        }

        .custom-table tbody tr {
            background: #f8fafc; /* Fondo suave para cada fila */
            transition: all 0.3s ease;
        }

        .custom-table tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            background: #ffffff;
        }

        .custom-table td {
            border: none;
            padding: 20px;
            vertical-align: middle;
        }

        /* Redondear esquinas de cada fila */
        .custom-table tr td:first-child { border-radius: 12px 0 0 12px; }
        .custom-table tr td:last-child { border-radius: 0 12px 12px 0; }

        /* Badges de Estado y Rol */
        .badge-ui {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .badge-admin { background: #e9d8fd; color: #553c9a; }
        .badge-user { background: #bee3f8; color: #2b6cb0; }
        .badge-active { background: #c6f6d5; color: #2f855a; }

        /* Botones de acción */
        .btn-ui {
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 8px 15px;
            border: none;
            transition: 0.2s;
        }

        .btn-edit-ui { background: #3182ce; color: white; }
        .btn-edit-ui:hover { background: #2c5282; color: white; }

        .btn-delete-ui { background: #e53e3e; color: white; }
        .btn-delete-ui:hover { background: #c53030; color: white; }

        /* Arreglo para el menú */
        .navbar { margin-bottom: 0 !important; }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container main-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="glass-card">
                <h2 class="section-title">
                    <i class="fas fa-users-cog mr-3"></i>Gestionar Usuarios
                </h2>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($user = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 10px;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <span class="font-weight-bold" style="color: #2d3748;"><?= htmlspecialchars($user['nombre']) ?></span>
                                    </div>
                                </td>
                                <td class="text-muted small"><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="badge-ui <?= $user['rol'] == 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                        <?= $user['rol'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-ui badge-active">Activo</span>
                                </td>
                                <td class="text-center">
                                    <a href="editar_usuario.php?id=<?= $user['id'] ?>" class="btn-ui btn-edit-ui mr-2">
                                        <i class="fas fa-edit mr-1"></i> Editar
                                    </a>
                                    <a href="eliminar_usuario.php?id=<?= $user['id'] ?>" class="btn-ui btn-delete-ui" onclick="return confirm('¿Eliminar este usuario?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-center">
                    <a href="admin_panel.php" class="text-muted small font-weight-bold">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al panel de administración
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>