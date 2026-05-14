<?php
session_start();
include 'db.php';

// 1. SEGURIDAD: Solo Administradores
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 2. CONSULTA SQL
$query = "SELECT r.id AS id_reserva, r.id_libro, r.fecha_reserva, r.estado, 
                 u.nombre AS nombre_usuario, 
                 l.titulo AS titulo_libro 
          FROM reservas r
          JOIN usuarios u ON r.id_usuario = u.id
          JOIN libros l ON r.id_libro = l.id
          ORDER BY r.fecha_reserva DESC";

$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Reservas | Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .main-card { background: white; border-radius: 15px; padding: 30px; margin-top: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .badge-reservado { background-color: #6366f1; color: white; } /* Color indigo para Reservado */
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="main-card">
            <h2 class="font-weight-bold mb-4"><i class="fas fa-book-reader text-primary mr-2"></i> Control de Préstamos</h2>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Libro</th>
                            <th>Estado Actual</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado && $resultado->num_rows > 0): ?>
                            <?php while($res = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($res['nombre_usuario']) ?></td>
                                    <td><?= htmlspecialchars($res['titulo_libro']) ?></td>
                                    <td>
                                        <?php 
                                            // Normalizamos a minúsculas para evitar fallos de escritura
                                            $estado_db = strtolower(trim($res['estado'])); 
                                            
                                            if ($estado_db == 'reservado') {
                                                echo '<span class="badge badge-reservado p-2">Reservado (En Préstamo)</span>';
                                            } elseif ($estado_db == 'pendiente') {
                                                echo '<span class="badge badge-warning p-2">Pendiente</span>';
                                            } elseif ($estado_db == 'completado') {
                                                echo '<span class="badge badge-success p-2">Completado</span>';
                                            } else {
                                                echo '<span class="badge badge-secondary p-2">'.htmlspecialchars($res['estado']).'</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        // AHORA COMPARAMOS CONTRA "reservado"
                                        if ($estado_db == 'reservado'): 
                                        ?>
                                            <a href="devolver_libro.php?id_reserva=<?= $res['id_reserva'] ?>&id_libro=<?= $res['id_libro'] ?>" 
                                               class="btn btn-success btn-sm font-weight-bold shadow-sm"
                                               onclick="return confirm('¿Confirmar devolución? El libro volverá a estar disponible.')">
                                                <i class="fas fa-undo-alt mr-1"></i> Recibir Libro
                                            </a>
                                        <?php elseif ($estado_db == 'pendiente'): ?>
                                            <span class="text-muted small">Esperando gestión</span>
                                        <?php else: ?>
                                            <span class="text-muted small">Sin acciones</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center py-4">No hay registros en la base de datos.</td></tr>
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