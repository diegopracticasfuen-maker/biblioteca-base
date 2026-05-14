<?php
session_start();
include 'db.php';

// 1. REGLA DE SEGURIDAD PARA ALUMNOS
// Verifica que el usuario esté logueado. Si no hay sesión, al login.
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// 2. CONSULTA DEL CATÁLOGO UNIFICADO
// Traemos los libros disponibles. 
// Nota: Asegúrate de que la tabla se llame 'libros' y la columna 'disponible'.
$query_libros = "SELECT * FROM libros WHERE disponible = 1 ORDER BY id DESC";
$resultado_libros = $conexion->query($query_libros);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel de Usuario | Biblioteca</title>
    
    <!-- LIBRERÍAS DE ESTILO -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Sección de Bienvenida */
        .welcome-hero {
            background: linear-gradient(135deg, #1a365d 0%, #2a4a7d 100%);
            color: white;
            padding: 50px 40px;
            border-radius: 20px;
            margin-top: 30px;
            margin-bottom: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .section-title {
            font-weight: 800;
            color: #1a365d;
            margin-bottom: 30px;
            border-left: 5px solid #3182ce;
            padding-left: 15px;
        }

        /* Tarjetas de Libros */
        .book-card {
            background: white;
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.1);
        }

        .card-img-container {
            height: 200px;
            background: #edf2f7;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px 15px 0 0;
            overflow: hidden;
        }

        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Botones */
        .btn-custom-detail {
            border-radius: 8px;
            font-weight: 600;
            border: 2px solid #3182ce;
            color: #3182ce;
            transition: 0.3s;
        }

        .btn-custom-detail:hover {
            background-color: #3182ce;
            color: white;
        }

        .btn-reserve {
            background-color: #3182ce;
            border: none;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px;
        }

        .btn-reserve:hover { background-color: #2b6cb0; }
        
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }
    </style>
</head>
<body>

    <!-- INCLUSIÓN DEL HEADER DINÁMICO -->
    <?php include 'includes/header.php'; ?>

    <div class="container pb-5">
        
        <!-- HERO: BIENVENIDA -->
        <div class="welcome-hero text-center text-md-left shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 font-weight-bold">¡Hola, <?= htmlspecialchars($_SESSION['nombre']) ?>!</h1>
                    <p class="lead mb-0">Explora el catálogo y gestiona tus préstamos desde un solo lugar.</p>
                </div>
                <div class="col-md-4 text-center d-none d-md-block">
                    <i class="fas fa-book-open fa-6x" style="opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <!-- TÍTULO DE SECCIÓN -->
        <h3 class="section-title">Catálogo de Libros</h3>
        
        <div class="row">
            <?php if ($resultado_libros && $resultado_libros->num_rows > 0): ?>
                <?php while($libro = $resultado_libros->fetch_assoc()): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="book-card card">
                            <!-- Imagen/Portada -->
                            <div class="card-img-container">
                                <?php if (!empty($libro['portada'])): ?>
                                    <img src="uploads/<?= $libro['portada'] ?>" alt="Portada del libro">
                                <?php else: ?>
                                    <i class="fas fa-book fa-4x text-muted opacity-25"></i>
                                <?php endif; ?>
                            </div>

                            <!-- Información y Botones -->
                            <div class="card-body text-center">
                                <h5 class="card-title font-weight-bold text-dark text-truncate mb-1">
                                    <?= htmlspecialchars($libro['titulo']) ?>
                                </h5>
                                <p class="card-text text-muted small mb-3">
                                    <?= htmlspecialchars($libro['autor']) ?>
                                </p>
                                
                                <div class="mt-auto">
                                    <!-- OPCIÓN 1: VER DETALLES -->
                                    <a href="libro.php?id=<?= $libro['id'] ?>" class="btn btn-custom-detail btn-block btn-sm mb-2">
                                        <i class="fas fa-eye mr-1"></i> Ver detalles
                                    </a>
                                    
                                    <!-- OPCIÓN 2: RESERVAR -->
                                    <a href="reservar.php?id=<?= $libro['id'] ?>" class="btn btn-primary btn-block btn-reserve">
                                        <i class="fas fa-bookmark mr-1"></i> Reservar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded shadow-sm">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <p class="text-muted lead">No hay libros disponibles actualmente.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- SCRIPTS OBLIGATORIOS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>