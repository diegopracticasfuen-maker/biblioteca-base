<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Validamos que llegue un ID de libro válido
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_libro = intval($_GET['id']);

// Obtenemos los datos del libro para mostrarlos en la confirmación
$query = "SELECT titulo, autor, portada FROM libros WHERE id = $id_libro";
$resultado = $conexion->query($query);
$libro = $resultado->fetch_assoc();

if (!$libro) {
    echo "Libro no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Reserva - <?= htmlspecialchars($libro['titulo']) ?></title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { background-color: #f0f4f8; }
        .reserva-container {
            max-width: 500px;
            margin: 80px auto;
        }
        .confirm-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
            padding: 30px;
            text-align: center;
        }
        .libro-mini-portada {
            width: 120px;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-confirm {
            background-color: #1a365d;
            border: none;
            padding: 12px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-confirm:hover {
            background-color: #2c5282;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container reserva-container">
    <div class="confirm-card">
        <i class="fas fa-calendar-check fa-3x mb-3" style="color: #3182ce;"></i>
        <h2 class="mb-4" style="color: #1a365d; font-weight: 700;">Solicitar Reserva</h2>
        
        <img src="img/portadas/<?= htmlspecialchars($libro['portada']) ?>" class="libro-mini-portada" alt="Portada">
        <h5 class="mb-1"><strong><?= htmlspecialchars($libro['titulo']) ?></strong></h5>
        <p class="text-muted mb-4"><?= htmlspecialchars($libro['autor']) ?></p>

        <div class="alert alert-info small text-left">
            <i class="fas fa-info-circle mr-2"></i> 
            Al confirmar, tu solicitud será enviada al administrador para su aprobación.
        </div>

        <a href="procesar_reserva.php?id_libro=<?= $id_libro ?>" class="btn btn-primary btn-block btn-confirm">
            <i class="fas fa-check-circle mr-2"></i> Confirmar solicitud
        </a>
        
        <a href="index.php" class="btn btn-link mt-3 text-muted">
            <i class="fas fa-arrow-left mr-1"></i> Volver al catálogo
        </a>
    </div>
</div>

</body>
</html>