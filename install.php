<?php
/**
 * Script de Verificación e Instalación
 * Ejecutar en: http://localhost/inventario/install.php
 */

// Evitar que se ejecute si la app ya está instalada
if (file_exists(__DIR__ . '/data/database.sqlite')) {
    // Opcional: permite reinstalar
    // unset la restricción abajo
}

$errors = [];
$warnings = [];
$success = [];

// Verificar PHP
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    $errors[] = "PHP " . PHP_VERSION . " - Se requiere PHP 7.4 o superior";
} else {
    $success[] = "PHP " . PHP_VERSION . " ✓";
}

// Verificar extensiones
$requiredExtensions = ['pdo', 'pdo_sqlite', 'mbstring'];
foreach ($requiredExtensions as $ext) {
    if (!extension_loaded($ext)) {
        $errors[] = "Extensión $ext no está habilitada";
    } else {
        $success[] = "Extensión $ext habilitada ✓";
    }
}

// Verificar permisos de directorio
$directories = [
    'data' => 'data/',
    'view' => 'view/',
    'controller' => 'controller/',
    'model' => 'model/',
];

foreach ($directories as $name => $dir) {
    if (!is_dir($dir)) {
        $errors[] = "Directorio $name ($dir) no encontrado";
    } else if (!is_writable($dir) && $name === 'data') {
        $warnings[] = "Directorio $name ($dir) no tiene permisos de escritura";
    } else {
        $success[] = "Directorio $name ($dir) ✓";
    }
}

// Verificar archivos críticos
$criticalFiles = [
    'bootstrap.php' => 'bootstrap.php',
    'index.php' => 'index.php',
    'lib/Database.php' => 'lib/Database.php',
    'lib/conf/config.php' => 'lib/conf/config.php',
];

foreach ($criticalFiles as $name => $file) {
    if (!file_exists($file)) {
        $errors[] = "Archivo crítico no encontrado: $file";
    } else {
        $success[] = "Archivo $file ✓";
    }
}

// Intentar crear directorio de datos
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    if (@mkdir($dataDir, 0755, true)) {
        $success[] = "Directorio de datos creado ✓";
    } else {
        $errors[] = "No se puede crear el directorio data/";
    }
}

// Inicializar base de datos
$initDb = false;
if (empty($errors)) {
    try {
        require_once 'bootstrap.php';
        $initDb = true;
        $success[] = "Base de datos inicializada ✓";
    } catch (Exception $e) {
        $errors[] = "Error al inicializar BD: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - Inventario de Computadores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 30px;
            margin-top: 20px;
        }
        h1 {
            color: #667eea;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        .list-group-item {
            border-left: 4px solid #ccc;
            margin-bottom: 5px;
        }
        .success {
            border-left-color: #28a745;
            color: #155724;
            background-color: #d4edda;
        }
        .error {
            border-left-color: #dc3545;
            color: #721c24;
            background-color: #f8d7da;
        }
        .warning {
            border-left-color: #ffc107;
            color: #856404;
            background-color: #fff3cd;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .status-badge {
            font-size: 14px;
            margin-top: 20px;
        }
        .next-steps {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 700px;">
        <h1><i class="fas fa-cog"></i> Verificación de Instalación</h1>

        <div class="list-group">
            <?php foreach ($success as $msg): ?>
                <div class="list-group-item success">
                    <strong>✓ Correcto:</strong> <?= htmlspecialchars($msg) ?>
                </div>
            <?php endforeach; ?>

            <?php foreach ($warnings as $msg): ?>
                <div class="list-group-item warning">
                    <strong>⚠ Advertencia:</strong> <?= htmlspecialchars($msg) ?>
                </div>
            <?php endforeach; ?>

            <?php foreach ($errors as $msg): ?>
                <div class="list-group-item error">
                    <strong>✗ Error:</strong> <?= htmlspecialchars($msg) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="status-badge">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <h5>❌ Hay errores que deben corregirse</h5>
                    <p>Por favor, revisa los errores anteriores antes de continuar.</p>
                </div>
            <?php elseif (!empty($warnings)): ?>
                <div class="alert alert-warning">
                    <h5>⚠️ La instalación tiene advertencias</h5>
                    <p>Es recomendable revisar las advertencias, pero puedes continuar.</p>
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    <h5>✅ La instalación se completó correctamente</h5>
                    <p>El sistema está listo para usar.</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if (empty($errors)): ?>
            <div class="next-steps">
                <h5><i class="fas fa-arrow-right"></i> Próximos Pasos</h5>
                <ol>
                    <li>
                        <a href="web/" class="btn btn-primary btn-sm">
                            <i class="fas fa-sign-in-alt"></i> Acceder a la Aplicación
                        </a>
                    </li>
                    <li style="margin-top: 10px;">
                        Usuarios de prueba:
                        <ul>
                            <li><strong>admin</strong> / admin123</li>
                            <li><strong>empleado</strong> / empleado123</li>
                            <li><strong>usuario</strong> / usuario123</li>
                        </ul>
                    </li>
                    <li style="margin-top: 10px;">
                        Lee el archivo <code>GUIA_RAPIDA.md</code> para comenzar
                    </li>
                </ol>
            </div>

            <div class="info-box">
                <strong>📝 Nota:</strong> Esta página se puede eliminar después de instalar.
                El sistema verificará automáticamente los requisitos en futuros accesos.
            </div>
        <?php else: ?>
            <div class="alert alert-info" style="margin-top: 20px;">
                <strong>💡 Ayuda:</strong> Si no sabes cómo resolver estos errores,
                revisa el archivo <code>GUIA_RAPIDA.md</code> o <code>README.md</code>
            </div>
        <?php endif; ?>

        <hr style="margin: 30px 0;">

        <div class="text-center text-muted">
            <small>Sistema de Inventario de Computadores v1.0</small>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
