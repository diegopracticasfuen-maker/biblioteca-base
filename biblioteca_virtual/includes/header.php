<!-- Estilos base para el menú -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #1a365d !important;">
    <div class="container">
        <!-- El logo lleva a paneles distintos según el rol -->
        <a class="navbar-brand font-weight-bold" href="<?= ($_SESSION['rol'] == 'admin') ? 'admin_panel.php' : 'panel_usuario.php' ?>">
            <i class="fas fa-book-reader mr-2"></i> BIBLIOTECA
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navPrincipal">
            <ul class="navbar-nav mx-auto">
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                    <!-- MENÚ EXCLUSIVO PARA ADMINISTRADORES -->
                    <li class="nav-item"><a class="nav-link text-white" href="admin_panel.php">Inicio Admin</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="admin_libros.php">Gestión Libros</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="admin_usuarios.php">Gestión Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="admin_reservas.php">Reservas</a></li>
                <?php else: ?>
                    <!-- MENÚ EXCLUSIVO PARA ALUMNOS / USUARIOS -->
                    <li class="nav-item"><a class="nav-link text-white" href="panel_usuario.php"><i class="fas fa-th-large mr-1"></i> Mi Panel</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="catalogo.php"><i class="fas fa-search mr-1"></i> Ver Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="mis_reservas.php"><i class="fas fa-calendar-alt mr-1"></i> Mis Préstamos</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="perfil.php"><i class="fas fa-user-circle mr-1"></i> Mi Perfil</a></li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text text-white-50 mr-3 d-none d-lg-inline">
                        Hola, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>
                    </span>
                    <a class="btn btn-danger btn-sm px-3" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Scripts obligatorios -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>