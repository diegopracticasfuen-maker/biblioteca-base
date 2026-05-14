<?php
session_start();
include 'db.php';

// Seguridad: Solo permite el acceso si es administrador
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Biblioteca Virtual</title>

    <!-- 1. BOOTSTRAP CSS: Esencial para que el menú sea horizontal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 2. FONT AWESOME: Para los iconos de las tarjetas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- 3. TU CSS PERSONALIZADO: Cargado después de Bootstrap -->
    <link rel="stylesheet" href="css/admin_panel.css">

    <style>
        /* Estilos integrados para asegurar que el diseño sea consistente */
        body { 
            background-color: #f0f4f8 !important; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .welcome-banner {
            background-color: #1a365d;
            color: white;
            border-radius: 15px;
            padding: 50px 40px;
            margin-top: 30px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .admin-card {
            background: white;
            border: none;
            border-radius: 15px;
            padding: 35px 20px;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            text-decoration: none !important;
            display: block;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .admin-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .admin-card i { font-size: 3.5rem; margin-bottom: 20px; }
        .icon-libros { color: #3182ce; }
        .icon-usuarios { color: #38a169; }
        .icon-reservas { color: #d69e2e; }
        .icon-opiniones { color: #805ad5; }
        
        .card-title { 
            color: #2d3748; 
            font-weight: 800; 
            font-size: 1.4rem; 
            margin-bottom: 10px;
        }
        
        .card-text { 
            color: #718096; 
            font-size: 0.95rem; 
            line-height: 1.4;
        }
    </style>
</head>
<body>

<!-- Inclusión del Header (Asegúrate de que este archivo use clases de Bootstrap) -->
<?php include 'includes/header.php'; ?>

<div class="container pb-5">
    <!-- Banner de Bienvenida -->
    <div class="welcome-banner text-center text-md-left">
        <h1 class="display-4 font-weight-bold">Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
        <p class="lead">Desde aquí puedes gestionar todo el sistema bibliotecario de manera centralizada.</p>
    </div>

    <!-- Rejilla de Acciones Basada en tus archivos reales -->
    <div class="row">
        <!-- LIBROS -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="admin_libros.php" class="admin-card">
                <i class="fas fa-book icon-libros"></i>
                <div class="card-title">Libros</div>
                <p class="card-text">Gestionar el catálogo, añadir o eliminar libros.</p>
            </a>
        </div>

        <!-- USUARIOS -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="admin_usuarios.php" class="admin-card">
                <i class="fas fa-users icon-usuarios"></i>
                <div class="card-title">Usuarios</div>
                <p class="card-text">Controlar roles, bloquear o editar perfiles registrados.</p>
            </a>
        </div>

        <!-- RESERVAS -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="admin_reservas.php" class="admin-card">
                <i class="fas fa-calendar-check icon-reservas"></i>
                <div class="card-title">Reservas</div>
                <p class="card-text">Aprobar o rechazar solicitudes de préstamos.</p>
            </a>
        </div>

        <!-- OPINIONES -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="admin_opiniones.php" class="admin-card">
                <i class="fas fa-comments icon-opiniones"></i>
                <div class="card-title">Opiniones</div>
                <p class="card-text">Moderar los comentarios y reseñas de los usuarios.</p>
            </a>
        </div>
    </div>
</div>

<!-- SCRIPTS: Necesarios para que el menú desplegable funcione -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>