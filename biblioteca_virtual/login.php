<?php
session_start();
include 'db.php';

// Solo ejecutamos si se recibe el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Limpiamos los datos de entrada
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $clave = isset($_POST['contrasena_post']) ? trim($_POST['contrasena_post']) : ''; 

    // Buscamos al usuario en la base de datos
    $stmt = $conexion->prepare("SELECT id, nombre, contrasena, rol, estado FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nombre, $hash, $rol, $estado);
        $stmt->fetch();

        // --- BLOQUE DE DIAGNÓSTICO ---
        // Si sigue fallando, mira los mensajes que saldrán arriba en tu navegador
        // echo "<div style='background:#000; color:#fff; padding:10px; position:fixed; top:0; width:100%; z-index:9999;'>";
        // echo "<b>DEBUG:</b><br>";
        // echo "Clave escrita: [" . $clave . "]<br>";
        // echo "Hash en BD: [" . $hash . "]<br>";
        // if (password_verify($clave, $hash)) {
        //     echo "<span style='color:lime'>¡ÉXITO! La contraseña coincide.</span>";
        // } else {
        //  echo "<span style='color:red'>ERROR: La contraseña NO coincide con el hash.</span>";
        // }
        // echo "</div>";
        // -----------------------------

        if ($estado === 'bloqueado') {
            $_SESSION['mensaje'] = "Tu cuenta está bloqueada.";
            $_SESSION['tipo'] = "danger";
        } 
        elseif (password_verify($clave, $hash)) {
            $_SESSION['id'] = $id;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['rol'] = $rol;

            if ($rol === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $_SESSION['mensaje'] = "Contraseña incorrecta.";
            $_SESSION['tipo'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "Usuario no encontrado.";
        $_SESSION['tipo'] = "danger";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="js/avisos.js"></script>
</head>
<body>

<?php if (!empty($_SESSION['mensaje'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        mostrarAviso("<?= addslashes($_SESSION['mensaje']) ?>", "<?= $_SESSION['tipo'] ?? 'info' ?>");
    });
</script>
<?php unset($_SESSION['mensaje'], $_SESSION['tipo']); ?>
<?php endif; ?>

<div class="login-container" style="margin-top: 100px;">
    <form method="POST" action="login.php">
        <h2>Iniciar Sesión</h2>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="contrasena_post" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </form>
</div>
</body>
</html>