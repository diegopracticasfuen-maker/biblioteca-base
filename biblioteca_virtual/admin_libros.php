<?php
session_start();
include 'db.php';

// 1. SEGURIDAD: Solo Admin
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 2. CONSULTA: Obtenemos los libros (Asegúrate de que los nombres de columnas coincidan con tu DB)
$query = "SELECT * FROM libros ORDER BY id DESC";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros | Biblioteca</title>
    
    <!-- 3. LIBRERÍAS: Sin esto se verá sin estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { background-color: #f0f4f8 !important; font-family: 'Segoe UI', sans-serif; }
        .glass-card { 
            background: white; 
            border-radius: 20px; 
            padding: 30px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
            margin-top: 30px;
            border: none;
        }
        .table-custom { border-collapse: separate; border-spacing: 0 10px; }
        .table-custom tbody tr { background: #f8fafc; transition: 0.3s; }
        .table-custom tbody tr:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .table-custom td { border: none; padding: 15px; vertical-align: middle; }
        .btn-action { border-radius: 8px; font-weight: 600; padding: 5px 15px; }
    </style>
</head>
<body>

<!-- INCLUSIÓN DEL HEADER -->
<?php include 'includes/header.php'; ?>

<div class="container mb-5">
    <div class="glass-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="font-weight-bold" style="color: #1a365d;">
                <i class="fas fa-book mr-2"></i> Inventario de Libros
            </h2>
            <a href="nuevo_libro.php" class="btn btn-primary shadow-sm" style="border-radius: 10px;">
                <i class="fas fa-plus mr-2"></i> Agregar Nuevo Libro
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-custom">
                <thead class="text-muted small text-uppercase">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($resultado && $resultado->num_rows > 0): ?>
                        <?php while($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td class="font-weight-bold text-muted">#<?= $row['id'] ?></td>
                            <td class="font-weight-bold" style="color: #2d3748;"><?= htmlspecialchars($row['titulo']) ?></td>
                            <td><?= htmlspecialchars($row['autor']) ?></td>
                            <td>
                                <?php if($row['disponible']): ?>
                                    <span class="badge badge-success px-3 py-2">Disponible</span>
                                <?php else: ?>
                                    <span class="badge badge-warning px-3 py-2 text-white">Prestado</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="editar_libro.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm btn-action mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="eliminar_libro.php?id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm btn-action" onclick="return confirm('¿Eliminar este libro?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No hay libros registrados actualmente.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SCRIPTS: Importantes para el funcionamiento del menú -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>