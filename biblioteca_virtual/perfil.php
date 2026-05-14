<?php
session_start();
include 'db.php';

// 1. SEGURIDAD: Solo usuarios logueados
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id'];

// 2. CONSULTA: Obtener datos actualizados del usuario
$query = "SELECT nombre, email, rol, estado FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Biblioteca</title>
    
    <!-- LIBRERÍAS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .profile-card { 
            background: white; 
            border-radius: 20px; 
            padding: 40px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            margin-top: 50px;
            border: none;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #1a365d;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .info-label { color: #718096; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; }
        .info-value { color: #2d3748; font-size: 1.1rem; font-weight: 500; margin-bottom: 20px; }
        .btn-password { 
            background-color: #1a365d; 
            color: white; 
            border-radius: 10px; 
            font-weight: 600; 
            transition: 0.3s;
        }
        .btn-password:hover { background-color: #2c5282; color: white; transform: translateY(-2px); }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="profile-card text-center">
                    <div class="profile-avatar">
                        <i class="fas fa-user fa-4x"></i>
                    </div>
                    <h2 class="font-weight-bold mb-4"><?= htmlspecialchars($usuario['nombre']) ?></h2>
                    
                    <hr>

                    <div class="text-left mt-4">
                        <p class="info-label mb-1">Correo Electrónico</p>
                        <p class="info-value"><i class="fas fa-envelope mr-2 text-primary"></i> <?= htmlspecialchars($usuario['email']) ?></p>

                        <p class="info-label mb-1">Tipo de Cuenta</p>
                        <p class="info-value">
                            <i class="fas fa-id-badge mr-2 text-primary"></i> 
                            <?= ucfirst(htmlspecialchars($usuario['rol'])) ?>
                        </p>

                        <p class="info-label mb-1">Estado actual</p>
                        <p class="info-value">
                            <span class="badge badge-success px-3 py-2">
                                <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($usuario['estado']) ?>
                            </span>
                        </p>
                    </div>

                    <div class="mt-4">
                        <!-- LA RUTA CORREGIDA AQUÍ -->
                        <a href="cambiar_contrasena.php" class="btn btn-password btn-block py-3 shadow-sm">
                            <i class="fas fa-key mr-2"></i> Cambiar mi contraseña
                        </a>
                        
                        <a href="panel_usuario.php" class="btn btn-link mt-3 text-muted">
                            Volver al panel principal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>