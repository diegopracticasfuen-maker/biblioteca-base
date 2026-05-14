<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Obtener los datos del libro actual
$id = $_GET['id'];
$query = "SELECT * FROM libros WHERE id = $id";
$resultado = $conexion->query($query);
$libro = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro | Panel Administrativo</title>
    
    <!-- LIBRERÍAS EXTERNAS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* ARREGLO DINÁMICO DEL HEADER */
        nav ul { list-style: none !important; padding: 0; margin: 0; display: flex; align-items: center; }
        nav li { margin-right: 20px; }
        nav a { color: white !important; text-decoration: none !important; font-weight: 500; }
        nav { 
            background-color: #1a365d !important; 
            padding: 15px 50px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); 
        }

        /* DISEÑO DEL FORMULARIO */
        body { background-color: #f0f4f8; font-family: 'Segoe UI', sans-serif; }
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin-top: 50px;
            border: none;
        }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #e2e8f0; }
        .btn-update { background-color: #2b6cb0; color: white; font-weight: bold; border-radius: 10px; padding: 12px; }
        .btn-cancel { background-color: #edf2f7; color: #4a5568; font-weight: bold; border-radius: 10px; padding: 12px; }
        label { font-weight: 600; color: #2d3748; margin-top: 15px; }
        .current-img { border-radius: 10px; border: 2px solid #e2e8f0; margin-top: 10px; max-width: 150px; }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="text-center mb-4">
                        <i class="fas fa-edit fa-3x text-primary mb-2"></i>
                        <h2 class="font-weight-bold">Editar Detalles del Libro</h2>
                    </div>

                    <form action="actualizar_libro.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $libro['id'] ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <label>Título del Libro</label>
                                <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($libro['titulo']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Autor</label>
                                <input type="text" name="autor" class="form-control" value="<?= htmlspecialchars($libro['autor']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Género</label>
                                <select name="genero" class="form-control">
                                    <option value="Ficción" <?= $libro['genero'] == 'Ficción' ? 'selected' : '' ?>>Ficción</option>
                                    <option value="Novela" <?= $libro['genero'] == 'Novela' ? 'selected' : '' ?>>Novela</option>
                                    <option value="Historia" <?= $libro['genero'] == 'Historia' ? 'selected' : '' ?>>Historia</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Portada (Opcional)</label>
                                <input type="file" name="portada" class="form-control-file mt-2">
                            </div>
                        </div>

                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($libro['descripcion']) ?></textarea>

                        <div class="mt-3">
                            <p class="small text-muted mb-1">Imagen actual:</p>
                            <img src="uploads/<?= $libro['portada'] ?>" class="current-img" onerror="this.src='https://via.placeholder.com/150x200?text=Sin+Portada'">
                        </div>

                        <div class="row mt-5">
                            <div class="col-6">
                                <button type="submit" class="btn btn-update btn-block shadow-sm">
                                    <i class="fas fa-sync-alt mr-2"></i> Actualizar libro
                                </button>
                            </div>
                            <div class="col-6">
                                <a href="admin_libros.php" class="btn btn-cancel btn-block text-decoration-none text-center">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>