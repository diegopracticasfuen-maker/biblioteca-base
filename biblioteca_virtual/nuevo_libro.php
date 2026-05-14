<?php
session_start();
include 'db.php';

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
    <title>Añadir Nuevo Libro | Panel Administrativo</title>
    
    <!-- LIBRERÍAS EXTERNAS (Críticas para el diseño) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* 1. CORRECCIÓN DEL HEADER (Sin tocar el archivo .php) */
        /* Quitamos los puntos y alineamos horizontalmente la lista de image_559003.png */
        nav ul {
            list-style: none !important;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        nav li {
            margin-right: 20px;
        }

        nav a {
            color: white !important;
            text-decoration: none !important;
            font-weight: 500;
            transition: 0.3s;
        }

        nav a:hover {
            opacity: 0.8;
        }

        /* Estilo del contenedor del Nav */
        nav {
            background-color: #1a365d !important;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        /* 2. ESTILO DEL CUERPO Y FORMULARIO */
        body { 
            background-color: #f0f4f8; 
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        .main-container {
            margin-top: 60px;
            margin-bottom: 60px;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: none;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            margin-bottom: 5px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.2);
            border-color: #3182ce;
        }

        .btn-save {
            background-color: #3182ce;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-save:hover {
            background-color: #2b6cb0;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background-color: #edf2f7;
            color: #4a5568;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }

        label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            display: block;
        }

        .icon-header {
            color: #3182ce;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <!-- El header se carga aquí, pero nuestro CSS de arriba lo arregla visualmente -->
    <?php include 'includes/header.php'; ?>

    <div class="container main-container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="form-card text-center">
                    <i class="fas fa-book-medical fa-4x icon-header"></i>
                    <h2 class="font-weight-bold mb-2">Añadir Nuevo Libro</h2>
                    <p class="text-muted mb-4">Ingresa la información detallada para registrar el ejemplar en el sistema.</p>

                    <form action="guardar_libro.php" method="POST" class="text-left">
                        <div class="form-group">
                            <label><i class="fas fa-heading mr-2"></i>Título del Libro</label>
                            <input type="text" name="titulo" class="form-control" placeholder="Ej: Cien años de soledad" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-user-edit mr-2"></i>Autor</label>
                            <input type="text" name="autor" class="form-control" placeholder="Nombre completo del autor" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-tags mr-2"></i>Género Literario</label>
                            <select name="genero" class="form-control" required>
                                <option value="" disabled selected>Selecciona una categoría...</option>
                                <option value="Novela">Novela</option>
                                <option value="Ciencia">Ciencia</option>
                                <option value="Historia">Historia</option>
                                <option value="Fantasía">Fantasía</option>
                                <option value="Biografía">Biografía</option>
                            </select>
                        </div>

                        <div class="row mt-5">
                            <div class="col-sm-6 mb-3">
                                <button type="submit" class="btn btn-primary btn-block btn-save">
                                    <i class="fas fa-save mr-2"></i> Guardar Libro
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <a href="admin_libros.php" class="btn btn-block btn-cancel text-decoration-none">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para asegurar el comportamiento de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>