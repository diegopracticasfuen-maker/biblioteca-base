<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
    <link rel="stylesheet" href="css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/cambiar_contrasena_estilo.css?v=<?= time() ?>">
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>
  <div class="container">
    <h2>Cambiar mi contraseña</h2>

    <form action="procesar_cambio_contrasena.php" method="POST">
        <label>Contraseña actual:
            <input type="password" name="actual" required>
        </label>
        <label>Nueva contraseña:
            <input type="password" name="nueva" required>
        </label>
        <label>Confirmar nueva contraseña:
            <input type="password" name="confirmar" required>
        </label>
        <button type="submit">Actualizar contraseña</button>
        <p style="text-align: center; margin-top: 15px;">
    <a href="index.php" style="color: #0d47a1; font-weight: bold;">🔙 Volver atrás</a>
</p>

    </form>
  </div>
</main>

<?php if (!empty($_SESSION['mensaje'])): ?>
<script>
    window.onload = () => {
        const mensaje = <?= json_encode($_SESSION['mensaje']) ?>;
        const alerta = document.createElement("div");
        alerta.className = "toast-mensaje";
        alerta.innerText = mensaje;
        document.body.appendChild(alerta);
        setTimeout(() => {
            alerta.classList.add("visible");
        }, 100);
        setTimeout(() => {
            alerta.classList.remove("visible");
            setTimeout(() => alerta.remove(), 500);
        }, 4000);
    };
</script>
<?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

</body>
</html>
