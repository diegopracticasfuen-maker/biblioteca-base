<?php
session_start();
include 'db.php';

// 1. SEGURIDAD: Solo usuarios logueados
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id'];

// 2. CONSULTA: Traer reservas del usuario con info del libro
// Unimos la tabla 'reservas' con 'libros' para ver el título y autor
$query = "SELECT r.id, r.fecha_reserva, r.estado, l.titulo, l.autor 
          FROM reservas r 
          JOIN libros l ON r.id_libro = l.id 
          WHERE r.id_usuario = ? 
          ORDER BY r.fecha_reserva DESC";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas | Biblioteca</title>
    
    <!-- LIBRERÍAS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .reservas-card { 
            background: white; 
            border-radius: 15px; 
            padding: 30px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            margin-top: 40px;
        }
        .status-badge { border-radius: 20px; padding: 5px 15px; font-size: 0.85rem; font-weight: 600; }
        .table thead th { border-top: none; color: #718096; text-transform: uppercase; font-size: 0.8rem; }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="reservas-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-weight-bold text-dark"><i class="fas fa-history mr-2 text-primary"></i> Mis Reservas</h2>
                <a href="panel_usuario.php" class="btn btn-outline-primary btn-sm">Volver al Catálogo</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Libro</th>
                            <th>Autor</th>
                            <th>Fecha Solicitud</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado->num_rows > 0): ?>
                            <?php while($res = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td class="font-weight-bold"><?= htmlspecialchars($res['titulo']) ?></td>
                                    <td><?= htmlspecialchars($res['autor']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($res['fecha_reserva'])) ?></td>
                                    <td>
                                        <?php 
                                        $clase = ($res['estado'] == 'Pendiente') ? 'badge-warning' : 'badge-success';
                                        if($res['estado'] == 'Cancelado') $clase = 'badge-danger';
                                        ?>
                                        <span class="badge status-badge <?= $clase ?>">
                                            <?= htmlspecialchars($res['estado']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    Aún no tienes libros reservados. <br>
                                    <a href="panel_usuario.php" class="mt-2 d-inline-block">Explorar catálogo</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>