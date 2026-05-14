<?php
// No poner session_start aquí
$user_name = $_SESSION['nombre'] ?? 'Administrador';
?>
<header style="background: #004085; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif;">
    <div style="font-weight: bold;">Bienvenido, <?php echo htmlspecialchars($user_name); ?></div>
    
    <nav>
        <ul style="list-style: none; display: flex; gap: 20px; margin: 0; padding: 0;">
            <li><a href="admin_panel.php" style="color: white; text-decoration: none;">Inicio</a></li>
            <li><a href="admin_libros.php" style="color: white; text-decoration: none;">Libros</a></li>
            <li><a href="admin_usuarios.php" style="color: white; text-decoration: none;">Usuarios</a></li>
            <li><a href="admin_reservas.php" style="color: white; text-decoration: none;">Reservas</a></li>
            <li><a href="admin_opiniones.php" style="color: white; text-decoration: none;">Opiniones</a></li>
            <li><a href="logout.php" style="color: #ff9999; text-decoration: none; font-weight: bold;">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>