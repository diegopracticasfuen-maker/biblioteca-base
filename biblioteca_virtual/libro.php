<?php
session_start();
include 'db.php';

// 1. SEGURIDAD: Solo usuarios logueados
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// 2. OBTENER DATOS DEL LIBRO
if (isset($_GET['id'])) {
    $id_libro = $_GET['id'];

    // Consultar información del libro
    $query_libro = "SELECT * FROM libros WHERE id = ?";
    $stmt = $conexion->prepare($query_libro);
    $stmt->bind_param("i", $id_libro);
    $stmt->execute();
    $resultado_libro = $stmt->get_result();
    $libro = $resultado_libro->fetch_assoc();

    if (!$libro) {
        die("Libro no encontrado.");
    }

    // Consultar opiniones de este libro
    $query_opiniones = "SELECT * FROM opiniones WHERE id_libro = ? ORDER BY fecha DESC";
    $stmt_opt = $conexion->prepare($query_opiniones);
    $stmt_opt->bind_param("i", $id_libro);
    $stmt_opt->execute();
    $resultado_opiniones = $stmt_opt->get_result();
} else {
    header("Location: panel_usuario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($libro['titulo']) ?> | Detalles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', sans-serif; }
        .book-detail-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .img-detail { width: 100%; max-height: 450px; object-fit: contain; background: #f1f5f9; padding: 20px; }
        .badge-genre { background: #e2e8f0; color: #475569; font-weight: 600; padding: 5px 15px; border-radius: 50px; }
        .opinion-item { border-left: 4px solid #3182ce; background: #fff; margin-bottom: 15px; border-radius: 0 10px 10px 0; }
        .star-rating { color: #f59e0b; }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <div class="mb-4">
            <a href="panel_usuario.php" class="text-muted"><i class="fas fa-arrow-left mr-2"></i> Volver al catálogo</a>
        </div>

        <div class="book-detail-card mb-5">
            <div class="row no-gutters">
                <div class="col-md-4 text-center">
                    <!-- CORRECCIÓN AQUÍ: Ruta cambiada a img/ -->
                    <?php if (!empty($libro['portada'])): ?>
                        <img src="img/<?= $libro['portada'] ?>" class="img-detail" alt="Portada">
                    <?php else: ?>
                        <div class="py-5"><i class="fas fa-book fa-10x text-light"></i></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8 p-4 p-lg-5">
                    <span class="badge-genre mb-2 d-inline-block"><?= htmlspecialchars($libro['genero']) ?></span>
                    <h1 class="font-weight-bold text-dark mb-1"><?= htmlspecialchars($libro['titulo']) ?></h1>
                    <p class="lead text-primary mb-4">Por: <?= htmlspecialchars($libro['autor']) ?></p>
                    
                    <h5 class="font-weight-bold">Descripción</h5>
                    <p class="text-muted mb-5"><?= nl2br(htmlspecialchars($libro['descripcion'])) ?></p>

                    <div class="d-flex align-items-center">
                        <?php if ($libro['disponible']): ?>
                            <a href="reservar.php?id=<?= $libro['id'] ?>" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="fas fa-bookmark mr-2"></i> Reservar ahora
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg disabled px-5">No disponible</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <h3 class="font-weight-bold mb-4">Opiniones de alumnos</h3>
                <?php if ($resultado_opiniones->num_rows > 0): ?>
                    <?php while($op = $resultado_opiniones->fetch_assoc()): ?>
                        <div class="opinion-item p-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="star-rating mb-1 d-block">
                                        <?php for($i=1; $i<=5; $i++) echo $i <= $op['puntuacion'] ? '★' : '☆'; ?>
                                    </span>
                                    <h6 class="font-weight-bold mb-0"><?= htmlspecialchars($op['nombre_usuario']) ?></h6>
                                </div>
                                <small class="text-muted"><?= date('d/m/Y', strtotime($op['fecha'])) ?></small>
                            </div>
                            <p class="text-muted mt-2 mb-0">"<?= htmlspecialchars($op['comentario']) ?>"</p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-light border text-center py-4">
                        <i class="far fa-comment-dots fa-2x mb-2 d-block text-muted"></i>
                        Aún no hay opiniones. ¡Sé el primero en comentar!
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-body p-4">
                        <h4 class="font-weight-bold mb-3">Deja tu reseña</h4>
                        <form action="guardar_opinion.php" method="POST">
                            <input type="hidden" name="id_libro" value="<?= $id_libro ?>">
                            <div class="form-group">
                                <label class="small font-weight-bold">¿Cómo calificarías este libro?</label>
                                <select name="puntuacion" class="form-control custom-select">
                                    <option value="5">5 estrellas - Excelente</option>
                                    <option value="4">4 estrellas - Muy bueno</option>
                                    <option value="3">3 estrellas - Bueno</option>
                                    <option value="2">2 estrellas - Regular</option>
                                    <option value="1">1 estrella - Malo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Tu comentario</label>
                                <textarea name="comentario" class="form-control" rows="4" placeholder="Escribe aquí tu opinión personal..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark btn-block font-weight-bold py-2">
                                Publicar Comentario
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>