<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($appName ?? 'Inventario de Computadores') ?></title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= htmlspecialchars(($assetBasePath ?? '') . '/web/css/app.css', ENT_QUOTES, 'UTF-8') ?>">
    
    <style>
        body {
            background-color: #f5f5f5;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
        }
        .main-container {
            background: white;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            min-height: 80vh;
        }
        .card {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .btn {
            border-radius: 5px;
        }
        .table {
            margin-bottom: 0;
        }
        .badge {
            padding: 0.35rem 0.65rem;
        }
        .alert {
            border-radius: 5px;
        }
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            border-top: 3px solid #667eea;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="?controller=dashboard&action=index">
                <i class="fas fa-laptop"></i> Inventario
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=dashboard&action=index">
                                <i class="fas fa-home"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=computador&action=index">
                                <i class="fas fa-laptop"></i> Computadores
                            </a>
                        </li>
                        <?php if (in_array($_SESSION['usuario_rol'] ?? '', ['admin', 'empleado'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=asignacion&action=index">
                                <i class="fas fa-tasks"></i> Asignaciones
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (($_SESSION['usuario_rol'] ?? '') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=usuario&action=index">
                                <i class="fas fa-users"></i> Usuarios
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <span class="dropdown-item-text"><?= htmlspecialchars($_SESSION['usuario_rol'] ?? '') ?></span>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="?controller=auth&action=logout">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid main-container">
